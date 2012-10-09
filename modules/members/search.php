<?php

/*
 * Search form for member control
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>

<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('members','6'); ?>
</div>

<div class="contentBox">
    <h1>Member Search</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <p>
        Enter your search criteria to find / edit or remove a member...
    </p>
    <form name="searchmember" action="index.php" method="post">
        <input type="hidden" id="search" name="search" value="true" />
        <input type="hidden" id="mid" name="mid" value="210" />
        <label for="namefield">Member Name:</label>
        <input type="text" id="namefield" name="namefield" />
        <label for="address">Address contains:</label>
        <input type="text" id="address" name="address" />
        <label for="phonenum">Phone Number contains:</label>
        <input type="text" id="phonenum" name="phonenum" />
        <label>&nbsp;</label>
        <input type="submit" value="Search" />
    </form>
    
</div>