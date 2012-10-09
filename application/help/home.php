<?php

/*
 * Help System
 */
$checkuserlevel = $objKongreg8->checkAccessLevel($_SESSION['Kusername'], 'Help');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}
require_once('modules/help/home.php');
?>
