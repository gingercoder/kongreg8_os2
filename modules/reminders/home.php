<?php

/*
 * Reminders Module
 * Main screen displaying all reminders
 * 
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('reminders','1'); ?>
</div>
<div class="contentBoxLeft">
    <h1>Reminders</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <?php if ($toggleMessage !=""){ print $toggleMessage; } ?>
    <p>Current reminders:</p>
    <?php
    
    $objReminder->viewReminders('large','all', $highlight);
    ?>
    
</div>
<div class="contentBoxRight">
    <h1>Create New Reminder</h1>
    <form name="newReminder" action="index.php" method="post">
        <input type="hidden" value="600" name="mid" id="mid" />
        <input type="hidden" value="true" name="store" id="store" />
        <?php
        $objKongreg8->generateTimeDateInput();
        ?>
        <label for="reminderTitle">Title</label>
        <input type="text" size="30" maxlength="50" name="reminderTitle" id="reminderTitle" />
        <label for="reminderContent">Message</label>
        <textarea name="reminderContent" id="reminderContent" cols="30" rows="5" maxlength="255"></textarea>
        <label for="reminderAlert">Set Alert?</label>
        <select name="reminderAlert" id="reminderAlert">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
        <br/><br/>
        <input type="submit" value="Create" />
    </form>
</div>
