<?php

/*
 * View all reports available to you
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('Reports');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once ('application/reports/reports.php');
$objReports = new reports();

require_once('modules/reports/home.php');
?>
