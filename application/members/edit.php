<?php

/*
 * Edit member
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('Members');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once('application/members/memberControl.php');

$objMember = new memberControl();

if($_POST['edit'] == 'true'){
    // Process the data sent by the user
    
    if(($_POST['firstname'] !="")&&($_POST['surname'] !="")&&($_POST['source'] !=""))
    {
        // Run the insert validation and insert
        // $dateofbirth, $commitmentdate, $crbcheckdate, $firstvisit
        
        $validateme = $objMember->runMyValidation($_POST['dateofbirth'], $_POST['commitmentdate'], $_POST['crbcheckdate'], $_POST['firstvisit']);
        
        if($validateme != "true")
        {
            $errorMsg = $validateme;
            
        }
        else{
            
            $runupdate = $objMember->runUpdate();
            if($runupdate == "false")
            {
                $toggleMessage = "<p class=\"confirm\">The member could not be stored right now, sorry. The failure has been logged.</p>";
            }
            else{
                $toggleMessage = "<p class=\"confirm\">The member information has been saved.</p>";
                $toggleMessage .= $runupdate;
            }
        }
    }
    else{
	$errorMsg .= "<h2>Error in processing!</h2><p>You must at least have a first name, surname and source to save the member's data</p>";
    }
   
    
    require_once('modules/members/editthanks.php');
    
}
else{
    // Default input form required for new member
    require_once ('application/campus/campus.php');
    $objCampus = new campus();
    // Show the input form
    $memberid = db::escapechars($_GET['m']);
    $member = $objMember->viewMember($memberid);
    require_once('modules/members/edit.php');
}





?>
