<?php
/**
 * Created by Aswina Zizzari.
 * User: vmadmin
 * Date: 07.06.2016
 * Time: 11:02
 */

header("Content-type: image/jpeg");
    $bild=$_GET['bild'];
    if(substr( $bild, 0, 10 ) === "../images/" ){
        readfile("$bild");
    }
