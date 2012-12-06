<?php

/*
 * Module Access Privileges
 */




if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
    
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Modules','1'); ?>
</div>
<div class="contentBox">
    <h1>Module Access Control</h1>
        <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
        <a href="index.php?mid=800">&lt;&lt; Back to main control</a>
    <?php 
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
        print "<h2>".$objKongreg8->useridtoname($userid)."</h2>";
        print $objKongreg8->createModuleAccessForm($userid);
    ?>
        

</div>