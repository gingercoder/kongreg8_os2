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
        if( isset($_GET['link']) ){
            if($_GET['confirm'] == "true"){
                $removefamilylink = $objMember->removeFamilyLink($_GET['link']);
                if($removefamilylink == true){
                    $toggleMessage = "<p class=\"updated\">Your family link has been removed</p>";
                }
                else{
                    $errorMsg = "There was an error removing the link, please try again. This fault has been logged.";
                }
            }
            else{
                $toggleMessage = "<p class=\"confirm\">Are you SURE you want to remove this link? <a href=\"index.php?mid=230&m=$memberid&action=remove&link=".$_GET['link']."&confirm=true\">Yes, I agree</a></p>";
            }
        }
        else{
            $errorMsg = "Missing some information, please try again";
        }
    }
    
    // Create a member link
    if(($_POST['action'] == "add") || ($_GET['action'] == "add")){
        if( isset($memberid) ){
            if($_GET['confirm'] == "true"){
                $addfamilylink = $objMember->createFamilyLink($memberid, $_GET['to'], $_GET['relationship']);
                if($addfamilylink == true){
                    $toggleMessage = "<p class=\"updated\">Your family link has been created</p>";
                }
                else{
                    $errorMsg = "There was an error creating the link, please try again. This fault has been logged.";
                }
            }
            else{
                
                $toggleMessage = "<p class=\"confirm\">Please select the correct family member:<br/>";
                $toggleMessage .= $objMember->findMemberToAdd($_POST['personname'], $memberid, $_POST['relationship']);
                $toggleMessage .= " </p>";
            }
            
        }
        else{
            $errorMsg = "Missing member information, please try again";
        }
    }
    
    
}
else{
    $errorMsg = "<p>Error! No member ID specified - cannot display the data</p>";
}

require_once ('modules/members/familymember.php');
?>
