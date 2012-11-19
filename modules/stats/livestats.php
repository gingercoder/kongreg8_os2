<?php

/*
 * Live statistics output
 */


if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
    
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Statistics','0'); ?>
</div>
<div class="contentBox">
    <h1>Live Statistics</h1>
        <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>

    <?php 
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
        
    ?>
        
        <div id="groupBarChart_div"></div>
        <div id="genderPieChart_div"></div>
        
</div>
