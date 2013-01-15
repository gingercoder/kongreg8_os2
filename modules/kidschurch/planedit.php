<?php

/*
 * Plans Edit page
 */


if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
    
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Kids Church Plans','1'); ?>
</div>
<div class="contentBox">
    <h1>Kids Church Plans</h1>
    <h2>Edit Plan</h2>
        <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>

        <?php
        if(isset($toggleMessage)){
            print $toggleMessage;
        }
        if(isset($_GET['p'])){
            $plan = $objKidschurch->viewPlan($_GET['p']);
            $planid = $_GET['p'];
        }
        else{
            $plan = $objKidschurch->viewPlan($_POST['p']);
            $planid = $_POST['p'];
        }
        ?>
            <form name="addplan" action="index.php" method="post">
                <label for="plantitle">Plan Title</label>
                <input type="text" name="plantitle" id="plantitle" value="<?php echo $plan['activityTitle']; ?>"/>

                <label for="planactivities">Plan Activities</label>
                <textarea name="planactivities" id="planactivities"><?php echo $plan['activities']; ?></textarea>

                <label for="plandate">Plan Date</label>
                <input type="text" name="plandate" id="plandate" placeholder="yyyy-mm-dd"  value="<?php echo $plan['activityDate']; ?>"/>

                <label for="planmaterials">Materials Required</label>
                <textarea name="planmaterials" id="planmaterials"><?php echo $plan['materialsNeeded']; ?></textarea>

                <label for="planconsent">Consent Required?</label>
                <select name="planconsent" id="planconsent">
                    <option value="<?php echo $plan['consentRequired']; ?>">*<?php echo $plan['consentRequired']; ?></option>
                    <option value="no" default>No</option>
                    <option value="yes">Yes</option></select>

                <label for="campus">Campus</label>
                <?php print $objKongreg8->viewCampusDropdown(); ?>

                <label for="submit"></label>
                <input type="submit" id="submit" name="sumbit" value="Save" />

                <input type="hidden" name="mid" id="mid" value="450" />
                <input type="hidden" name="p" id="p" value="<?php print $planid; ?>" />
                <input type="hidden" name="action" id="action" value="edit" />
                <input type="hidden" name="confirm" id="confirm" value="true" />
            </form>

</div>


