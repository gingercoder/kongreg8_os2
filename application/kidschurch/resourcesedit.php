<?php

/*
 * Kids Church Resources Edit function
 */



$checkuserlevel = $objKongreg8->checkAccessLevel('Kids Church');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}


require_once('application/kidschurch/kidschurch.php');
$objKidschurch = new kidschurch();

/*
 * Resource ID for highlighting
 */


/*
 * Edit a resource
 */
if($_POST['action']=="save"){
    // add new resource to the system 
    if(($_POST['resname'] !="")&&($_POST['restype'] !="")){
        $editresource = $objKidschurch->editResource($_POST['resname'], $_POST['resdesc'], $_POST['restype'], $_POST['resquantity'], $_POST['resourceID']);
        if($editresource == true){
            $toggleMessage = "<p class=\"updated\">Resource Saved</p>";
        }
        else{
            $errorMsg = "Could not save the resource at this time, please try again.";
        }
    }
    else{
        $errorMsg = "No Resource Name or Resource Type - try again please.";
    }
}



if($_POST['resourceID'] !=""){
    $resourceid = db::escapechars($_POST['resourceID']);
    $resource = $objKidschurch->getResource($resourceid);
}
elseif($_GET['resourceID'] !=""){
    $resourceid = db::escapechars($_GET['resourceID']);
    $resource = $objKidschurch->getResource($resourceid);
}
else{
    $errorMsg = "Missing Resource ID, cannot continue";
}

require_once('modules/kidschurch/resourcesedit.php');
?>
