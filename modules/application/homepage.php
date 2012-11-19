<?php

/*
 * Main Home page for users
 * Displays core information and statistics
 * 
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>
<div class="contentBoxLeft">
<h1>launch pad</h1>

<fieldset><legend>Members</legend>
<?php

if($objKongreg8->checkAccessLevel('Members') == true){
    ?>
    <a href="index.php?mid=210"><span class="iconSpan"><img src="images/icons/search.png" alt="Find Member" title="Find Member"/><br/>Find Member</span></a>

    <a href="index.php?mid=200"><span class="iconSpan"><img src="images/icons/button-add.png" alt="Add Member" title="Add Member"/><br/>Add Member</span></a>
<?php
}
else{
    print "<p>You don't have access to this module, sorry.</p>";
}
?>
    
</fieldset>


<span class="clearSpan">&nbsp;</span>
<fieldset><legend>Groups</legend>
<?php

if($objKongreg8->checkAccessLevel('Groups') == true){
    ?>
    <a href="index.php?mid=300"><span class="iconSpan"><img src="images/icons/papers.png" alt="Group Overview" title="Group Overview"/><br/>Group Overview</span></a>

    <a href="index.php?mid=320"><span class="iconSpan"><img src="images/icons/message-open.png" alt="Contact Group" title="Contact Group"/><br/>Contact Group</span></a>
<?php
}
else{
    print "<p>You don't have access to this module, sorry.</p>";
}
?>
</fieldset>


<span class="clearSpan">&nbsp;</span>
<fieldset><legend>Kids Church</legend>
<?php

if($objKongreg8->checkAccessLevel('Kids Church') == true){
    ?>
    <a href="index.php?mid=400"><span class="iconSpan"><img src="images/icons/papers.png" alt="Group Control" title="Group Control"/><br/>Group Control</span></a>
    
    <a href="index.php?mid=420"><span class="iconSpan"><img src="images/icons/message-open.png" alt="Contact Group" title="Contact Group"/><br/>Contact Group</span></a>

    
    <a href="index.php?mid=430"><span class="iconSpan"><img src="images/icons/paper-clip.png" alt="Resources" title="Resources"/><br/>Resources</span></a>

    <a href="index.php?mid=450"><span class="iconSpan"><img src="images/icons/file-new.png" alt="Plans" title="Plans"/><br/>Plans</span></a>

    <a href="index.php?mid=460"><span class="iconSpan"><img src="images/icons/sign-in.png" alt="Registration" title="Registration"/><br/>Registration</span></a>
<?php
}
else{
    print "<p>You don't have access to this module, sorry.</p>";
}
?>
</fieldset>


<span class="clearSpan">&nbsp;</span>
<fieldset><legend>Statistics and Reports</legend>
<?php

if($objKongreg8->checkAccessLevel('Reports') == true){
    ?>
    <a href="index.php?mid=530"><span class="iconSpan"><img src="images/icons/chart-pie.png" alt="Live Stats" title="Live Stats"/><br/>Live Stats</span></a>

    <a href="index.php?mid=500"><span class="iconSpan"><img src="images/icons/file-new.png" alt="Reports" title="Reports"/><br/>Reports</span></a>

    <a href="index.php?mid=520"><span class="iconSpan"><img src="images/icons/chart-area-up.png" alt="Auth Stats" title="Auth Stats"/><br/>Auth Stats</span></a>
<?php
}
else{
    print "<p>You don't have access to this module, sorry.</p>";
}
?>
</fieldset>


<span class="clearSpan">&nbsp;</span>
<fieldset><legend>My Tools</legend>

    <a href="index.php?mid=600"><span class="iconSpan"><img src="images/icons/clock.png" alt="Remind Me" title="Remind Me"/><br/>Remind Me</span></a>

    <a href="index.php?mid=650"><span class="iconSpan"><img src="images/icons/book-open.png" alt="Bible Search" title="Bible Search"/><br/>Bible Search</span></a>
<?php
if($objKongreg8->checkAccessLevel('My Reports') == true){
    ?>
    <a href="index.php?mid=505"><span class="iconSpan"><img src="images/icons/briefcase.png" alt="My Reports" title="My Reports"/><br/>My Reports</span></a>
<?php
}
?>
    <a href="index.php?mid=690"><span class="iconSpan"><img src="images/icons/bubble.png" alt="My Messages" title="My Messages"/><br/>My Messages</span></a>

        
    <a href="index.php?mid=630"><span class="iconSpan"><img src="images/icons/key.png" alt="Change Password" title="Change Password"/><br/>Change Password</span></a>

</fieldset>


<span class="clearSpan">&nbsp;</span>
<fieldset><legend>System</legend>
<?php

if($objKongreg8->checkAccessLevel('User Control') == true){
    ?>
    <a href="index.php?mid=950"><span class="iconSpan"><img src="images/icons/users.png" alt="User Control" title="User Control"/><br/>User Control</span></a>
<?php
}
if($objKongreg8->checkAccessLevel('Campus Control') == true){
    ?>
    <a href="index.php?mid=240"><span class="iconSpan"><img src="images/icons/site-map.png" alt="Campus Control" title="Campus Control"/><br/>Campus Control</span></a>
<?php
}

if($objKongreg8->checkAccessLevel('Export') == true){
    ?>
    <a href="index.php?mid=700"><span class="iconSpan"><img src="images/icons/drive-download.png" alt="Export Data" title="Export Data"/><br/>Export Data</span></a>
<?php
}

if($objKongreg8->checkAccessLevel('Backup') == true){
    ?>
    <a href="index.php?mid=720"><span class="iconSpan"><img src="images/icons/database.png" alt="Run Backup" title="Run Backup"/><br/>Run Backup</span></a>
<?php
}
?>
    <a href="index.php?mid=111"><span class="iconSpan"><img src="images/icons/software.png" alt="Software Info" title="Software Info"/><br/>Software Info</span></a>
<?php
    if($objKongreg8->checkAccessLevel('Module Control') == true){
    ?>
    <a href="index.php?mid=800"><span class="iconSpan"><img src="images/icons/puzzle.png" alt="Module Control" title="Module Control"/><br/>Module Control</span></a>
<?php
}
    if($objKongreg8->checkAccessLevel('Firewall') == true){
    ?>
    <a href="index.php?mid=999900"><span class="iconSpan"><img src="images/icons/wall.png" alt="Firewall" title="Firewall"/><br/>Firewall</span></a>
<?php
}
?>
    <a href="index.php?mid=999901"><span class="iconSpan"><img src="images/icons/shield.png" alt="I.D.S." title="I.D.S."/><br/>I.D.S.</span></a>
<?php
    if($objKongreg8->checkAccessLevel('Web Service') == true){
    ?>
    <a href="index.php?mid=900"><span class="iconSpan"><img src="images/icons/web.png" alt="Web Service" title="Web Service"/><br/>Web Service</span></a>
<?php
}

    if($objKongreg8->checkAccessLevel('Settings') == true){
?>

    <a href="index.php?mid=909"><span class="iconSpan"><img src="images/icons/computer.png" alt="Settings" title="Settings"/><br/>Settings</span></a>
<?php
    }     
?>

</fieldset>

<span class="clearSpan">&nbsp;</span>



</div>

<div class="contentBoxRight">
    <h1>reminders</h1>
    <?php
    $remindme = $objReminder->viewReminders('small', 'limited');
    if($remindme !=""){
        print "<div class=\"reminderPopup\" id=\"reminderPopup\">";
        print "<span class=\"reminderHide\"><a href=\"#\" onClick=\"hidereminder('reminderPopup');\">Hide Reminders &gt;&gt;</a></span>";
        print "<span class=\"todayReminder\">Today's Reminders</span>";
        print $remindme . "</div>";
        ?>
        
        
        <?php
    }
    ?>
</div>

<span class="clearSpan">&nbsp;</span>

<div class="contentBox">
<h1>statistics</h1>
<p>
    Welcome online to Kongreg8, <?php print $_SESSION['Kusername']; ?>. You have <?php echo $objMessages->numberNew($_SESSION['Kusername']); ?> messages waiting and <?php echo $objReminder->numreminderstoday(); ?> reminders coming up soon.
</p>
<p>
    Live statistics from the DB
</p>

<?php print $memberNonMemberStats; ?>
</div>

<div class="contentBox">
<h1>system status messages</h1>
<p>
    Last Log in: <?php print $objKongreg8->lastlogin($_SESSION['Kusername']); ?><br/>
    Current IP: <?php print $_SERVER['REMOTE_ADDR']; ?><br/>
</p>
    <?php
        $objKongreg8->getErrorOverview();
        
        $objKongreg8->checkhtaccess();
    ?>
</div>