<?php

/*
 * Message View function
 */

require_once('application/messages/messages.php');
$objMessages = new messages();

$messageid = db::escapechars($_GET['messageid']);




if($_POST['reply'] == 'true'){
    // Add a reply to the post
    if(($_POST['inReplyTo'] !="")&&($_POST['title'] !="")&&($_POST['message'] !="")){
        // Run the update
        $storemessage = $objMessages->storeMessage($_POST['title'], $_POST['message'], $_POST['towho'], $_POST['inReplyTo']);
        if($storemessage == 'true'){
            $toggleMessage = "<p class=\"updated\">Your message has been sent</p>";
        }
        else{
            $toggleMessage = "<p class=\"confirm\">Your message could not be stored at this time</p>";
        }
        $messageid = $_POST['inReplyTo'];
        $mymessage = $objMessages->getMessage($_SESSION['Kusername'], $messageid);
        $threads = $objMessages->viewThread($messageid);
    }
    else{
        // Missing information
        $errorMsg = "Missing Information, please try again";
    }
}
else{
    if($messageid !=""){
    $mymessage = $objMessages->getMessage($_SESSION['Kusername'], $messageid);
    $threads = $objMessages->viewThread($messageid);
    }
    else{
        $errorMsg = "No Message ID Specified. Exiting with a failure";
    }
}

require_once('modules/messages/view.php');

?>
