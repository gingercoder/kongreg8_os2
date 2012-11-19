<?php

/*
 * Module Control
 */

if($_POST['save'] == 'true'){
    
    $update = $objKongreg8->updateModules($_POST['modulename'], $_POST['modulevalue']);
    if($update == 'true'){
        $toggleMessage = "<p class=\"updated\">Module values have been saved.</p>";
    }
    else{
        $errorMsg = "Could not update module values correctly, please try again";
    }
}


require_once('modules/application/modulecontrol.php');
?>