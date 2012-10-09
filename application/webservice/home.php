<?php

/*
 * Webservice function call
 */


require_once('application/webservice/webservice.php');
$objWebservice = new webservice();

// CREATE AN API KEY FOR A USER
if($_POST['action']=="createkey"){
    
    if($_POST['userid'] !=""){
        $newkey = $objWebservice->createAPIkey($_POST['userid']);
        if($newkey == 'true'){
            $toggleMessage = "<p class=\"updated\">New Key added to the system</p>";
        }
        else{
            $errorMsg = "Couldn't add the key at this time";
        }
    }
    else{
        $errorMsg = "No user specified";
    }
}

// REVOKE A KEY FOR A USER
if($_GET['action'] == 'revoke'){
    if($_GET['u'] != ''){
        if($_GET['confirm']=='true'){
            $removekey = $objWebservice->revokeKey(db::escapechars($_GET['u']));
            if($removekey == 'true'){
                $toggleMessage = "<p class=\"updated\">The key has been revoked</p>";
            }
            else{
                $toggleMessage = "There was an error attempting key removal";
            }
        }
        else{
            $toggleMessage = "<p class=\"confirm\">Are you SURE you want to revoke this key? 
                                <a href=\"index.php?mid=900&u=" . db::escapechars($_GET['u']) . "&action=revoke&confirm=true\">Yes, I agree</a>.
                                </p>";
        }
    }
    else{
        $errorMsg = "Missing information";
    }
}


// MAIL AN API KEY TO THE USER
if($_GET['action'] == 'mailkey'){
    if($_GET['u'] != ''){
        $mailkey = $objWebservice->emailKey(db::escapechars($_GET['u']));
        if($mailkey == true){
            $toggleMessage = "<p class=\"updated\">The key has been sent</p>";
        }
        else{
            $errorMsg = "Could not email the key at this time, please try again";
        }
    }
    else{
        $errorMsg = "Missing data, please try again.";
    }
}



require_once('modules/webservice/home.php');
?>
