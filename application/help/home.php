<?php

/*
 * Help System
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('Help System');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once('modules/help/home.php');
?>
