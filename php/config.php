<?php

// Default-CSS-Klasse zur Formatierung der Eingabefelder
setValue('cfg_css_class_normal',"txt");
// Klasse zur Formatierung der Eingabefelder, falls die Eingabeprüfung negativ ausfällt
setValue('cfg_css_class_error',"err");
// Akzeptierte Funktionen Login
setValue('cfg_func_login', array("login","registration"));
// Akzeptierte Funktionen Memberbereich
setValue('cfg_func_member', array("fotoalben","album","fotos","logout","foto","userchange"));
// Inhalt des Login-Menus
setValue('cfg_menu_login', array("login"=>"Login","registration"=>"Registration"));
// Inhalt des Menus im Memberbereich
setValue('cfg_menu_member', array("fotoalben"=>"Gallery Overwiew", "album"=>"Add Gallery"));
// Inhalt des Meta-Menus im Loginbereich
setValue('cfg_meta_menu_login', array("dummy"=>""));
// Inhalt des Meta-Menus im Memberbereich
setValue('cfg_meta_menu_member', array("userdaten"=>"","logout"=>"Logout"));

// Datenbankverbindung herstellen
$db = mysqli_connect("127.0.0.1", "root", "", "bilderdb");	// Zu Datenbankserver verbinden
setValue('cfg_db', $db);
?>