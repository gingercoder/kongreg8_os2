<?php

/*
 * Plans Output page
 */


if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
    
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Kids Church Plans','1'); ?>
</div>
<div class="contentBoxLeft">
    <h1>Kids Church Plans</h1>
        <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>

        <?php
        print $objKidschurch->showPlans($_SESSION['Kcampus']);
        ?>
        
</div>
<div class="contentBoxRight">
    <h2>Add new Plan</h2>
    <form name="addplan" action="index.php" method="post">
        <label for="planname">Plan Name</label>
        <input type="text" name="planname" id="planname"/>
                
        <label for="plandescription">Plan Description</label>
        <textarea name="planname" id="plandescription"></textarea>
        
        <label for="submit"></label>
        <input type="submit" id="submit" name="sumbit" value="Create" />
        
    </form>
</div>