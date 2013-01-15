<?php

/*
 * Kids Church Plans
 */

require_once('application/kidschurch/kidschurch.php');
$objKidschurch = new kidschurch();



if($_POST['action']=="add"){
    // ADD A PLAN TO THE SYSTEM
    $addplan = $objKidschurch->createPlan($_POST['plantitle'], $_POST['plantheme'], $_POST['planactivities'], $_POST['plandate'], $_POST['planmaterials'], $_POST['planconsent'], $_POST['campus']);
    if($addplan == true){
    
        $toggleMessage = "<p class=\"updated\">Your new plan has been stored</p>";
    }
    else{
        $errorMsg = "Sorry, I couldn't add the plan at this time, I've logged the error.";
        
    }
    
    require_once('modules/kidschurch/plans.php');
    
}
elseif($_GET['action']=="remove"){
    // REMOVE A PLAN FROM THE SYSTEM AFTER A CONFIRMATION
    if(isset($_GET['p'])){
        if($_GET['confirm'] == 'true'){
            $removeplan = $objKidschurch->planRemove($_GET['p']);
            if($removeplan == true){

                $toggleMessage = "<p class=\"updated\">Your plan has been removed</p>";
            }
            else{
                $errorMsg = "Sorry, I couldn't add the plan at this time, I've logged the error.";
            }
        }
        else{
            $toggleMessage = "<p class=\"confirm\">Are you SURE you want to remove this plan?<a href=\"index.php?mid=450&action=remove&confirm=true&p=".$_GET['p']."\">Yes, I agree</a><p>";
        }
    }
    else{
        $toggleMessage = "<p class=\"confirm\">Missing Plan ID - please confirm which item you want to remove</p>";
    }
    
    require_once('modules/kidschurch/plans.php');
    
}
elseif(($_GET['action']=="edit")||($_POST['action']=="edit")){
    // EDIT A PLAN ALREADY STORED IN THE SYSTEM
    
    if($_POST['confirm'] == "true"){
        $addplan = $objKidschurch->editPlan($_POST['plantitle'], $_POST['plantheme'], $_POST['planactivities'], $_POST['plandate'], $_POST['planmaterials'], $_POST['planconsent'], $_POST['campus'], $_POST['p']);
        if($addplan == true){

            $toggleMessage = "<p class=\"updated\">Your plan changes have been saved</p>";
        }
        else{
            $errorMsg = "Sorry, I couldn't save the plan at this time, I've logged the error.";

        }
    }
    require_once('modules/kidschurch/planedit.php');
    
}
else{
    // Just show all of the plans in the system
    require_once('modules/kidschurch/plans.php');
}

?>
