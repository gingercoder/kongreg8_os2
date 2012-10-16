<?php

/*
 * Resources available for Kids Church
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

    <?php 
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
    ?>
        <?php
        $output = $objKidschurch->viewResources($resourceid);
        print $output;
    ?>
</div>

<div class="contentBoxRight">
    <h2>Add a resource</h2>
    <form name="addresource" action="index.php" method="post">
        <input type="hidden" name="mid" id="mid" value="430" />
        <input type="hidden" name="action" id="action" value="add" />
        <label for="resname">Name</label>
        <input type="text" name="resname" id="resname" />
        <label for="resdesc">Description</label>
        <textarea name="resdesc" id="resdesc" ></textarea>
        <label for="restype">Type</label>
        <input type="text" name="restype" id="restype" />
        <label for="resquantity">Quantity</label>
        <input type="text" name="resquantity" id="resquantity" />
        <label for="submit"></label>
        <input type="submit" name="submit" id="submit" value="Add" />
    </form>
</div>
