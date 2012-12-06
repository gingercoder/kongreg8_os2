<?php

/*
 * Module Control System
 */

if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
    
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Modules','0'); ?>
</div>
<div class="contentBoxLeft">
    <h1>Module Control</h1>
        <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>

    <?php 
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
        
    ?>
        <p>Access to modules:</p>
        
        <?php
        print $objKongreg8->showModuleUserAccess();
        ?>
</div>
<div class="contentBoxRight">
    <h2>Default Levels</h2>
    <p>(Used for creating new users)</p>
<?php

$objKongreg8->displayModulesForm();

?>
</div>

