<?php

/*
 * Edit a group already in existence
 */

require_once('application/groups/groups.php');
$objGroup = new groups();


if(($_GET['g'] !="")&&($_GET['edit'] == 'true')){
    
    // Load group data
    $groupid = db::escapechars($_GET['g']);
    $groupinfo = $objGroup->groupView($groupid);
    $groupname = $groupinfo['groupname'];
    $groupdescription = $groupinfo['groupdescription'];
    $leader = $groupinfo['groupleader'];
    
    
    
}


if(($_POST['g'] !="")&&($_POST['action'] == "save")){
    
    
    $updateGroup = $objGroup->editGroup($_POST['g'],$_POST['groupname'],$_POST['groupdescription'], $_POST['leader']);
    if($updateGroup == true){
        $toggleMessage = "<p class=\"updated\">The group has been updated</a>";
    }
    else{
        $errorMsg = $updateGroup;
    }
    
    $groupid = db::escapechars($_POST['g']);
    $groupinfo = $objGroup->groupView($groupid);
    $groupname = $groupinfo['groupname'];
    $groupdescription = $groupinfo['groupdescription'];
    $leader = $groupinfo['groupleader'];
}



require_once('modules/groups/editGroup.php');
?>
