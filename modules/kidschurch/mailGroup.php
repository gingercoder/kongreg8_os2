<?php

/*
 * Mail a group with information
 */


if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}

?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Groups','5'); ?>
</div>
<div class="contentBoxLeft">
    <h1>Contact Kidschurch Group</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <?php
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
    ?>
    <p>
        Your saved messages available to send:
    </p>
    <?php $objKidschurch->viewStoredTemplates($_SESSION['Kusername'], $tid); ?>
    
</div>

<div class="contentBoxRight">
    <h2>Create Message Template</h2>
    <form name="createMessage" action="index.php" method="post">
        <input type="hidden" name="mid" id="mid" value="320" />
        <input type="hidden" name="action" id="action" value="save" />
        <label for="subject">Subject</label>
        <input type="text" name="subject" id="subject" />
        <label for="message">Message</label>
        <textarea name="message" id="message"></textarea>
        <label for="group">Group</label>
        <select name="group" id="group">
            <option value="0">All</option>
            <?php print $objKidschurch->groupselectdropdown($_SESSION['Kcampus']); ?>
        </select>
        <label for="submit">&nbsp;</label>
        <input type="submit" name="submit" value="submit" />
    </form>
</div>