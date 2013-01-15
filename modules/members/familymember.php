<?php

/*
 * Member View information Output
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>

<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('members','1'); ?>
</div>
    

<div class="contentBox">
    <h1>Add Family Link</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    
    <?php
    if($errorMsg != ""){
        print $errorMsg;
    }
    
    ?>
    <h2>Family Link</h2>
    <h3>
        Member <?php print $member['firstname']." ".$member['surname']; ?>
    </h3>
    
</div>