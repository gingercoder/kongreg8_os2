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



if(($_GET['m'] != "")||($_POST['m'] !="")){
    
    if(isset($_GET['m'])){
        $memberid = db::escapechars($_GET['m']);
    }
    else{
        $memberid = db::escapechars($_POST['m']);    
    }
    $member = $objMember->viewMember($memberid);
    
    
    // Remove a member link
    if($_GET['action'] == "remove"){
        
    }
    
    // Create a member link
    if($_POST['action'] == "add"){
        
    }
    
    
}
else{
    $errorMsg = "<p>Error! No member ID specified - cannot display the data</p>";
}

require_once ('modules/members/familymember.php');
?>
