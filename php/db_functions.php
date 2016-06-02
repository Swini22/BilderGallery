<?php
function db_get_email($email) {
	return sqlSelect("select * from user where email='".$email."'");
}

function db_get_user($userId) {
	return sqlSelect("select * from user where id_user=".$userId);
}

function db_insert_user($params, $password) {
    $sql = "insert into user (username, email, password)
            values ('".escapeSpecialChars($params['username'])."','".escapeSpecialChars($params['email'])."','".$password."')";
    sqlQuery($sql);
}

function db_insert_gallery($params) {
    $sql = "insert into gallery (user_id, name)
            values ('".escapeSpecialChars($_SESSION['userId'])."','".escapeSpecialChars($params['albumName'])."')";
    sqlQuery($sql);
}

function db_select_all_gallerys() {
    return sqlSelect("select * from gallery where user_id=" .$_SESSION['userId']);
}

function db_get_gallery_by_id($id) {
    return sqlSelect("select * from gallery where id_gallery=" .$id);
}

function db_select_all_Images_by_id($galleryId) {
    return sqlSelect("select * from image where gallery_id=" .$galleryId);
}