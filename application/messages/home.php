<?php

/*
 * Messages Home Screen / Create / Remove
 */

require_once('application/messages/messages.php');
$objMessages = new messages();


// STORE A MESSAGE
if($_POST['create'] == 'true'){
    // Add a new message
    if(($_POST['towho'] !="")&&($_POST['title'] !="")&&($_POST['message'] !="")){
        // Run the update
        $storemessage = $objMessages->storeMessage($_POST['title'], $_POST['message'], $_POST['towho'], '');
        if($storemessage == 'true'){
            $toggleMessage = "<p class=\"updated\">Your message has been sent</p>";
        }
        else{
            $toggleMessage = "<p class=\"confirm\">Your message could not be stored at this time</p>";
        }
    }
    else{
        // Missing information
        $errorMsg = "Missing Information, please try again";
    }
}

// REMOVE A MESSAGE FROM THE SYSTEM
if($_GET['remove'] == 'true'){
    
    $messageid = $_GET['messageid'];
        
    if(!empty($messageid)){
    
     
        if($_GET['confirm'] == 'true'){
            
            $removemessage = $objMessages->deleteMessage($messageid);
            if($removemessage == true){
                $toggleMessage = "<p class=\"updated\">Message removed.</a>";
            }
            else{
                $errorMsg = "Could not delete the message at the moment. The fault has been logged, please try again.";
            }
        }
        else{
            
            $toggleMessage = "<p class=\"confirm\">Are you SURE you want to remove this message ?
                            <a href=\"index.php?mid=690&messageid=$messageid&remove=true&confirm=true\">Yes, I agree</a>
                            ";
        }
    }
    else{
        $toggleMessage = "<p class=\"confirm\">No MESSAGE ID passed - cannot continue.</p>";
        
    }
}



require_once('modules/messages/home.php');

?>
