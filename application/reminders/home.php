<?php

/*
 * Reminders System Launch page
 * If passed certain variables, undertake the tasks as necessary
 * 
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('My Reminders');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

include_once('application/reminders/reminders.php');
$objReminder = new reminders();

    /*
     * TOGGLE AN ITEM
     */
    if(($_GET['t'] != "")&&($_GET['rid'] != ""))
    {
        // Reminder toggle activated
        
        $reminderID = db::escapechars($_GET['rid']);
        if($_GET['t'] == '1'){
            $updatestate = $objReminder->toggleAlert($reminderID, true);
            $toggleMessage = "<p>Reminder Alert added for reminder {$reminderID} </p>";
        }
        else{
            $updatestate = $objReminder->toggleAlert($reminderID, false);
            $toggleMessage = "<p>Reminder Alert cancelled for reminder {$reminderID} </p>";
        }
        
        if($updatestate != true){
            $toggleMessage = "<p>Reminder Alert could not be toggled right now, sorry</p>";
        }
        
    }
    /*
     * HIGHLIGHT ITEM AS REQUESTED
     */
    if($_GET['rid'] !="")
    {
        // HIGHLIGHT AN ITEM IN THE TABLE IF TOLD TO
        if($_GET['h'] == '1'){
            $highlight = db::escapechars($_GET['rid']);
        }
        else{
            $hightlight = '';
        }
    }
    
    /*
     * STORE THE NEW REMINDER IN THE SYSTEM
     */
    if($_POST['store'] == 'true'){
        
        $checkDate = checkdate($_POST['dateMonth'],$_POST['dateDay'],$_POST['dateYear']);
        
        if($checkDate == 'true'){
            $reminderDate = $_POST['dateYear'] . "-" . $_POST['dateMonth'] . "-" . $_POST['dateDay'];
            $reminderTime = $_POST['dateHour'] . ":" . $_POST['dateMinute'] . ":" . "00";
            
            $reminderInfo =   "Reminder Set: " . $_POST['reminderTitle'] . " " . $_POST['reminderContent'] . " " . $reminderDate . " " . $reminderTime . " " . $_POST['reminderAlert'] . " - set by: " . $_SESSION['Kusername'];
            
            $storeReminder = $objReminder->addReminder($_POST['reminderTitle'], $_POST['reminderContent'], $reminderDate, $reminderTime, $_POST['reminderAlert'], $objKongreg8->usernametoid($_SESSION['Kusername']));
            if($storeReminder == 'true'){
                $toggleMessage = "<p class=\"updated\">The reminder has been stored in the system.</p>";
                $objKongreg8->logevent('reminders', $reminderInfo, 'reminder');
            }
            else{
                $toggleMessage = "<p class=\"confirm\">Reminder could not be stored right now, sorry. The failure has been logged.</p>";
                $objKongreg8->logerror('reports', $reminderInfo, 'reminder');
            }
        }
        else{
            $toggleMessage = "<p class=\"confirm\">Date provided is not valid, sorry.</p>";
        }
        
        
        
    }
    
    
    /*
     * REMOVE THE REMINDER FROM THE SYSTEM
     * 
     */
    
    if($_GET['remove'] == 'true'){
        
        $reminderID = $_GET['rid'];
        if($_GET['confirm'] == 'true'){
            
            if($reminderID !=""){
                $remove = $objReminder->removeReminder($reminderID);
                if($remove == 'true'){
                    $toggleMessage = "<p class=\"update\">Your reminder has been removed from the system</p>";
                }
                else{
                    $toggleMessage = "<p class=\"confirm\">Your reminder could not be removed from the system right now. Please try again.</p>";
                }
            }
            else{
                $errorMsg = "No ID specified, aborting removal.";
            }
            
        }
        else{
            
            $toggleMessage = "<p class=\"confirm\">Are you SURE you want to remove this reminder? 
                                <a href=\"index.php?mid=600&remove=true&confirm=true&rid=$reminderID\">Yes, I agree</a>
                                ";
        }
        
        
    }
    
    include_once('modules/reminders/home.php');
    
?>

