<?php

/*
 * Kids Church Resource management
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
if($_POST['resourceID'] != ""){
    $resourceid = db::escapechars($_POST['resourceID']);
}
elseif($_GET['resourceID'] != ""){
    $resourceid = db::escapechars($_GET['resourceID']);
}
else{
    $resourceid = '';
}
/*
 * Add a resource
 */
if($_POST['action']=="add"){
    // add new resource to the system 
    if(($_POST['resname'] !="")&&($_POST['restype'] !="")){
        $addresource = $objKidschurch->addResource($_POST['resname'], $_POST['resdesc'], $_POST['restype'], $_POST['resquantity']);
        if($addresource == true){
            $toggleMessage = "<p class=\"updated\">Resource Added</p>";
        }
        else{
            $errorMsg = "Could not add the resource at this time, please try again.";
        }
    }
    else{
        $errorMsg = "No Resource Name or Resource Type - try again please.";
    }
}

/*
 * Remove a resource
 */
if($_GET['action']=="remove"){
    if($_GET['confirm']=="true"){
        $remove = $objKidschurch->removeResource($resourceid);
        if($remove == true){
            $toggleMessage = "<p class=\"updated\">Your resource has been removed</p>";
        }
        else{
            $errorMsg = "Could not remove the resource right now";
        }
    }
    else{
        $toggleMessage = "<p class=\"confirm\">Are you SURE you want to remove this resource?
                            <a href=\"index.php?mid=430&action=remove&confirm=true&resourceID=$resourceid\">Yes, I agree</a></p>";
    }
    
}


require_once('modules/kidschurch/resources.php');
?>
