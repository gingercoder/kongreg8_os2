<?php

/*
 * Export Function Output Launch Screen
 */



if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}

?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('export','0'); ?>
</div>
<div class="contentBoxLeft">
    <h1>Export Data</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>

    <?php
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
    ?>
    <h2>Files ready to download</h2>
    <div>
        <?php
        
        $objExport->displayFiles(); 
        
        ?>
    </div>
    <span class="clearSpan">&nbsp;</span>
    <br/>
    <p>
        [<a href="index.php?mid=700&action=rmf">Remove Files</a>]
    </p>
    
</div>

<div class="contentBoxRight">
    <h2>Select Data and format</h2>
    <form name="exportdata" action="index.php" method="post">
        <input type="hidden" id="mid" name="mid" value="700" />
        <input type="hidden" id="action" name="action" value="export" />
        <label for="area">Area</label>
        <select name="area" id="area">
            <option value="members">Members</option>
            <option value="groups">Groups</option>
        </select>
        <label for="outputtype">Output in</label>
        <select name="outputtype" id="outputtype">
            <option value="csv">CSV</option>
            <option value="xml">XML</option>
        </select>
        <label for="submit">&nbsp;</label>
        <input type="submit" id="submit" value="Create Export" name="submit" />
    </form>
    
</div>