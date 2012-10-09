<?php

/*
 * View Group Members
 */


if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}

?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Groups','3'); ?>
</div>
<div class="contentBoxLeft">
    <h1>Group Members</h1>
    <p><a href="index.php?mid=300">&lt;&lt; Show all Groups</a></p>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <?php
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
        
    $objGroup->viewGroupMembers($groupid, db::escapechars($_GET['m'])); 
    
    ?>
    
</div>
<div class="contentBoxRight">
    <h2>Add a member</h2>
    <form name="addgroupmember" action="index.php" method="post">
        <input type="hidden" name="mid" id="mid" value="321" />
        <input type="hidden" name="g" id="g" value="<?php print $groupid; ?>" />
        <input type="hidden" name="action" id="action" value="add" />
        <label for="membername" >Member name</label>
        <input type="text" name="membername" id="membername" />
        <label for="submit">&nbsp;</label>
        <input type="submit" value="Find and Add" name="submit" id="submit" />
    </form>
</div>