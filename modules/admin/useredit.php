<?php

/*
 * User Edit Screen
 */
if($errorMsg != ""){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>

<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('users','0'); ?>
</div>
<div class="contentBoxLeft">
    <h1>User Control</h1>
    <h2>Edit User</h2>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <?php
    if($toggleMessage !=""){
        print $toggleMessage;
    }
    
    print $objKongreg8->editUserForm(db::escapechars($_GET['u']));
    
    ?>

</div>

