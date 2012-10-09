<?php

/*
 * Password change form
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('password','0'); ?>
</div>
<div class="contentBox">
    <h1>Change Password</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <?php
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
    ?>
    <p>
        Please enter a new password and confirm your current password.
    </p>
    <form name="newpassword" action="index.php" method="post">
        <input type="hidden" name="mid" id="mid" value="630" />
        <input type="hidden" name="store" id="store" value="true" />
        
        <label for="oldpass">Current Password:</label>
        <input type="password" name="oldpass" id="oldpass" />
        
        <label for="newpass1">New Password:</label>
        <input type="password" name="newpass1" id="newpass1" />
        
        <label for="newpass2">Re-type New:</label>
        <input type="password" name="newpass2" id="newpass2" />
        
        <label for="submit">&nbsp;</label>
        <input type="submit" name="submit" id="submit" value="Change Password" />
    </form>
</div>
