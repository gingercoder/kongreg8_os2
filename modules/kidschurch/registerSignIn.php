<?php

/*
 * Sign In a child to Kids Church
 */
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('Kids Church','3'); ?>
</div>
<div class="contentBox">
    <h1>Kids Church Register</h1>
    <h2>Sign In</h2>
    <a href="index.php?mid=460">&lt;&lt; Back to Registration page</a>
        <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>

    <?php 
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
        
        if(($_POST['stage'] == '1') || ($_POST['stage'] == '2')){
            if($_POST['person'] !=""){
                // Sign the child in
                $signmein = $objKidschurch->signChildIn(db::escapechars($_POST['person']), db::escapechars($_POST['groupid']), db::escapechars($_POST['parent']));
                if($signmein == true){
                    print "<p class=\"updated\">Child signed in to Kids Church</p>";
                }
                else{
                    print "<p><strong>Child could not be signed in - something went wrong, please try again</strong></p>";
                }
            }
            else{
                // Get a list of members to select from
                ?>
                <h2>Finding Members matching your search...</h2>
                
                <form name="signchildin" action="index.php" method="post">
                    <label for="person">Child : </label>
                    <select name="person" id="person">
                <?php
                print $objKidschurch->findMember($_POST['childname'], $_SESSION['Kcampus']);
                ?>
                    </select>
                    
                    <label for="parent">Parent : </label>
                    <select name="parent" id="parent">
                <?php
                print $objKidschurch->findMember($_POST['parentname'], $_SESSION['Kcampus']);
                ?>
                    </select>
                    
                    <input type="hidden" name="stage" id="stage" value="2" />
                    <input type="hidden" name="mid" id="mid" value="460" />
                    <input type="hidden" name="function" id="function" value="signin" />
                    <input type="hidden" name="groupid" id="groupid" value="<?php print  db::escapechars($_POST['groupid']); ?>" />
                    <label for="submit"></label>
                    <input type="submit" name="submit" id="submit" value="Confirm &amp; Sign In" />
                </form>
                
                <?php
            }
        }
        else{
            ?>
        <p>Enter a name (or partial name) to search for your child:</p>
        <p>
            <form name="signin" action="index.php" method="post">
                <label for="childname">Child's Name:</label>
                <input type="text" name="childname" id="childname" />
                <label for="parentname">Parent's Name:</label>
                <input type="text" name="parentname" id="parentname" />
                <label for="groupid">Kids Church Group:</label>
                <select name="groupid" id="groupid">
                    <?php print $objKidschurch->groupselectdropdown(); ?>
                </select>
                <br/><br/>
                <label for="submit"></label>
                <input type="submit" value="Find &amp; Sign In" name="submit" id="submit" />
                <input type="hidden" name="mid" id="mid" value="460" />
                <input type="hidden" name="stage" id="stage" value="1" />
                <input type="hidden" name="function" id="function" value="signin" />
            </form>
        </p>
            <?php
        }
        
    ?>

</div>
