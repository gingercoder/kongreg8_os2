<?php

/*
 * Password change system
 */

// SAVE THE NEW PASSWORD ROUTINE
if($_POST['store'] == 'true'){
    // CHECK FOR VALUES
    if(($_POST['oldpass'] !="")&&($_POST['newpass1'] !="")&&($_POST['newpass2'])){
        // VERIFY DATA
        if($_POST['newpass1'] === $_POST['newpass2']){
            $changepass = $objKongreg8->changePassword($_POST['oldpass'], $_POST['newpass1']);
            if($changepass == 'true'){
                $toggleMessage = "<p class=\"updated\">Your password has been updated</p>";
            }
            else{
                $errorMsg = "Incorrect old password or error saving new one.";
            }
        }
        else{
            $errorMsg = "New passwords do not match";
        }
        
    }
    else{
        $errorMsg = "Missing information";
    }
    
}

require_once('modules/application/password.php');
?>
