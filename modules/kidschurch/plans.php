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
        if(isset($toggleMessage)){
            print $toggleMessage;
        }
        
        if(isset($_GET['p'])){
            print $objKidschurch->showPlans($_SESSION['Kcampus'], $_GET['p']);
        }
        else{
            print $objKidschurch->showPlans($_SESSION['Kcampus']);
        }
        ?>
        
</div>
<div class="contentBoxRight">
    <h2>Add new Plan</h2>
    <form name="addplan" action="index.php" method="post">
        <label for="plantitle">Plan Title</label>
        <input type="text" name="plantitle" id="plantitle"/>
                
        <label for="planactivities">Plan Activities</label>
        <textarea name="planactivities" id="planactivities"></textarea>
        
        <label for="plandate">Plan Date</label>
        <input type="text" name="plandate" id="plandate" placeholder="yyyy-mm-dd" />
        
        <label for="planmaterials">Materials Required</label>
        <textarea name="planmaterials" id="planmaterials"></textarea>
        
        <label for="planconsent">Consent Required?</label>
        <select name="planconsent" id="planconsent"><option value="no" default>No</option><option value="yes">Yes</option></select>
        
        <label for="campus">Campus</label>
        <?php print $objKongreg8->viewCampusDropdown(); ?>
        
        <label for="submit"></label>
        <input type="submit" id="submit" name="sumbit" value="Create" />
        
        <input type="hidden" name="mid" id="mid" value="450" />
        <input type="hidden" name="action" id="action" value="add" />
    </form>
</div>

