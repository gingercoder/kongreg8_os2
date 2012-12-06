<?php

/*
 * Sign a child OUT of kids church
 */
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Kids Church','3'); ?>
</div>
<div class="contentBox">
    <h1>Kids Church Register</h1>
     <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>

    <h2>Sign Out</h2>
    <p>
    <a href="index.php?mid=460">&lt;&lt; Back to Registration page</a>
    </p>
    
    <?php 
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
            if(($_GET['stage'] == 1)||($_POST['stage'] == 1)){
                // confirm who is signing them out
                if($_POST['stage']==1){
                    // Parent verified
                    if($_POST['altperson'] !=""){
                        // Run routine to verify the person 
                        
                    }
                    else{
                        // Just using the same parent
                        
                    }
                }
                else{
                    // Form to verify same parent
                    ?>
        <form name="signout" action="index.php" method="post">
            <p>
            Signed in by :<br/>
            <?php print $objKidschurch->getParentInfo($_GET['person']); ?>
            </p>
            <p>
                If not this parent signing out enter new details:
            </p>
            <label for="altperson">Name of parent/guardian</label>
            <input type="text" name="altperson" id="altperson" />  
            <input type="hidden" name="mid" id="mid" value="460" />
            <input type="hidden" name="stage" id="stage" value="1" />
            <input type="hidden" name="person" id="person" value="<?php print $_GET['person']; ?>" />
            <input type="hidden" name="rid" id="rid" value="<?php print $_GET['rid'];?>" />
            <label for="submit"></label>
            <input type="submit" value="Sign Out" />
        </form>
        
                    <?php
                }

        }
        else{
            $objKidschurch->displaySignedIn();
        }
        
    ?>

</div>
