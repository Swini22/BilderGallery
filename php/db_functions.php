<?php
function db_get_email($email) {
    return sqlSelect("select * from user where email='" . $email . "'");
}

function db_get_user($userId) {
    return sqlSelect("select * from user where id_user=" . $userId);
}

function db_insert_user($params, $password) {
    $sql = "insert into user (username, email, password)
            values ('" . escapeSpecialChars($params['username']) . "','" . escapeSpecialChars($params['email']) . "','" . $password . "')";
    sqlQuery($sql);
}

function db_insert_gallery($params) {
    $sql = "insert into gallery (user_id, name)
            values ('" . escapeSpecialChars($_SESSION['userId']) . "','" . escapeSpecialChars($params['albumName']) . "')";
    sqlQuery($sql);
}

function db_select_all_gallerys() {
    return sqlSelect("select * from gallery where user_id=" . $_SESSION['userId']);
}

function db_get_gallery_by_id($id) {
    return sqlSelect("select * from gallery where id_gallery=" . $id);
}

function db_select_all_Images_by_id($galleryId) {
    $images = sqlSelect("select * from image where gallery_id=" . $galleryId);

    return ($images == '') ? null: $images;
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
