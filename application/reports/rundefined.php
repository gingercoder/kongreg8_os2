<?php

/*
 * Run one of the pre-defined reports from the system
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('Reports');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once ('application/reports/reports.php');
$objReports = new reports();

if($_GET['prid'] ==""){
    // Report id not provided so cannot product report
    
}
else{
    // run the pre-defined report.
    require_once('modules/reports/runpredefined.php');
}
?>
