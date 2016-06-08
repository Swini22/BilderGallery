<?php

/*
 * diese Funktion ist für das handling auf der Seite fotoalben verantwortlich
 * welche gallerys löschen kann und die weiterleitung zum editieren übernimmt.
 */
function fotoalben() {
    // Der Schaltknopf "delete" wurde betätigt
    if (isset($_POST["delete"])) {
        db_delete_gallery($_POST["gallery_id"]);
    }
    if (isset($_POST["edit"])) {
        // Template abfüllen und Resultat zurückgeben
        $gallery_id = $_REQUEST['gallery_id'];
        redirect("album&galleryid=".$gallery_id);
        // setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=album&galleryid=".$gallery_id);
        // return runTemplate("../templates/album.htm.php");
    }

    getAllGallerys();
    setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=" . __FUNCTION__);
    return runTemplate("../templates/fotoalben.htm.php");
}

/*
 * diese Funktion ist für das handling auf der Seite album verantwortlich
 * welche gallerys erstellen und beriets vorhandene editieren kann
 */
function album() {
    // Der Schaltknopf "send" wurde betätigt
    if (isset($_REQUEST['send'])) {
        $fehlermeldung = checkAlbum();
        // Wenn ein Fehler aufgetreten ist
        if (strlen($fehlermeldung) > 0) {
            setValue('css_class_meldung', "alert-warning show");
            setValue('meldung', $fehlermeldung);
            setValues($_REQUEST);
            // Wenn alles ok
        } else {
            db_insert_gallery($_REQUEST);
            setValue('css_class_meldung', "alert-info show");
            setValue('meldung', "gallery successfully created.");
        }
    }
    else if (isset($_REQUEST['edit'])) {
        $fehlermeldung = checkAlbum();
        // Wenn ein Fehler aufgetreten ist
        if (strlen($fehlermeldung) > 0) {
            setValue('css_class_meldung', "alert-warning show");
            setValue('meldung', $fehlermeldung);
            setValues($_REQUEST);
            // Wenn alles ok
            $_GET['galleryid']= $_REQUEST["gallery_id"];
            
        } else {
            db_update_gallery($_REQUEST["albumName"],$_REQUEST["gallery_id"]);
            setValue('css_class_meldung', "alert-info show");
            setValue('meldung', "gallery successfully updated.");
            redirect("fotoalben");
            exit;
        }
    }
    else if (isset($_REQUEST['break'])) {
        redirect(__FUNCTION__);
        exit;
    }
    else if (isset($_REQUEST['stop'])) {
    redirect("fotoalben");
    exit;
}
    // Template abfüllen und Resultat zurückgeben
    setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=" . __FUNCTION__);
    return runTemplate("../templates/album.htm.php");
}

/*
 * diese Funktion erstellt ein kleineres image (thumbnail)
 * und speichert es dan auf dem filesystem.
 */
function saveThumbnail($image, $path, $thumbname) {
    $width = getimagesize($image['tmp_name'])[0];
    $height = getimagesize($image['tmp_name'])[1];
    // berechne (neue)thumbnail size
    $new_height = 120;
    $new_width = floor($width * ($new_height / $height));;

    // getimagesize in eine liste holen
    list(, , $type) = getimagesize($image['tmp_name']);
    // dateiendung holen
    $type = image_type_to_extension($type);

// vorberieten einer methode welche das effektive file eines imagepfades ladet
    $getResourceOfImage = 'imagecreatefrom' . $type;
    $getResourceOfImage = str_replace('.', '', $getResourceOfImage);
    $img = $getResourceOfImage($image["tmp_name"]);

// erstellt ein neues temporäres image
    $tmp_img = imagecreatetruecolor($new_width, $new_height);
// kopiert und verändert die grösse vom alten image in das neue image
    imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
// speichert das image (thumbnail) in ein file
    imagejpeg($tmp_img, "{$path}{$thumbname}");
    return $path . $thumbname;
}

/*
 * Beinhaltet die Anwendungslogik zum auslesen aller gallerys
 */
function getAllGallerys() {
    $galleryList = db_select_all_gallerys();
    setValue('galleryList', $galleryList);
}

/*
 * Beinhaltet die Anwendungslogik zum deleten und für die weiterleitung zum editieren von images
 */
function fotos() {
    if (isset($_GET["tag"])) {
        setSessionValue('tag',$_GET["tag"]);
    }
    if (isset($_POST["delete"])) {
        db_delete_image($_POST["foto_id"]);
    }
    if (isset($_POST["edit"])) {
        $idImage = $_POST["foto_id"];
        redirect("foto&image=".$idImage);
    }

    // Template abfüllen und Resultat zurückgeben
    setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=" . __FUNCTION__);
    return runTemplate("../templates/fotos.htm.php");
}

/*
 * diese Funktion ist für das handling auf der seite foto verantwortlich
 * welche bilder hochladen + inserten und beriets vorhandene editieren kann
 * sie hat die teilfunktion saveThumbnail welche ein thumbnail generieren
 * kann und auf dem filesystem speichern
 */
function foto() {
    if (isset($_POST["upload"])) {
        //wenn das file vorhanden ist...
        if ($_FILES["fileToUpload"]["tmp_name"] !== "") {
            //Ordner pfad
            $target_dir = "../images/" . $_SESSION['userId'] . '/';
            //wenn Ordner pfad nicht vorhanden erstelle den Ordner
            if (!is_dir($target_dir))
                mkdir($target_dir);
            //file endung
            $target_extension = explode('.', basename($_FILES["fileToUpload"]["name"]))[1];
            //neuer file name (unique)
            $target_name = uniqid();
            //kompletter pfad mit endung
            $target_filepath = $target_dir . $target_name . '.' . $target_extension;
            //testen ob das file ein image ist und nicht zu gross
            if (@is_array(getimagesize($_FILES["fileToUpload"]["tmp_name"]))) {
                $tags = null;
                //falls es tags gibt diese setzten
                if (isset($_POST["tags"])) {
                    $tags = $_POST["tags"];
                }
                //thumbnail erstellen und pfad zurückgeben zum nachher speichern
                $thumbnailPath = saveThumbnail($_FILES["fileToUpload"], $target_dir, $target_name . ".thumb." . $target_extension);
                //bild ebenso speichern
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_filepath);
                //bild nun endlich mit allem drum und drann in die datenbank speichern
                db_insert_image($_SESSION['recentGallery'], $target_filepath, $thumbnailPath, $tags);
                setValue('css_class_meldung', "alert-info show");
                setValue('meldung', "Image successfully added to gallery.");
            } else {
                setValue('css_class_meldung', "alert-warning show");
                setValue('meldung', "File is not an image.");
            }
        } else {
            setValue('css_class_meldung', "alert-warning show");
            setValue('meldung', "please add an image.");
        }
    }else if (isset($_REQUEST['edit'])) {
        $tags = null;
        if (isset($_POST["tags"])) {
            $tags = $_POST["tags"];
        }
        db_update_image_tags($_REQUEST["image_id"], $tags);
        setValue('css_class_meldung', "alert-info show");
        setValue('meldung', "gallery successfully updated.");
        redirect("fotos");
        exit;
    }else if (isset($_REQUEST['break'])) {
        redirect(__FUNCTION__);
        exit;
    }else if (isset($_REQUEST['stop'])) {
        redirect("fotos");
        exit;
    }
    // Template abfüllen und Resultat zurückgeben
    setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=" . __FUNCTION__);
    return runTemplate("../templates/foto.htm.php");
}

/*
 * eine Funktion um alle fotos einer bestimmten id zu holen
 * (teilfunktion von prepareImages)
 * füllt diese dann in eine globale variable ab
 */
function getAllFotos($galleryId) {
    if(isset($_SESSION['tag'])){
        if($_SESSION['tag']== 0){
            $imageList = db_select_all_Images_by_id($galleryId);
            setValue('imageList', $imageList);
            unsetSessionValue('tag');
        }else {
            $imageList = db_search_Images_by_ids($galleryId, $_SESSION['tag']);
            setValue('imageList', $imageList);
            unsetSessionValue('tag');
        }
    }else{
        $imageList = db_select_all_Images_by_id($galleryId);
        setValue('imageList', $imageList);
    }
}

/*
 * Prüft, ob "email" in der Tabelle "user" bereits existiert
 */
function getUserDaten($email) {
    return db_get_email($email);
}

/*
 * Liefert anhand der User-ID den Usernamen zurück
*/
function getUserName($userId = 0) {
    $userName = "";
    // Wenn die User-ID = 0, wird der aktuell angemeldete User zurückgeliefert
    if ($userId == 0) $userId = getSessionValue('userId');
    if ($userId > 0) {
        $user = db_get_user($userId);
        if (count($user)) {
            // Falls Username vorhanden: diesen Wert holen
            if (strlen($user['username']) > 0) $userName = $user['username'];
            // Ansonsten die Mailadresse verwenden
            else $userName = $user['email'];
        }
    }
    return $userName;
}

function setUserDaten($id) {
    $user = db_get_user($id);
    setValue('user', $user);
}

/*
 * Funktion zur Eingabeprüfung bei dem Album wegen des album namens
 */
function checkAlbum() {
    global $css_classes;
    $fehlermeldung = "";
    if (empty($_REQUEST['albumName'])) {
        $fehlermeldung .= "please fill in the gallery name.";
    }
    if(CheckName($_REQUEST['albumName']) !== true){
        $fehlermeldung .= " Incorrect gallery name format";
    }
    return $fehlermeldung;
}

/*
 * Funktion zur vorbereitung der images oberansicht sucht
 * die passende gallery und die dazugehörigen bilder ruft dazu
 * getAndSetGallery und getAllFotos auf
 */
function prepareImages($id) {
    $recentGallery = getAndSetGallery($id);
    getAllFotos($recentGallery['id_gallery']);
}

/*
 * Ruft die db auf um die Gallery mit der id zu holen füllt
 * diese in eine globale variable ab
 */
function getAndSetGallery($id) {
    $recentGallery = db_get_gallery_by_id($id);
    setValue('recentGallery', $recentGallery);
    return $recentGallery;
}

/*
 * sucht aus der datenbank alle bilder einer bestimmten
 * Gallery und füllt von diesen datensätzen dan nur die
 * thumbnails in eine globale variable ab
 */
function setFirstFotoPath($galleryId) {
    $images = db_select_all_Images_by_id($galleryId);
    if ($images == null) {
        setValue('path', '../images/default_images/default.png');
    } else {
        setValue('path', $images[0]['thumbnail']);
    }
}

/*
 * sucht aus der datenbank alle tags und
 * füllt diese dann in eine globale variable ab
 */
function setTags() {
    $tags = db_get_all_tags();
    setValue('tags', $tags);
}


/*
 * sucht aus der datenbank alle tags eines bildes und
 * füllt diese dann in eine globale variable ab
 * wenn sie nicht leer sind
 */
function getTags($imageId) {
    $tags = db_get_all_tags_by_ImageId($imageId);
    if ($tags !== null) {
        return $tags;
    }else{
        return null;
    }
}

/*
 * sucht aus der datenbank das bild selbst
 * und wenn es hat alle tags des bildes und
 * füllt diese dann in eine globale variable ab
 */
function getImageById($imageId){
    $imageTags = db_select_image_By_id_with_tags($imageId);
    if($imageTags != null){
        setValue("imageTags", $imageTags);
    }else{
        setValue("imageTags", null);
    }
    $image = db_select_image_By_id($imageId);
    setValue("image", $image);

}

/*
 * eine Funktion um zu testen ob die checkboxen für das
 * update nun active sein müssen (also ob das tag bereits
 * in dem bild vorkommt) oder nicht liefert entsprechend
 * true oder false zurück
 */
function checkActive($imageTags, $tagId){
    if($imageTags!= null){
        foreach ($imageTags as $it){
            if($it['tag_id'] == $tagId){
                return true;
            }
        }
    }
    return false;
}

?>
