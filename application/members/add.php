<?php

/*
 * Add member
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('Members');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once('application/members/memberControl.php');

$objMember = new memberControl();

if($_POST['store'] == 'true'){
    // Process the data sent by the user
    
    if(($_POST['firstname'] !=="")&&($_POST['surname'] !=="")&&($_POST['source'] !==""))
    {
        // Run the insert validation and insert
        $validateme = $objMember->runMyValidation($_POST['dateofbirth'], $_POST['commitmentdate'], $_POST['crbcheckdate'], $_POST['firstvisit']);
        if($validateme != true)
        {
            $errorMsg = $validateme;
        }
        else{
            $runmyinsert = $objMember->runInsert();
            if($runmyinsert == 'false'){
                $toggleMessage = "<p class=\"confirm\">The member could not be stored right now, sorry. The failure has been logged.</p>";
                  
            }
            else{
                $toggleMessage = "<p class=\"updated\">The member has been stored in the system.</p>";
                
            }
        }
    }
    else{
	$errorMsg .= "Error in processing! You must at least have a first name, surname and source to save the member's data";
    }
   
    
    require_once('modules/members/addthanks.php');
    
}
else{
    // Default input form required for new member
   
    // Show the input form
    require_once('modules/members/add.php');
}





?>
