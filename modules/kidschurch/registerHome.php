<?php

/*
 * Register Home Page
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
    
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Kids Church','3'); ?>
</div>
<div class="contentBox">
    <h1>Kids Church Register</h1>
        <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>

    <?php 
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
        
    ?>
<p>
    Kids Church Registration - Sign children in / out of Kids Church and create a register output for any date.
</p>
</div>
<div class="contentBox">
    <p>
        <a href="index.php?mid=460&function=signin"><span class="iconSpan"><img src="images/icons/button-check.png" alt="Sign In Child" title="Click to Sign a Child In"/><br/>Sign-in</span></a>
        
        
        <a href="index.php?mid=460&function=signout"><span class="iconSpan"><img src="images/icons/button-delete.png" alt="Sign Out Child" title="Click to Sign a Child Out"/><br/>Sign-out</span></a>
        
    </p>
    <p>
        <a href="index.php?mid=460&function=historic"><span class="iconSpan"><img src="images/icons/papers.png" alt="View Register" title="View Register"/><br/>View A Register</span></a>
    </p>
</div>