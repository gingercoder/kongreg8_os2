<?php

/*
 * Backup Launch System
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('Backup');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once('application/backup/backup.php');
$objBackup = new backup();



// EXPORT THE DATA IF TOLD TO
if($_POST['action'] == "backup"){
    // Run the function
    
    $objBackup->backupDatabase($_POST['backupbible']);
    $toggleMessage = "<p class=\"updated\">Backup generated</p>";
    
}



// REMOVE FILES FROM THE DIRECTORY
if($_GET['action'] == "rmf"){
    if($_GET['confirm'] == "true"){
        $objBackup->clearBackups();
    }
    else{
        $toggleMessage = "<p class=\"confirm\">Are you SURE you want to remove all backup files? This cannot be un-done. 
                            <a href=\"index.php?mid=720&action=rmf&confirm=true\">Yes, I agree</a>.
                         </p>";
    }
    
}


require_once('modules/backup/home.php');
?>
