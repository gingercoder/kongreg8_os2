<?php

/*
 * Member removal
 */

$checkuserlevel = $objKongreg8->checkAccessLevel('Members');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once('application/members/memberControl.php');
require_once('application/campus/campus.php');

$objCampus = new campus();
$objMember = new memberControl();

if($_GET['m'] !=""){
    $member = $objMember->viewMember(db::escapechars($_GET['m']));
}

if($_GET['remove'] == 'true'){
    // Process the data sent by the user
    
    if(($_GET['m'] !=="")&&($_GET['confirm'] !==""))
    {
        // Remove the member
        $membername = $member['firstname']." ".$member['surname'];
        $removal = $objMember->remove($_GET['m'], $membername);
        if($removal != 'true')
        {
            $errorMsg = $removal;
        }
        else{
                $toggleMessage = "<p class=\"updated\">The member has been removed from the system.</p>";
        }
    }
    else{
        
	$toggleMessage = "<p class=\"confirm\">Are you SURE you want to remove " . $member['firstname'] . " " . $member['surname'] . " from the system?
                        <a href=\"index.php?mid=235&confirm=true&remove=true&m=" . db::escapechars($_GET['m']) . "\">Yes, I agree</a>
                        ";
    }
   
    $removestate = 1;
    require_once('modules/members/remove.php');
    
}
else{
    // Default input form required for new member
    $toggleMessage = "<p class=\"confirm\">Are you SURE you want to remove " . $member['firstname'] . " " . $member['surname'] . " from the system?
                        <a href=\"index.php?mid=235&confirm=true&remove=true&m=" . db::escapechars($_GET['m']) . "\">Yes, I agree</a>
                        ";
    // Show the input form
    require_once('modules/members/remove.php');
}


?>