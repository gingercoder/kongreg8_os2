<?php

/*
 * View Group Members
 */

require_once('application/groups/groups.php');
$objGroup = new groups();



if(db::escapechars($_POST['g']) != ""){
    $groupid = db::escapechars($_POST['g']);
}
if(db::escapechars($_GET['g']) != ""){
    $groupid = db::escapechars($_GET['g']);
}

// ADD A NEW MEMBER TO THE GROUP
if($_POST['action'] == "add"){
    // Confirm which member you mean
    if($_POST['membername'] !=""){
        $memberlist = $objGroup->findMemberToAdd(db::escapechars($_POST['membername']), $groupid);
        $toggleMessage = "<p class=\"updated\">Please Select the correct member:<br/>" . $memberlist . "</p>";
    }
    else{
        $errorMsg =  "You need to provide a name of a church member";
    }
}
if($_GET['action'] == "add"){
    // Confirmation of member so add the person
    if(($_GET['m'] !="")&&($groupid !="")){
        
        $popuser = $objGroup->addMemberToGroup($groupid, db::escapechars($_GET['m']));
        
        if($popuser == 'true'){
            $toggleMessage = "<p class=\"updated\">Your church member has been added to the group</p>";
        }
        else{
            $errorMsg = "Something went wrong and your member could not be added. Please try again, this error has been logged.";
        }
        
    }
    else{
        $errorMsg = "Missing information, please try again";
    }
    
    
}

// REMOVE A MEMBER FROM THE GROUP
if($_GET['action'] == "remove"){
    if(($_GET['m'] !="")&&($groupid !="")){
        
        if($_GET['confirm'] == 'true'){
            $removemember = $objGroup->removeMemberFromGroup($groupid, db::escapechars($_GET['m']));
            if($removemember == 'true'){
                $toggleMessage = "<p class=\"updated\">Your church member has been removed from the group</p>";
            }
            else{
                $errorMsg = "Something went wrong and your member could not be removed. Please try again, this error has been logged.";
            }
        }
        else{
            $toggleMessage = "<p class=\"confirm\">Are you SURE you want to remove this member from the group?
                                <a href=\"index.php?mid=321&g=$groupid&action=remove&confirm=true&m=".db::escapechars($_GET['m'])."\">Yes, I agree</a>.
                                ";
        }
    }
    else{
        $errorMsg = "Missing information, can't remove the member - please try again.";
    }
    
}

// CHANGE THE GROUP LEADER
if($_GET['action'] == "setleader"){
    
    $setleader = $objGroup->changeGroupLeader($groupid, db::escapechars($_GET['m']));
    if($setleader == 'true'){
                $toggleMessage = "<p class=\"updated\">Your new member has been set</p>";
            }
            else{
                $errorMsg = "Something went wrong and your member could not be set as the leader at this time.";
            }
    
}


require_once('modules/groups/viewMembers.php');



?>
