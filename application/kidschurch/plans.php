<?php

/*
 * Kids Church Plans
 */

require_once('application/kidschurch/kidschurch.php');
$objKidschurch = new kidschurch();

if($_POST['action']=="add"){
    
    
    require_once('modules/kidschurch/plans.php');
    
}
elseif($_GET['action']=="remove"){
    
    
    require_once('modules/kidschurch/plans.php');
    
}
elseif($_GET['action']=="edit"){
    
    require_once('modules/kidschurch/planedit.php');
    
}
else{
    // Just show all of the plans in the system
    require_once('modules/kidschurch/plans.php');
}

?>
