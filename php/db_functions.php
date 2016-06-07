<?php
function db_get_email($email) {
// get Connection
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

// function db_select_all_gallerys() {
//     return sqlSelect("select * from gallery where user_id=" . $_SESSION['userId']);
// }

function db_get_gallery_by_id($id) {
// get Connection
    $conn = getValue('cfg_db');
    $resultat = NULL;

    /* check DB connection */
    if (checkConnection()) {
        /* create a prepared statement */
        if ($stmt = $conn->prepare("select * from gallery where id_gallery= ?")) {

            /* bind parameters*/
            $stmt->bind_param("s", $id);

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
function db_select_all_Images_by_id($galleryId) {
    $images = sqlSelect("select * from image where gallery_id=" . $galleryId);

    return ($images == '') ? null : $images;
}

function db_select_gallery_teaser($galleryId) {
    $teaser = sqlSelect("select * from image where gallery_id=" . $galleryId);
    return ($teaser == '') ? null : $teaser[0];
}

function db_insert_image($galleryId, $imagePath, $thumbnailpath, $tags) {
    $sql = "insert into image (gallery_id, image_link, thumbnail)
            values ($galleryId,'" . escapeSpecialChars($imagePath) . "','" . escapeSpecialChars($thumbnailpath) . "')";
    $imageId = sqlQuery($sql);
    if ($tags !== null) {
        db_insert_tags($tags, $imageId);
    }
}

function db_insert_tags($tags, $imageId) {
    foreach ($tags as $tagId) {
        $sql = "insert into image_tag (image_id, tag_id)
            values ($imageId, $tagId)";
        sqlQuery($sql);
    }
}

function db_get_all_tags() {
    return sqlSelect("select * from tag");
}

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

