<?php

/*
 * Module Privileges
 */

if(($_GET['u'] !="")||($_POST['u'] !="")){
    
    $update = $objKongreg8->updateModuleAccess($_POST['u'], $_POST['moduleName'], $_POST['accessVal']);
    if($update == true){
        $toggleMessage = "<p class=\"updated\">Module access has been updated</p>";
    }
    else{
        $errorMsg = "Could not update at this time, please try again.";
    }
}
else{
    $errorMsg = "No User Specified. Please try again.";
}


// SET THE USER ID FOR THE LOADING OF FORM ELEMENTS
if($_GET['u'] !=''){
    $userid = db::escapechars($_GET['u']);
}
if($_POST['u'] !=''){
    $userid = db::escapechars($_POST['u']);
}

require_once('modules/application/moduleprivs.php');


?>
