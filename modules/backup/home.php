<?php

/*
 * Backup Output Page
 */



if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}

?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('backup','0'); ?>
</div>
<div class="contentBoxLeft">
    <h1>System Backup</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    
    <?php
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
        // Display all the backup files
        print "<p>Backup files ready to download:</p>";
        $objBackup->displayFiles(); 
        
        ?>
    
</div>

<div class="contentBoxRight">
    <h2>Launch Backup Now</h2>
    <form name="exportdata" action="index.php" method="post">
        <input type="hidden" id="mid" name="mid" value="720" />
        <input type="hidden" id="action" name="action" value="backup" />
        <label for="submit">&nbsp;</label>
        <input type="submit" id="submit" value="Run Backup" name="submit" />
    </form>
    
    <br/>
    <p>
        [<a href="index.php?mid=720&action=rmf">Remove Files</a>]
    </p>
</div>