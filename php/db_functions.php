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
    if ($tags !== null) {
        db_insert_tags($tags, $resultat);
    }
}


function db_insert_tags($tags, $imageId) {
// get Connection
    $conn = getValue('cfg_db');
    foreach ($tags as $tagId) {
        /* check DB connection */
        if (checkConnection()) {
            /* create a prepared statement */
            if ($stmt = $conn->prepare("insert into image_tag (image_id, tag_id) values (?,?)")) {

                /* bind parameters*/
                $stmt->bind_param("ii", $imageId, $tagId);

                /* execute query */
                $stmt->execute();

                /* close statement */
                $stmt->close();
            }
        }
    }
}

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

