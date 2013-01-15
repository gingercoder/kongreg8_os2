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
                        
                        $optionlist = $objKidschurch->findMember($_POST['altperson'], $_SESSION['Kcampus']);
                        ?>
                        <form name="signout" action="index.php" method="post">
                            <?php print "<h2>Badge #".db::escapechars($_POST['rid'])."</h2><h3>".$objKidschurch->getChildInfo(db::escapechars($_POST['person']))."</h3>"; ?>
                            <label for="altperson">Please select correct person:</label>
                            <select name="par">
                                <?php print $optionlist; ?>
                            </select>
                            <input type="hidden" name="mid" id="mid" value="460" />
                            <input type="hidden" name="function" id="function" value="signout" />
                            <input type="hidden" name="stage" id="stage" value="1" />
                            <input type="hidden" name="person" id="person" value="<?php print $_POST['person']; ?>" />
                            <input type="hidden" name="rid" id="rid" value="<?php print $_POST['rid'];?>" />
                            <label for="submit"></label>
                            <input type="submit" value="Sign Out" />
                        </form>
                        <?php
                    }
                    else{
                        // Just using the same parent
                        $signmeout = $objKidschurch->signChildOut(db::escapechars($_POST['person']), db::escapechars($_POST['par']), db::escapechars($_POST['rid']));
                        if($signmeout == true){
                            print "<p class=\"updated\">Child signed out successfully</p>";
                        }
                        else{
                            print "<p class=\"confirm\">Could not sign child out, something went wrong and I logged the error</p>";
                        }
                    }
                }
                else{
                    // Form to verify same parent
                    ?>
        <form name="signout" action="index.php" method="post">
            <?php print "<h2>Badge #".db::escapechars($_GET['rid'])."</h2><h3>".$objKidschurch->getChildInfo(db::escapechars($_GET['person']))."</h3>"; ?>
            <p>
            Signed in by :<br/>
            <?php print "<h3>".$objKidschurch->getParentInfo(db::escapechars($_GET['par']))."</h3>"; ?>
            </p>
            <p>
                If not this parent signing out enter new details in the box, otherwise click Sign Out.
            </p>
            <label for="altperson">Name of parent/guardian</label>
            <input type="text" name="altperson" id="altperson" />  
            <input type="hidden" name="mid" id="mid" value="460" />
            <input type="hidden" name="function" id="function" value="signout" />
            <input type="hidden" name="stage" id="stage" value="1" />
            <input type="hidden" name="person" id="person" value="<?php print $_GET['person']; ?>" />
            <input type="hidden" name="rid" id="rid" value="<?php print $_GET['rid'];?>" />
            <input type="hidden" name="par" id="par" value="<?php print $_GET['par'];?>" />
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
