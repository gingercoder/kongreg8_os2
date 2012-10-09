<?php

/*
 * Campus edit function
 * 
 * When editing completed or error occurs, redirect back to the home page showing all campuses
 * Otherwise, if editing display the edit form
 */

require_once('application/campus/campus.php');
$objCampus = new campus();
    

$campusid = db::escapechars($_GET['cid']);

// if saving
if($_POST['update'] == 'true'){
    if($_POST['cid'] !=""){
        // Run the update
        
        $updateSystem = $objCampus->runUpdate($_POST['cid'], $_POST['campusName'], $_POST['campusDescription'], $_POST['campusAddress1'], $_POST['campusAddress2'], $_POST['campusPostcode'], $_POST['campusEmail'], $_POST['campusPhone'], $_POST['campusURL']);
        if($updateSystem !="true"){
            $errorMsg = "The campus could not be updated at the moment.";
        }
        else{
            $entryupdatemessage = "<p class=\"update\">The campus information has been updated.</p>";
        }
        require_once('modules/campus/home.php');
    }
    else{
        // No Campus ID, exit with failure
        $errorMsg = "<p class=\"confirm\">No campus ID present, cannot do an update right now, sorry</p>";
        
        require_once('modules/campus/home.php');
    }
    
}
else{
    // display edit form
    
    $mycampus = $objCampus->viewCampusInfo($campusid);
    
    require_once('modules/campus/edit.php');
    
}

?>
