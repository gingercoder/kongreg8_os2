<?php

/*
 * Add member form which is pre-populated by the previous entry information
 * to allow adding similar entries like family members or co-occupants
 */

require_once('application/members/memberControl.php');
$objMember = new memberControl();
require_once('application/campus/campus.php');
$objCampus = new campus();

if($_GET['lastid'] ==""){
    // No ID passed for the previous item so cannot process anything
    print "<div class=\"contentBox\"><h1>Error!</h1><p>No previous member ID passed, cannot process a new entry.</p></div>";
    
    
}
else{
    // create the form with pre-populated information
    
    $lastid = db::escapechars($_GET['lastid']);
    $member = $objMember->viewMember($lastid);
    
}
require_once('modules/members/addsimilar.php');
?>
