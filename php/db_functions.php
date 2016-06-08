<?php


/** wird verwendet um zu testen ob die Email existiert
 * oder um die userdaten via email aus der db zu lesen
 * @param $email
 */
function db_get_email($email) {
    /* get connection */
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from user where email= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", $email);

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* now fetch the results into an array */
            while ($myrow = $result->fetch_assoc())
                $resultat = $myrow;

            /* close statement */
            $stmt->close();
        }
        return $resultat;
    }
}

/** wird verwendet um userdaten auszulesen via id
 * @param $userId
 */
function db_get_user($userId) {
// get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from user where id_user= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", $userId);

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* now fetch the results into an array */
            while ($myrow = $result->fetch_assoc())

                $resultat = $myrow;

            /* close statement */
            $stmt->close();
        }
        return $resultat;
    }
}


/** wird verwendet um ein image auszulesen via id mit den ganzen tags
 * (wird für update verwendet um zu prüfen welche tags bereits vorhanden sind)
 * @param $imageId
 */
function db_select_image_By_id_with_tags($imageId) {
// get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from image_tag it INNER JOIN image i on it.image_id = i.id_image where it.image_id= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", $imageId);

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* now fetch the results into an array */
            while ($myrow = $result->fetch_assoc())
                $resultat[] = $myrow;
            /* close statement */
            $stmt->close();
        }

        return $resultat;
    }
}

/** wird verwendet um ein image auszulesen via id
 * (wird für update verwendet um das bild oben anzuzeigen und die id weiterzuleiten)
 * @param $imageId
 */
function db_select_image_By_id($imageId) {
// get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from image where id_image= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", $imageId);

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* now fetch the results into an array */
            while ($myrow = $result->fetch_assoc())
                $resultat = $myrow;
            /* close statement */
            $stmt->close();
        }

        return $resultat;
    }
}

/** wird verwendet um ein user anzulegen
 * (wird für die registrierung verwendet)
 * @param $params, $password
 */
function db_insert_user($params, $password) {
// get Connection
    $conn = getValue('cfg_db');

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("insert into user (username, email, password) values (?,?,?)")) {

            /* bind parameters*/
            $stmt->bind_param("sss", escapeSpecialChars($params['username']), escapeSpecialChars($params['email']), $password);

            /* execute query */
            $stmt->execute();

            /* close statement */
            $stmt->close();
        }
    }
}

/** wird verwendet um eine neue gallery anzulegen
 * @param $params
 */
function db_insert_gallery($params) {
// get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("insert into gallery (user_id, name) values (?,?)")) {

            /* bind parameters*/
            $stmt->bind_param("is", $_SESSION['userId'], $params['albumName']);

            /* execute query */
            $stmt->execute();

            /* close statement */
            $stmt->close();
        }
    }
}

/** wird verwendet um alle gallerys des angemeldeten users auszulesen.
 * (wird gebraucht um die gallery Overview aufzubauen und um einen user zu löschen damit keine leichen entstehen)
 */
function db_select_all_gallerys() {
// get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from gallery where user_id= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", $_SESSION['userId']);

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* now fetch the results into an array */
            while ($myrow = $result->fetch_assoc())
                $resultat[] = $myrow;


            /* close statement */
            $stmt->close();
        }
        return $resultat;
    }
}

/** wird verwendet um eine gallery zu holen mit der passenden gallery id
 * (wird vor allem verwendet um die von Seite zu Seite weitergeleitete id wieder mit einer gallery abzufüllen)
 * @param $gallery_id
 */
function db_get_gallery_by_id($gallery_id) {
// get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from gallery where id_gallery= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", $gallery_id);

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* now fetch the results into an array */
            while ($myrow = $result->fetch_assoc())

                $resultat = $myrow;

            /* close statement */
            $stmt->close();
        }
        return $resultat;
    }
}

/** wird verwendet um alle images einer bestimmten gallery id zu holen.
 * (wird vor allem verwendet um alle images anzuzeigen oder um nur das erste
 * thumbnail der gallery in der Overview darzustellen und auch um alle bilder
 * einer gallerie sauber zu löschen.)
 *
 * @param $galleryId
 */
function db_select_all_Images_by_id($galleryId) {
// get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from image where gallery_id= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", $galleryId);

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* now fetch the results into an array */
            while ($myrow = $result->fetch_assoc())
                $resultat[] = $myrow;


            /* close statement */
            $stmt->close();
        }
        return $resultat;
    }
}


/** wird verwendet ein images zu erstellen, mit allen
 * dazugehörigen tags (ist in 2 methoden gespalten).
 *
 * @param $galleryId, $imagePath, $thumbnailpath, $tags
 */
function db_insert_image($galleryId, $imagePath, $thumbnailpath, $tags) {
// get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("insert into image (gallery_id, image_link, thumbnail) values (?,?,?)")) {

            /* bind parameters*/
            $stmt->bind_param("iss", $galleryId, $imagePath, $thumbnailpath);

            /* execute query */
            $stmt->execute();

            /* get id */
            $resultat = mysqli_insert_id($conn);

            /* close statement */
            $stmt->close();
        }
    }
    if ($tags != null) {
        db_insert_tags($tags, $resultat);
    }
}

/** wird verwendet ein images zu erstellen, 2. teil!
 * hier werden nun die tags (falls denn welche da sind)
 * in dieser methode der zwischentabelle hinzugefügt
 *
 * @param $tags, $imageId
 */
function db_insert_tags($tags, $imageId) {
// get Connection
    $conn = getValue('cfg_db');
    foreach ($tags as $tagId) {
        /* check DB connection */
        if (checkConnection()) {
            /* create a prepared statement */
            if ($stmt = $conn->prepare("insert into image_tag (image_id, tag_id) values (?,?)")) {

                /* bind parameters*/
                $stmt->bind_param("ss", $imageId, $tagId);

                /* execute query */
                $stmt->execute();

                /* close statement */
                $stmt->close();
            }
        }
    }
}

/** wird verwendet um alle existierenden tags auszulesen
 * (wird gebracht um sie anzuzeigen für den filter oder für das image hinzufügen
 *
 */
function db_get_all_tags() {
// get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from tag")) {

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* now fetch the results into an array */
            while ($myrow = $result->fetch_assoc())
                $resultat[] = $myrow;


            /* close statement */
            $stmt->close();
        }
        return $resultat;
    }
}

/** wird verwendet um alle tags eines bestimmten images zu holen
 * (wird gebracht um die bereits vorhandenen tags des images anzuzeigen)
 * @param $imageId
 */
function db_get_all_tags_by_ImageId($imageId) {
// get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from image_tag it INNER JOIN tag t on it.tag_id = t.id_tag where it.image_id= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", $imageId);

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* now fetch the results into an array */
            while ($myrow = $result->fetch_assoc())
                $resultat[] = $myrow;


            /* close statement */
            $stmt->close();
        }
        return $resultat;
    }
}

/** wird verwendet um den user zu löschen! sucht alle gallerys des
 * useres und löscht auch diese (siehe db_delete_gallery)
 * @param $user_id
 */
function db_delete_user($user_id) {
    $gallerys = db_select_all_gallerys($user_id);
    if ($gallerys != null) {
        foreach ($gallerys as $gallery) {
            db_delete_gallery($gallery['id_gallery']);
        }
    }
    // get Connection
    $conn = getValue('cfg_db');
    /* check DB connection */
    if (checkConnection()) {
        if ($stmt = $conn->prepare("delete from user where id_user= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", escapeSpecialChars($user_id));

            /* execute query */
            $stmt->execute();

            /* close statement */
            $stmt->close();
        }
    }
}

/** wird verwendet um eine gallery zu löschen! sucht alle images der
 * gallery und löscht auch diese (siehe db_delete_image)
 * @param $gallery_id
 */
function db_delete_gallery($gallery_id) {
    $images = db_select_all_Images_by_id($gallery_id);
    if ($images != null) {
        foreach ($images as $image) {
            db_delete_image($image['id_image']);
        }
    }
    $conn = getValue('cfg_db');
    /* check DB connection */
    if (checkConnection()) {

        /* create a prepared statement */
        if ($stmt = $conn->prepare("delete from gallery where id_gallery= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", escapeSpecialChars($gallery_id));

            /* execute query */
            $stmt->execute();

            /* close statement */
            $stmt->close();
        }
    }
}

/** wird verwendet um ein image zu löschen! ruft
 * db_delete_all_tags_from_image auf um auch die tags zu löschen
 * ruft ebenso delete_files auf um dazugehörige
 * thumbnails und images im filesystem zu löschen
 *
 * @param $image_id
 */
function db_delete_image($image_id) {
    delete_files($image_id);
    db_delete_all_tags_from_image($image_id);
    // get Connection
    $conn = getValue('cfg_db');
    /* check DB connection */
    if (checkConnection()) {

        /* create a prepared statement */
        if ($stmt = $conn->prepare("delete from image where id_image= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", escapeSpecialChars($image_id));

            /* execute query */
            $stmt->execute();

            /* close statement */
            $stmt->close();
        }
    }
}

/** wird verwendet um alle tags eines image zu löschen!
 *
 * @param $image_id
 */
function db_delete_all_tags_from_image($image_id) {
    // get Connection
    $conn = getValue('cfg_db');
    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("delete from image_tag where image_id= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", escapeSpecialChars($image_id));

            /* execute query */
            $stmt->execute();

            /* close statement */
            $stmt->close();
        }
    }
}

/** wird verwendet um dazugehörige
 * thumbnails und images eines datensatzes im filesystem zu entfernen.
 *
 * @param $image_id
 */
function delete_files($image_id) {
    // get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from image where id_image= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", $image_id);

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* now fetch the results into an array */
            while ($myrow = $result->fetch_assoc())

                $resultat = $myrow;

            /* close statement */
            $stmt->close();
        }
        unlink($resultat['thumbnail']);
        unlink($resultat['image_link']);
    }
}

/** wird für die Filterfunktion verwendet um bilder einer bestimmten
 * galerie zu laden welche nur den gefilterten tag besitzen
 *
 * @param $galleryId, $tagId
 */
function db_search_Images_by_ids($galleryId, $tagId) {
    // get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from image_tag it INNER JOIN image i on it.image_id = i.id_image where i.gallery_id= ? and it.tag_id= ?")) {

            /* bind parameters*/
            $stmt->bind_param("ss", $galleryId, $tagId);

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* now fetch the results into an array */
            while ($myrow = $result->fetch_assoc())
                $resultat[] = $myrow;


            /* close statement */
            $stmt->close();
        }
        return $resultat;
    }
}

/** wird für das updaten des Users verwendet
 *
 * @param $username, $password, $userId
 */
function db_change_user($username, $password, $userId) {
    // get Connection
    $conn = getValue('cfg_db');

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("update user set username=?, password=? where id_user=?")) {

            /* bind parameters*/
            $stmt->bind_param("sss", $username, $password, $userId);

            /* execute query */
            $stmt->execute();

            /* close statement */
            $stmt->close();
        }
    }
}

/** wird für das updaten der gallery verwendet
 *
 * @param $albumName, $id_gallery
 */
function db_update_gallery($albumName, $id_gallery) {
    // get Connection
    $conn = getValue('cfg_db');

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("update gallery set name=? where id_gallery=?")) {

            /* bind parameters*/
            $stmt->bind_param("ss", $albumName, $id_gallery);

            /* execute query */
            $stmt->execute();

            /* close statement */
            $stmt->close();
        }
    }
}

/** wird für das updaten des images verwendet
 * (ruft db_delete_all_tags_from_image auf um bereits vorhandene tags zu entfernen
 * und ruft anschliessend db_insert_tags auf um die neu mitgegebenen[falls vorhandenen]
 * tags wieder hinzuzufügen!)
 *
 * @param $albumName, $id_gallery
 */
function db_update_image_tags($image_id, $tags) {
    db_delete_all_tags_from_image($image_id);
    if ($tags != null) {
        db_insert_tags($tags, $image_id);
    }
}
