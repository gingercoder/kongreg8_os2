<?php

/*
 * View all reports available
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}



?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Reports','1'); ?>
</div>
<div class="contentBox">
    <h1>Reports</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>

    <h2>Built-in Kongreg8 Reports</h2>
    
    <h3>Text output reports</h3>
    <span class="headingstyle">Members</span>
    <ul class="reportul">
        <li>All Members (Alphabetically) <a href="index.php?mid=510&prid=001" class="runbutton">Run Report &gt;</a></li>
        <li>Members per campus <a href="index.php?mid=510&prid=002" class="runbutton">Run Report &gt;</a></li>
        <li>Most recent changes <a href="index.php?mid=510&prid=003" class="runbutton">Run Report &gt;</a></li>
        <li>Members without mobile or Email details <a href="index.php?mid=510&prid=004" class="runbutton" >Run Report &gt;</a></li>
    </ul>
    
    <ul class="reportul">
        <li>Monthly Visitor breakdown for past year <a href="index.php?mid=510&prid=005" class="runbutton">Run Report &gt;</a></li>
        <li>Members with a CRB check (current and historical) <a href="index.php?mid=510&prid=006" class="runbutton">Run Report &gt;</a></li>
        <li>Non-member lists <a href="index.php?mid=510&prid=007" class="runbutton">Run Report &gt;</a></li>
        <li>Monthly Birthday breakdown <a href="index.php?mid=510&prid=008" class="runbutton">Run Report &gt;</a></li>
    </ul>
    
    <br/>
    <span class="headingstyle">Groups</span>
    <ul class="reportul">
        <li>All Groups (Alphabetically) <a href="index.php?mid=510&prid=009" class="runbutton">Run Report &gt;</a></li>
        <li>Groups per campus (Alphabetically) <a href="index.php?mid=510&prid=010" class="runbutton">Run Report &gt;</a></li>
        <li>Kids Groups and Members <a href="index.php?mid=510&prid=011" class="runbutton">Run Report &gt;</a></li>
        <li>Church Leaders <a href="index.php?mid=510&prid=012" class="runbutton">Run Report &gt;</a></li>
    </ul>
    
</div>
<div class="contentBox">
    <h2>Your Personal Reports</h2>
    <?php $objReports->viewAllMyReports($objKongreg8->usernametoid($_SESSION['Kusername'])); ?>
    
</div>
<br/><br/>