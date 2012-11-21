<?php

/*
 * Register System for Kids Church
 */

require_once('application/kidschurch/kidschurch.php');
$objKidschurch = new kidschurch();


if(($_GET['function'] == 'signin')||($_POST['function'] == 'signin')){
    // Sign a child in - check if first stage posted
    require_once('modules/kidschurch/registerSignIn.php');
    
}
elseif(($_GET['function'] == 'signout')||($_POST['function'] == 'singout')){
    // Sign a child out - check if first stage posted
    require_once('modules/kidschurch/registerSignOut.php');
    
}
elseif(($_GET['function'] == 'historic')||($_POST['function'] == 'historic')){
    // Generate a register - check if first stage posted
    require_once('modules/kidschurch/registerHistoric.php');
    
} 
else{
    // Display the main home kids church register page
    require_once('modules/kidschurch/registerHome.php');
    
}
?>
