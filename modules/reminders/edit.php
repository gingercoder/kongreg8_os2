<?php

/*
 * Edit a reminder in the system
 */
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('reminders','2'); ?>
</div>
<div class="contentBox">
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <h1>Edit Reminder</h1>
    <?php 
    
    $myreminder = $objReminder->viewReminder($_GET['rid']);
    
    
    ?>
    <form name="newReminder" action="index.php" method="post">
        <input type="hidden" value="601" name="mid" id="mid" />
        <input type="hidden" value="true" name="store" id="store" />
        <input type="hidden" value="<?php print $myreminder['reminderID']; ?>" name="rid" id="rid" />
        <?php
        $objKongreg8->generateTimeDateInput();
        ?>
        <label for="reminderTitle">Title</label>
        <input type="text" size="30" maxlength="50" name="reminderTitle" id="reminderTitle" value="<?php print $myreminder['reminderTitle'];?>"/>
        <label for="reminderContent">Message</label>
        <textarea name="reminderContent" id="reminderContent" cols="30" rows="5" maxlength="255"><?php print $myreminder['reminderContent'];?></textarea>
        <label for="reminderAlert">Set Alert?</label>
        <select name="reminderAlert" id="reminderAlert">
            <?php 
            
                if($myreminder['reminderTitle'] == '0'){
                    ?>
                    <option default value="0">No (default)</option>
                    <option value="1">Yes</option>
                    
                    <?php
                }
                else{
                    ?>
                    <option default value="1">Yes (default)</option>
                    <option value="0">No</option>
                    <?php
                }
            
            ?>
            
        </select>
        <br/><br/>
        <input type="submit" value="Save" />
    </form>
</div>