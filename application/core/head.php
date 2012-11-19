<?php

/*
 * Header information and page render loading modules
 */

/*
 * Set error reporting level and session control
 * Modify these settings to debug your instance
 * 
 */
error_reporting(0);
ini_set('display_errors', 'Off');

session_start();
header("Cache-Control: ");
header("pragma: ");

/*
 * Include the primary functions used to create objects
 * These are the objects that need to operate regardless
 * of what module you are launching
 */

require_once ('application/core/kongreg8app.php');
require_once ('application/core/firewall.php');
require_once ('application/help/help.php');

/*
 * Define the main objects used for the core application.
 * Non-essential ones can be defined in their module areas.
 */
$objKongreg8 = new kongreg8app();
$objHelp = new help();
$objFirewall = new firewall();


// IF DOWNLOADING A FILE ALLOW THE BROWSER TO BACKGROUND LOAD THE ITEM DO IT DOESN'T OUTPUT TO THE BROWSER WINDOW
if(($_GET['action'] == "download")&&($_GET['area']=="export")){
    // Export System
    if(($_GET['csum'] != "")&&($_GET['f'] != "") && (md5("application/export/files/".$_GET['f']) == $_GET['csum'])){
        $run = $objKongreg8->downloadExport($_GET['f'], $_GET['csum']);
        if($run != 'true'){
            $errorMsg = $run;
        }
    }
    else{
        $errorMsg = "Incorrect Parameters. Try again.";
    }
}
if(($_GET['action'] == "download")&&($_GET['area']=="backup")){
    // Backup System
    if(($_GET['csum'] != "")&&($_GET['f'] != "") && (md5("application/backup/files/".$_GET['f']) == $_GET['csum'])){
        $run = $objKongreg8->downloadBackup($_GET['f'], $_GET['csum']);
        if($run != 'true'){
            $errorMsg = $run;
        }
    }
    else{
        $errorMsg = "Incorrect Parameters. Try again.";
    }
}
// ---- END FILE DOWNLOAD CHECKS
?>
<!DOCTYPE html>
<html>
    <head>
        
        <title>Kongreg8 <?php print $objKongreg8->version(); ?></title>
        
        <link rel="stylesheet" href="css/screen.css" media="screen" />
        <link rel="stylesheet" href="css/printer.css" media="print" />
        <link rel="stylesheet" href="css/mobile.css" media="mobile" />
        
        
        <meta name="robots" value="no-follow" />
        <meta name="description" value="Kongreg8 Church Member Database System" />
        <!-- Kongreg8 church member database system Licensed under GNU GPL -->
        <!-- Kongreg8 is (c) Rick Trotter, PizzaBoxSoftware.co.uk -->
        
        <script>
            function showreminder(boxid){
                document.getElementById(boxid).style.visibility="visible";
            }

            function hidereminder(boxid){
                document.getElementById(boxid).style.visibility="hidden";
            }
        </script>
        
        
        <?php
            if(($_GET['mid'] == 530) || ($_POST['mid'] == 530)){
                require_once('application/stats/stats.php');
                $objStats = new stats();
                require_once('application/stats/googleGraphScript.php');
            }
        ?>
        

    </head>
