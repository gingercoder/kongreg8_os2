<?php

/*
 * Bible Search and display function
 * screen rendering
 */



?>
<div class="contentBoxLeft">
    <h1>Bible Verses</h1>
    <p>
        New King James version:
    </p>
    <?php
    if($verse !=""){
        print $verse;
    }
    ?>
</div>

<div class="contentBoxRight">
    <h2>Search</h2>
    <p>Please select book (and chapter / verse as required) to display:</p>
    <form name="biblesearch" action="index.php" method="post">
        <input type="hidden" name="mid" id="mid" value="650" />
        <input type="hidden" name="search" id="search" value="true" />
        <label for="book">Book :</label>
        <select name="book" id="book" >
            <?php $booklist = $objBible->getBookList(); print $booklist; ?>
        </select>
        <label for="chapter">Chapter :</label>
        <input type="text" maxlength="3" name="chapter" id="chapter" />
        <label for="verse" id="verse" >Verse :</label>
        <input type="text" maxlength="3" name="verse" id="verse" />
        <input type="submit" value="Display" />
    </form>
</div>