<?php

/*
 * Campus Control for Multi-site churches
 * Allows display, generation and modification of various church campuses
 *
 */

$checkuserlevel = $objKongreg8->checkAccessLevel('Campus Control');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once ('application/campus/campus.php');
$objCampus = new campus();

// Save a newly entered campus
if($_POST['store'] == 'true'){
    if(($_POST['campusName'] !="")&&($_POST['campusDescription'] !="")){
        $storeCampus = $objCampus->createNew($_POST['campusName'], $_POST['campusDescription'], $_POST['campusAddress1'], $_POST['campusAddress2'], $_POST['campusPostcode'], $_POST['campusPhone'], $_POST['campusEmail'], $_POST['campusURL']);
        $reportInfo = "Adding new campus to the system with details: " . $_POST['campusName'] . " , " .  $_POST['campusDescription'] . " , " . $_POST['campusAddress1'] . " , " . $_POST['campusAddress2'] . " , " . $_POST['campusPostcode'] . " , " . $_POST['campusPhone'] . " , " . $_POST['campusEmail'] . " , " . $_POST['campusURL'] ;
        if($storeCampus == 'true'){
            $entryupdatemessage = "<p class=\"updated\">Your new Campus, ".$_POST['campusName']." , has been saved. You can now access this in the member's area</p>";
            $objKongreg8->logevent('campus', $reportInfo, 'campus' );
        }
        else{
            $errorMsg = "<p class=\"confirm\">I'm sorry, I could not store your new campus right now. An error occurred and I've logged the information.</p>";
            $objKongreg8->logerror('campus', $reportInfo, 'campus' );
            
        }
    }
    else{
        $errorMsg = "<p class=\"confirm\">Could not store your new campus right now. Please ensure you have both a campus name and a description.</p>";
    }
    
}



// remove a campus from the list
if($_GET['remove'] == 'true'){
    if($_GET['confirm'] == 'true'){
        if($_GET['c'] != ""){
            $remove = $objCampus->removeCampus($_GET['c']);
            if($remove == 'false'){
                $errorMsg = "<p class=\"confirm\">Could not remove the campus and associated information right now, something went wrong. I've logged the error.</p>";
            }
            else{
                $entryupdatemessage = "<p class=\"confirm\">The campus has been removed and any associated members or administrators reassigned.</p>";
            }
        }
        else{
            $errorMsg = "<p class=\"confirm\">No campus ID specified - can't remove anything right now, sorry.</p>";
        }
    }
    else{
        $entryupdatemessage = "<p class=\"confirm\">Are you SURE you want to remove the campus &quot;" . $objCampus->getCampusName(db::escapechars($_GET['c'])) ."&quot; ?
                            <a href=\"index.php?mid=240&remove=true&confirm=true&c=" . db::escapechars($_GET['c']) . "\">Yes, I Agree</a>
                            </p>";
    }
}



require_once('modules/campus/home.php');

?>
