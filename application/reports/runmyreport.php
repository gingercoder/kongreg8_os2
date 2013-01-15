<?php

/*
 * My Reports System - run a defined report
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('My Reports');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once ('application/reports/reports.php');
$objReports = new reports();

require_once('modules/reports/runmyreport.php');

?>
