<?php

/*
 * User Control Mechanism
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
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <?php
    if($toggleMessage !=""){
        print $toggleMessage;
    }

    $userlist = $objKongreg8->displayUsers();
    print $userlist;
    ?>

</div>
<div class="contentBoxRight">
    <h2>Add User</h2>
    <form name="adduser" action="index.php" method="post" >
        <input type="hidden" name="mid" id="mid" value="950" />
        <input type="hidden" name="action" id="action" value="add" />
        <label for="uname">Username:</label>
        <input type="text" name="uname" id="uname" />
        <label for="fname">First name:</label>
        <input type="text" name="fname" id="fname" />
        <label for="sname">Surname:</label>
        <input type="text" name="sname" id="sname" />
        <label for="pword1">Password:</label>
        <input type="password" name="pword1" id="pword1" />
        <label for="pword2">Verify:</label>
        <input type="password" name="pword2" id="pword2" />
        <label for="userlevel">User level:</label>
        <select name="userlevel">
            <option value="1">1 (lowest)</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5 (sys admin)</option>
        </select>
        <label for="email">Email Address:</label>
        <input type="text" name="email" id="email" />
        <label for="campus">Campus: </label>
        <select name="campus" id="campus">
            <option value="all">All</option>
            <?php print  $objMember->getCampusList();   ?>
        </select>
        <label for="submit">&nbsp;</label>
        <input type="submit" name="submit" id="submit" value="Add" />
    </form>
</div>
