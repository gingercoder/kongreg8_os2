<?php

/*
 * Kongreg8 Web Service API
 * Version 2.0.1
 * Rick Trotter
 * Pizza Box Software
 * 
 * Primary web service for the Kongreg8 system - requires API key to be available and the service to be switched ON
 * 
 */

/*
 * Web Service format:
 * http://yourwebserver/kongreg8path/api/index.php?key=YOURAPIKEY&username=YOURUSERNAME&feature=FEATURE&search=YOURSEARCHCRITIA&area=FIELDNAME
 * 
 */

// FIRE UP THE DB CONNECTION AND CLASS FILES --------------------------------------------------------
require_once ('../application/db/db.php');
require_once ('../application/db/connect.php');
require_once ('../application/core/kongreg8app.php');
require_once ('../application/core/firewall.php');
require_once ('../application/webservice/webservice.php');


$objKongreg8 = new kongreg8app();
$objFirewall = new firewall();
$objWebservice = new webservice();

// CHECK THE AUTHENTICATION LEVEL   --------------------------------------------------------

$authok = $objWebservice->authenticate($_GET['username'], $_GET['key']);
if($authok == false){
    $logType = "Auth";
    $logValue = db::escapechars($_GET['username'])." failed logging in from ".$_SERVER['REMOTE_ADDR'];
    $logArea = "webservice";				
    $objKongreg8->logevent($logType, $logValue, $logArea);
    
    die('Access Denied');
}
else{
    $logType = "Auth";
    $logValue = db::escapechars($_GET['username'])." accessed the webservice from ".$_SERVER['REMOTE_ADDR'];
    $logArea = "webservice";				
    $objKongreg8->logevent($logType, $logValue, $logArea);
}

$objKongreg8->checkAccessLevel('webservice');


// CHECK THE SERVICE STATUS --------------------------------------------------------

$apistate = $objWebservice->checkAPIstate();
if($apistate == 0){
    die('Service Off');
}

// MAP OUT THE QUERY AND DELIVER THE RESULTS --------------------------------------------------------


$apifeature = db::escapechars($_GET['feature']);
$myquery = db::escapechars($_GET['search']);
$modifier = db::escapechars($_GET['area']);

switch($apifeature){
    
    case "member":
        $objWebservice->searchMember($myquery, $modifier);
        break;
    case "groups":
        $objWebservice->searchGroup($myquery, $modifier);
        break;
}







?>
