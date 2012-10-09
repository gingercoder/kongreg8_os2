<?php

/*
 * Intrusion Detection System Flags
 */

// If selecting a date range
if($_POST['sdate']!="" && $_POST['edate'] !=""){
    
    $startdate = trim(db::escapechars($_POST['sdate']));
    $enddate = trim(db::escapechars($_POST['edate']));
}
else{
    $startdate = date('Y-m-d', strtotime("-1 week"));
    $enddate = date('Y-m-d');
}

$idsTable = $objFirewall->idsLog($startdate, $enddate);


require_once('modules/admin/ids.php');
?>
