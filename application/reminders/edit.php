<?php

/*
 * Edit a reminder
 */

if($_POST['store'] == 'true'){
    
    if($_POST['rid'] != ""){
        
        $thetime = $_POST['dateHour'].":".$_POST['dateMinute'];
        $thedate = $_POST['dateYear']."-".$_POST['dateMonth']."-".$_POST['dateDay'];
        
        
        $save = $objReminder->editReminder($_POST['rid'], $_POST['reminderTitle'], $_POST['reminderContent'], $thedate, $thetime, $_POST['reminderAlert'], $objKongreg8->usernametoid($_SESSION['Kusername']));
        if($save == 'true'){
            $toggleMessage = "<p class=\"updated\">Your reminder has been updated</p>";
        }
        else{
            $errorMsg = "<p>Could not update the reminder at this time, sorry.</p>";
        }
        require_once('modules/reminders/home.php');
        
    }
    else{
        $errorMsg = "<p>Missing ID data - cannot complete action.</p>";
        require_once('modules/reminders/home.php');
    }
    
}
else{
    
    require_once('modules/reminders/edit.php');
    
}

?>
