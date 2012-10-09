<?php

/*
 * Firewall admin area
 * 
 */

$checkuserlevel = $objKongreg8->checkAccessLevel('Firewall');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

// STORE A NEW ENTRY IN THE FIREWALL SYSTEM
if($_POST['store'] == 'true'){
    
    $addentry = $objFirewall->addRule($_POST['ruleTitle'], $_POST['ipstart'], $_POST['ipend'], $_POST['allowdeny'], $_POST['state']);
    
    if($addentry == 'true'){
        $ruleInfo = 'Added Firewall Rule : ' . db::escapechars($_POST['ipstart']) . ' ' . db::escapechars($_POST['ipend']) . ' ' . db::escapechars($_POST['allowdeny']) . ' ' . db::escapechars($_POST['state']);
        $entryupdatemessage = "<p class=\"updated\">New rule inserted into the database.</p>";
        $objKongreg8->logevent('firewall', $ruleInfo, 'firewall');
    }
    else{
        $entryupdatemessage = "<p class=\"updated\">Could not add the rule at the moment. I've logged the error</p>";
        $objKongreg8->logerror('firewall', 'Error adding rule', 'firewall');
    }
    
}

// UPDATE A CURRENTLY STORED ITEM IN THE FIREWALL SYSTEM
if($_POST['update'] == 'true'){
    
    $editentry = $objFirewall->editRule($_POST['ruleTitle'], $_POST['ipstart'], $_POST['ipend'], $_POST['allowdeny'], $_POST['state'], $_POST['ruleID']);
    
    if($editentry == 'true'){
        $ruleInfo = 'Edited Firewall Rule : ' . db::escapechars($_POST['ruleID']) . ' ' . db::escapechars($_POST['ipstart']) . ' ' . db::escapechars($_POST['ipend']) . ' ' . db::escapechars($_POST['allowdeny']) . ' ' . db::escapechars($_POST['state']);
        $entryupdatemessage = "<p class=\"updated\">Rule modified in the database.</p>";
        $objKongreg8->logevent('firewall', $ruleInfo, 'firewall');
    }
    else{
        $entryupdatemessage = "<p class=\"updated\">Could not edit the rule at the moment. I've logged the error</p>";
        $objKongreg8->logerror('firewall', 'Error editing rule', 'firewall');
    }
    
}

// DELETE AN ITEM FROM THE SYSTEM
if(($_GET['rm'] == 'true')&&($_GET['rid'] !="")){
    
    // ASK FOR CONFIRM
    if($_GET['confirm'] == 'true'){
        $remove = $objFirewall->removeItem($_GET['rid']);
        if($remove){
            $ruleInfo = 'Removed Firewall Rule #'.db::escapechars($_GET['rid']);
            $entryupdatemessage = "<p class=\"updated\">Rule removed from the database.</p>";
            $objKongreg8->logevent('firewall', $ruleInfo, 'firewall');
        }
        else{
            $entryupdatemessage = "<p class=\"updated\">Could not remove the rule at the moment. I've logged the error</p>";
            $objKongreg8->logerror('firewall', 'Error editing rule', 'firewall');
        }
    }
    else{
        $entryupdatemessage = "<p class=\"confirm\">Are you sure you want to remove rule ".db::escapechars($_GET['rid'])." from the system?";
        $entryupdatemessage .= "&nbsp;&nbsp;&nbsp;<a href=\"index.php?mid=999900&rm=true&rid=".db::escapechars($_GET['rid'])."&confirm=true\">Yes, I agree</a></p>";
    }
}
require_once('modules/admin/firewall.php');


?>
