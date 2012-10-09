<?php

/*
 * Member view page
 */


$checkuserlevel = $objKongreg8->checkAccessLevel('Members');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once('application/members/memberControl.php');

$objMember = new memberControl();

require_once('application/campus/campus.php');
$objCampus = new campus();



if($_GET['m'] != ""){
    $memberid = db::escapechars($_GET['m']);
    $member = $objMember->viewMember($memberid);
}
else{
    $errorMsg = "<p>Error! No member ID specified - cannot display the data</p>";
}
require_once ('modules/members/view.php');
?>
