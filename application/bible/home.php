<?php

/*
 * Bible search and display function
 * search or display output
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('Bible');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}


            
require_once('application/bible/bible.php');
$objBible = new bible();


if($_POST['search'] == true){
    $book = db::escapechars($_POST['book']);
    $chapter = db::escapechars($_POST['chapter']);
    $verse = db::escapechars($_POST['verse']);
    if($book ==""){
        $book = "1";
    }
    if($chapter ==""){
        $chapter = "1";
    }
    if($verse ==""){
        $verse = 'xxx';
    }
    $verse = $objBible->getVerse($book, $chapter, $verse);
}
require_once('modules/bible/home.php');

?>
