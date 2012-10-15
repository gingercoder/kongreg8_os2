<?php

/*
 * Export Function
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('Export');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once('application/export/export.php');
$objExport = new export();



// EXPORT THE DATA IF TOLD TO
if($_POST['action'] == "export"){
    // Check the area data
    
    if(($_POST['area'] !="")&&($_POST['outputtype'] !="")){
        // Run the function
        
        $objExport->exportData(db::escapechars($_POST['area']), db::escapechars($_POST['outputtype']));
        $toggleMessage = "<p class=\"updated\">Export generated</p>";
    }
    else{
        $errorMsg = "Missing information - check area and type";
    }
    
}



// REMOVE FILES FROM THE DIRECTORY
if($_GET['action'] == "rmf"){
    if($_GET['confirm'] == "true"){
        $objExport->clearExports();
    }
    else{
        $toggleMessage = "<p class=\"confirm\">Are you SURE you want to remove all export files?
                            <a href=\"index.php?mid=700&action=rmf&confirm=true\">Yes, I agree</a>.
                         </p>";
    }
    
}


require_once('modules/export/home.php');

?>
