<?php

/*
 * User Control Mechanism
 */

require_once('application/members/memberControl.php');
$objMember = new memberControl();



// ADD A NEW USER TO THE SYSTEM
if($_POST['action']=="add"){
    if(($_POST['uname'] !="")&&($_POST['pword1'] == $_POST['pword2'])&&($_POST['pword1'] !="")){
        
        $adduser = $objKongreg8->addUser($_POST['uname'], $_POST['pword1'], $_POST['fname'], $_POST['sname'], $_POST['userlevel'], $_POST['campus'], $_POST['email']);
        if($adduser == true){
            $toggleMessage = "<p class=\"updated\">Your new user has been inserted into the system</p>";
        }
        elseif($adduser == false){
            $errorMsg = "Error inserting new user, please try again";
        }
        else{
            $errorMsg = $adduser;
        }
    }
    else{
        $errorMsg = "Missing information or passwords don't match";
    }
    
    
}

// REMOVE A USER FROM THE SYSTEM
if($_GET['action'] == "remove"){
    if($_GET['confirm'] =="true"){
        if($_GET['u'] !=""){
            $removeuser = $objKongreg8->removeUser(db::escapechars($_GET['u']));
            if($removeuser == true){
                $toggleMessage = "<p class=\"updated\">Your user has been removed from the system</p>";
            }
            else{
                $errorMsg = "Could not remove the user at this time.";
            }
        }
        else{
            $errorMsg = "Missing details, please try again.";
        }
    }
    else{
        $toggleMessage = "<p class=\"confirm\">Are you SURE you want to remove this user?
                            <a href=\"index.php?mid=950&u=".db::escapechars($_GET['u'])."&action=remove&confirm=true\">Yes, I agree</a>.</p>";
    }
    
}

require_once('modules/admin/users.php');

?>
