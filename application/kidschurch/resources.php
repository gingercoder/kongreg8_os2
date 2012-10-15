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
 * Add a resource
 */
if($_POST['action']=="add"){
    // 
    
}

/*
 * Edit a resource
 */
if($_POST['action']=="edit"){
    
}


/*
 * Create the table of resources available
 * 
 */
$resources = $objKidschurch->viewResources();
if(count($resources) > 0){
    $resourceOutput = "<table class=\"memberTable\"><tr><th>ResourceID</th><th>Name</th><th>Description</th><th>Type</th><th>Quantity</th><th>Task</th></tr>";
    foreach($resources as $resource){
        print "<tr>";
        print "<td>".$resource['resourceID']."</td>";
        print "<td>".$resource['resourceName']."</td>";
        print "<td>".$resource['resourceDescription']."</td>";
        print "<td>".$resource['resourceType']."</td>";
        print "<td>".$resource['resourceQuantity']."</td>";
        print "<td>REM".$resource['resourceID']." UPDATE</td>";
        print "<tr>";
    }
}
else{
    $resourceOutput = "<p>There are no resources stored at present.</p>";
}
require_once('modules/kidschurch/resources.php');
?>
