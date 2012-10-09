<?php

/*
 * Edit member
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('Members');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once('application/members/memberControl.php');

$objMember = new memberControl();

if($_POST['search'] == 'true'){
    // Process the data sent by the user
   $namearray = split(' ',$_POST['namefield']);

    $first = trim($namearray[0]);
    $second = trim($namearray[1]);


    $firstname = db::escapechars($first);
    $surname = db::escapechars($second);
    $address = db::escapechars($address);
    $phonenum = db::escapechars($phonenum);
    
    require_once('modules/members/searchresults.php');
    
}
else{
   
    // Show the search input form
    require_once('modules/members/search.php');
    
}





?>
