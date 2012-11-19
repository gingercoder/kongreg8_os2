<?php

/*
 * Main Help Screen
 */

if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}

?>
<a name="top">&nbsp;</a>

<div class="contentBoxLeft">

    <a name="1">&nbsp;</a>
    <h1>About</h1>
    <?php print $objHelp->displayHelpSection('about');?>
    <a name="2">&nbsp;</a><a href="#top">[ back to top ]</a>
    <h1>System Control</h1>
    <?php print $objHelp->displayHelpSection('users'); ?>
    <a name="3">&nbsp;</a><a href="#top">[ back to top ]</a>
    <h1>Campus</h1>
    <?php print $objHelp->displayHelpSection('campus'); ?>
    <a name="4">&nbsp;</a><a href="#top">[ back to top ]</a>
    <h1>Members</h1>
    <?php print $objHelp->displayHelpSection('members'); ?>
    <a name="5">&nbsp;</a><a href="#top">[ back to top ]</a>
    <h1>Groups</h1>
    <?php print $objHelp->displayHelpSection('Groups'); ?>
    <a name="6">&nbsp;</a><a href="#top">[ back to top ]</a>
    <h1>Firewall</h1>
    <?php print $objHelp->displayHelpSection('firewall'); ?>
    <a name="7">&nbsp;</a><a href="#top">[ back to top ]</a>
    <h1>Reminders</h1>
    <?php print $objHelp->displayHelpSection('reminders'); ?>
    <a name="8">&nbsp;</a><a href="#top">[ back to top ]</a>
    <h1>Reports</h1>
    <?php print $objHelp->displayHelpSection('Reports'); ?>
    <?php print $objHelp->displayHelpSection('myreports'); ?>
    <a name="9">&nbsp;</a><a href="#top">[ back to top ]</a>
    <h1>Backup / Export</h1>
    <?php print $objHelp->displayHelpSection('backup'); ?>
    <?php print $objHelp->displayHelpSection('export'); ?>
    <a name="10">&nbsp;</a><a href="#top">[ back to top ]</a>
    <h1>Web Service</h1>
    <?php print $objHelp->displayHelpSection('webservice'); ?>
    <a name="10">&nbsp;</a><a href="#top">[ back to top ]</a>
    <h1>Kids Church</h1>
    <?php print $objHelp->displayHelpSection('Kids Church'); ?> 
</div>
<div class="contentBoxRight">
    <h1>Help</h1>
    <h2>Contents</h2>
    <p>Please select the help area or search</p>
    <p>
    <ol>
        <li><a href="#1">About</a>
            <ol>
                <li>About this version</li>
                <li>Contributors</li>
                <li>License</li>
                <li>Developers</li>
            </ol>
        </li>
        <li><a href="#2">System Control</a>
            <ol>
                <li>Users</li>
                <li>Module Control</li>
            </ol>
        </li>
        <li><a href="#3">Campus</a>
            <ol>
                <li>Overview</li>
                <li>Adding a church campus</li>
                <li>Modifying a campus</li>
                <li>Removing a campus</li>
                <li>Specifying a leadership team</li>
            </ol>
        </li>
        <li><a href="#4">Members</a>
            <ol>
                <li>Adding a member</li>
                <li>Editing a member</li>
                <li>Removing a member from the system</li>
                <li>Creating Family Links</li>
                <li>Creating similar entries</li>
                <li>Searching for members</li>
            </ol>
        </li>
        <li><a href="#5">Groups</a>
            <ol>
                <li>Adding a group</li>
                <li>Editing a group's properties</li>
                <li>Modifying the group's leader</li>
                <li>Removing a group</li>
                <li>Contacting a group</li>
            </ol>
        </li>
        <li><a href="#6">Firewall</a>
            <ol>
                <li>Overview</li>
                <li>Adding entries</li>
                <li>Turning firewall on / off</li>
                <li>Recovering from locked system</li>
            </ol>
        </li>
        <li><a href="#7">Reminders</a>
            <ol>
                <li>Overview</li>
                <li>Editing a reminder</li>
            </ol>
        </li>
        <li><a href="#8">Reports &amp; My Reports</a>
            <ol>
                <li>Reports System</li>
                <li>My Reports Overview</li>
            </ol>
        </li>
        <li><a href="#9">Backup &amp; Export</a>
            <ol>
                <li>Backing up the System</li>
                <li>Exporting data</li>
            </ol>
        </li>
        <li><a href="#10">Web Service</a>
            <ol>
                <li>Overview</li>
                <li>Service Functions</li>
            </ol>
        </li>
        <li><a href="#11">Kids Church</a>
            <ol>
                <li>Overview</li>
                <li>Resource Management</li>
                <li>Group Management</li>
                <li>Plans</li>
                <li>Registration</li>
            </ol>
        </li>
    </ol>
    </p>
</div>