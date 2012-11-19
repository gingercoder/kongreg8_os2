<?php

/*
 * System Settings 
 */

if($_POST['save'] == 'true'){
    
    $update = $objKongreg8->updateSettings($_POST['settingname'], $_POST['settingvalue']);
    if($update == 'true'){
        $toggleMessage = "<p class=\"updated\">Settings have been saved.</p>";
    }
    else{
        $errorMsg = "Could not update settings correctly, please try again";
    }
}


require_once('modules/admin/settings.php');
?>
