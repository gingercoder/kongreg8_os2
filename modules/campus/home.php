<?php

/*
 * Campus Control Screen
 */

if($errorMsg != ""){
    print "<div class=\"contentBox\"><h2>Error Saving Campus</h2><p>$errorMsg</p></div>";
}
?>

<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('campus','1'); ?>
</div>
<div class="contentBox">
    <h1>Campus Control</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <?php
    if($entryupdatemessage !=""){
        print $entryupdatemessage;
    }
    ?>
    <p>
        Current list of campuses:
    </p>
    <?php 
        if($_GET['c'] !=""){
            $campusid = db::escapechars($_GET['c']);
        }
        $objCampus->showAvailable($campusid); 
    ?>
    
</div>
<div class="contentBox">
    <h1>Add a campus</h1>
    <form name="addCampus" action="index.php" method="post">
        <input type="hidden" id="mid" name="mid" value="240" />
        <input type="hidden" id="store" name="store" value="true" />
        <label>Campus Name</label>
        <input type="text" maxlength="150" name="campusName" id="campusName" />
        <label>Campus Description</label>
        <textarea name="campusDescription" id="campusDescription" cols="30" rows="5" maxlength="255"></textarea>
        <label>Address 1</label>
        <input type="text" name="campusAddress1" id="campusAddress1" maxlength="80" />
        <label>Address 2</label>
        <input type="text" name="campusAddress2" id="campusAddress2" maxlength="80" />
        <label>Postcode</label>
        <input type="text" name="campusPostcode" id="campusPostcode" maxlength="7" />
        <label>Email</label>
        <input type="text" name="campusEmail" id="campusEmail" maxlength="150" />
        <label>Website</label>
        <input type="text" name="campusURL" id="campusURL" maxlength="80" />
        <label>Phone</label>
        <input type="text" name="campusPhone" id="campusPhone" maxlength="15" />
        <br/>
        <br/>
        <input type="submit" value="Create" />
        
    </form>
</div>