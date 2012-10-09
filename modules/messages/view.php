<?php

/*
 * Message View output
 * 
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
   
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('messages','0'); ?>
</div>
<div class="contentBoxLeft">
    <h1>My Messages</h1>
    <a href="index.php?mid=690">&lt;&lt; Back to inbox</a>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <?php
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
    ?>
    <h2>View message &amp; Thread</h2>
    <p>
        <?php print "On " . $mymessage['datelogged'] . " " . $objKongreg8->memberidtoname($mymessage['userID']) . " wrote:"; ?>
    </p>
    <p>
        <?php print $mymessage['mainmessage']; ?>
    </p>
</div>
<div class="contentBoxRight">
    <h2>Reply to Message</h2>
    <form name="newmessage" action="index.php" method="post">
        <input type="hidden" name="mid" id="mid" value="691" />
        <input type="hidden" name="reply" id="reply" value="true" />
        <input type="hidden" name="inReplyTo" id="inReplyTo" value="<?php print $mymessage['messageID']; ?>" />
        <input type="hidden" name="towho" id="towho" value="<?php print $mymessage['userID']; ?>" />
        <label for="title">Message Title</label>
        <input type="text" name="title" id="title" />
        <label for="message">Message</label>
        <textarea name="message" id="message"></textarea>
        <label for="submit">&nbsp;</label>
        <input type="submit" name="submit" value="Send Reply" />
    </form>
</div>

<div class="contentBoxLeft">
    <h2>Message Threads</h2>
    <?php 
    if(!empty($threads)){
    
    ?>
    <div class="messageThreads">
        <?php
        foreach($threads as $reply){
            print "<span><strong>" . $reply['datelogged'] . " by " . $objKongreg8->useridtoname($reply['userID']) . "</strong><br/>" . $reply['mainmessage'] . "</span>"; 

        }
        
        ?>
    </div>
    <?php
    }
    else{
        print "<p>There are no current threads</p>";
    }
    ?>
</div>
