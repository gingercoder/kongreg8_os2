<?php

/*
 * Search System area
 * 
 */

$checkuserlevel = $objKongreg8->checkAccessLevel('Search');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once('application/search/search.php');

$searchterm = db::escapechars(trim($_POST['searchTerm']));
$mysearch = new search();

require_once('modules/search/results.php');


?>