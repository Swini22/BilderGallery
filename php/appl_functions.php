<?php
/*
 *  @autor Michael Abplanalp
 *  @version 1.0
 *
 *  Dieses Modul beinhaltet Funktionen, welche die Anwendungslogik implementieren.
 *
 */


/*
 * Beinhaltet die Anwendungslogik zur Anzeige und zum Bearbeiten von allen Fotoalben
 */
function fotoalben() {
    getAllGallerys();

    setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=" . __FUNCTION__);
    return runTemplate("../templates/fotoalben.htm.php");
}

/*
 * Beinhaltet die Anwendungslogik zum Hinzufügen eines Fotoalbums
 */
function album() {
    // Der Schaltknopf "senden" wurde betätigt
    if (isset($_REQUEST['senden'])) {
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
            setValue('meldung', "album created successfully.");
        }
        // Der Schaltknopf "abbrechen" wurde betätigt
    } else if (isset($_REQUEST['abbrechen'])) {
        redirect(__FUNCTION__);
        exit;
    }
    // Template abfüllen und Resultat zurückgeben
    setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=" . __FUNCTION__);
    return runTemplate("../templates/album.htm.php");
}

function saveThumbnail($image, $path, $thumbname) {

    $width = getimagesize($image['tmp_name'])[0];
    $height = getimagesize($image['tmp_name'])[1];
    // calculate thumbnail size
    $new_height = 120;
    $new_width = floor($width * ($new_height / $height));;

    list(, , $type) = getimagesize($image['tmp_name']);
    $type = image_type_to_extension($type);

    $getResourceOfImage = 'imagecreatefrom' . $type;
    $getResourceOfImage = str_replace('.', '', $getResourceOfImage);
    $img = $getResourceOfImage($image["tmp_name"]);

// create a new temporary image
    $tmp_img = imagecreatetruecolor($new_width, $new_height);
// copy and resize old image into new image
    imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
// save thumbnail into a file
    imagejpeg($tmp_img, "{$path}{$thumbname}");
    return $path . $thumbname;
}

/*
 * Beinhaltet die Anwendungslogik zum auslesen aller Fotoalben
 */
function getAllGallerys() {
    $galleryList = db_select_all_gallerys();
    setValue('galleryList', $galleryList);
}

/*
 * Beinhaltet die Anwendungslogik zum Hinzufügen von Fotos zu einem Album
 */
function fotos() {
    if (isset($_POST["delete"])) {
        var_dump($_POST);
    }

    // Template abfüllen und Resultat zurückgeben
    setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=" . __FUNCTION__);
    return runTemplate("../templates/fotos.htm.php");
}

function foto() {
    if (isset($_POST["upload"])) {
        $target_dir = "../images/" . $_SESSION['userId'] . '/';
        if (!is_dir($target_dir))
            mkdir($target_dir);
        $target_extension = explode('.', basename($_FILES["fileToUpload"]["name"]))[1];
        $target_name = uniqid();
        $target_filepath = $target_dir . $target_name . '.' . $target_extension;
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $tags = null;

            if (isset($_POST["tags"])) {
                $tags = $_POST["tags"];
            }
            $thumbnailPath = saveThumbnail($_FILES["fileToUpload"], $target_dir, $target_name . ".thumb." . $target_extension);
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_filepath);
            db_insert_image($_SESSION['recentGallery'], $target_filepath, $thumbnailPath, $tags);
        } else {
            echo "File is not an image.";
        }
    }
    // Template abfüllen und Resultat zurückgeben
    setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=" . __FUNCTION__);
    return runTemplate("../templates/foto.htm.php");
}

function getAllFotos($id) {
    $imageList = db_select_all_Images_by_id($id);
    setValue('imageList', $imageList);
}

/*
 * Prüft, ob der Primary Key "email" in der Tabelle "user" bereits existiert
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
            if (strlen($user[0]['username']) > 0) $userName = $user[0]['username'];
            // Ansonsten die Mailadresse verwenden
            else $userName = $user[0]['email'];
        }
    }
    return $userName;
}

function checkAlbum() {
    global $css_classes;
    $fehlermeldung = "";
    if (empty($_REQUEST['albumName'])) {
        $fehlermeldung .= "please fill in the album name.";
    }
    return $fehlermeldung;
}

function prepareImages($id) {
    $recentGallery = db_get_gallery_by_id($id);
    setValue('recentGallery', $recentGallery[0]);
    getAllFotos($recentGallery[0]['id_gallery']);
}

function setFirstFotoPath($galleryId) {
    $images = db_select_gallery_teaser($galleryId);
    if ($images == null) {
        setValue('path', '../default_images/default.png');
    } else {
        setValue('path', $images['thumbnail']);
    }
}

function setTags() {
    $tags = db_get_all_tags();
    setValue('tags', $tags);
}

?>
