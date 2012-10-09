<?php

/*
 * Edit form for updating a campus 
 */if($errorMsg != ""){
    print "<div class=\"contentBox\"><h2>Error Saving Campus</h2><p>$errorMsg</p></div>";
}
?>

<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('campus','1'); ?>
</div>
<div class="contentBox">
    <h1>Edit Campus</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <?php
    if($entryupdatemessage !=""){
        print $entryupdatemessage;
    }
    ?>
</div>
<div class="contentBox">
    <h2>Edit existing campus</h2>
    <form name="editCampus" action="index.php" method="post">
        <input type="hidden" id="mid" name="mid" value="245" />
        <input type="hidden" id="cid" name="cid" value="<?php echo $mycampus['campusid']; ?>" />
        <input type="hidden" id="update" name="update" value="true" />
        <label>Campus Name</label>
        <input type="text" maxlength="150" name="campusName" id="campusName" value="<?php echo $mycampus['campusName']; ?>" />
        <label>Campus Description</label>
        <textarea name="campusDescription" id="campusDescription" cols="30" rows="5" maxlength="255"><?php echo $mycampus['campusDescription']; ?></textarea>
        <label>Address 1</label>
        <input type="text" name="campusAddress1" id="campusAddress1" maxlength="80" value="<?php echo $mycampus['address1']; ?>" />
        <label>Address 2</label>
        <input type="text" name="campusAddress2" id="campusAddress2" maxlength="80" value="<?php echo $mycampus['address2']; ?>" />
        <label>Postcode</label>
        <input type="text" name="campusPostcode" id="campusPostcode" maxlength="7" value="<?php echo $mycampus['postcode']; ?>" />
        <label>Email</label>
        <input type="text" name="campusEmail" id="campusEmail" maxlength="150" value="<?php echo $mycampus['emailAddress']; ?>" />
        <label>Website</label>
        <input type="text" name="campusURL" id="campusURL" maxlength="80" value="<?php echo $mycampus['campusURL']; ?>" />
        <label>Phone</label>
        <input type="text" name="campusPhone" id="campusPhone" maxlength="15" value="<?php echo $mycampus['telephoneNumber']; ?>" />
        <br/>
        <br/>
        <input type="submit" value="Update" />
        
    </form>
</div>