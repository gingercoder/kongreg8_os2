<?php

/*
 * Authentication statistics display
 */


if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('authstats','0'); ?>
</div>
<div class="contentBox">
    <h1>Authentication Statistics</h1>
    <?php
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
    ?>
    <?php
    
    $objReports->viewAuthStats();
    
    ?>
    
</div>