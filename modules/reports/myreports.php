<?php

/*
 *  My Reports system allowing display creation and updating of your own 
 *  generated reports within the Kongreg8 system.
 * 
 */


if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('myreports','1'); ?>
</div>
<div class="contentBoxLeft">
    <h1>My Reports</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <span class="myreports">
    <?php
    if($entryupdatemessage !=""){
        print $entryupdatemessage;
    }
    ?>
    </span>
    <?php $objReports->viewAllMyReports($objKongreg8->usernametoid($_SESSION['Kusername'])); ?>
  

    
</div>
<div class="contentBoxRight">
    <h1>Create New</h1>
    <form name="myreport" action="index.php" method="post">
        <input type="hidden" name="mid" id="mid" value="505" />
        <input type="hidden" name="store" id="store" value="true" />
        <label>Report Name</label>
        <input type="text" name="reportName" id="reportName" size="30" />
        <label>Report Description</label>
        <textarea name="reportDescription" id="reportDescription" cols="25" rows="5"></textarea>
        <label>Table</label>
        <select name="tableName" id="tableName">
            <option value="churchmembers">Members</option>
            <option value="groups">Groups</option>
            <option value="kidschurchgroups">Kids Church Groups</option>
            <option value="campus">Campus</option>
            <option value="klog">System Log</option>
            <option value="kerrorlog">Error Log</option>
        </select>
        <label>Where</label>
        <input type="text" name="whereA" id="whereA" size="30" placeholder="firstname" />
        <label>Operator</label>
        <select name="compareA" id="compareA">
            <option value="LIKE">LIKE</option>
            <option value="=">EQUALS</option>
            <option value="!=">NOT EQUAL TO</option>
        </select>
        <label>Value A</label>
        <input type="text" name="valueA" id="valueA" size="30" placeholder="%john%" />
        <br/>
        <select name="compareBoth" id="compareBoth">
            <option value="AND">AND</option>
            <option value="OR">OR</option>
        </select>
        <br/>
        <label>Where</label>
        <input type="text" name="whereB" id="whereB" size="30" placeholder="enter text to activate" />
        <label>Operator</label>
        <select name="compareB" id="compareB">
            <option value="LIKE">LIKE</option>
            <option value="=">EQUALS</option>
            <option value="!=">NOT EQUAL TO</option>
        </select>
        <label>Value</label>
        <input type="text" name="equalsB" id="equalsB" size="30" placeholder="enter text to activate" />
        
        <br/>
        <input type="submit" value="Save" />
        
    </form>
</div>