<?php

/*
 * Edit Resources Control Panel
 */


if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
    
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Kids Church','1'); ?>
</div>
<div class="contentBoxLeft">
    <h1>Resources</h1>
<span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <h2>Edit Resource</h2>
    <p>
        <a href="index.php?mid=430">&lt;&lt&lt; View All Resources</a>
    </p>
    

    <?php 
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
    ?>
    
    <form name="addresource" action="index.php" method="post">
        <input type="hidden" name="mid" id="mid" value="431" />
        <input type="hidden" name="action" id="action" value="save" />
        <input type="hidden" name="resourceID" id="resourceID" value="<?php print $resource['resourceID']; ?>" />
        <label for="resname">Name</label>
        <input type="text" name="resname" id="resname" value="<?php print $resource['resourceName']; ?>" />
        <label for="resdesc">Description</label>
        <textarea name="resdesc" id="resdesc" ><?php print $resource['resourceDescription']; ?></textarea>
        <label for="restype">Type</label>
        <input type="text" name="restype" id="restype" value="<?php print $resource['resourceType']; ?>" />
        <label for="resquantity">Quantity</label>
        <input type="text" name="resquantity" id="resquantity" value="<?php print $resource['resourceQuantity']; ?>" />
        <label for="submit"></label>
        <input type="submit" name="submit" id="submit" value="Save" />
    </form>

</div>
