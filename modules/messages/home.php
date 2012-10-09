<?php

/*
 * Message Home Screen
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
          <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>

    <?php 
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
        
        $messages = $objMessages->returnMessages($_SESSION['Kusername']);
        if(count($messages > 0)){
            print "<table class=\"myreports\"><tr><th>Status</th><th>Date</th><th>From</th><th>Title</th><th>Action</th></tr>";
            foreach($messages as $message){
                print "<tr>";
                    print "<td>" . $message['messageStatus'] . "</td>";
                    print "<td>" . $message['datelogged'] . "</td>";
                    print "<td>" . $message['firstname'] . " " . $message['surname'] . "</td>";
                    print "<td>" . $message['subject'] . "</td>";
                    print "<td><a href=\"index.php?mid=691&messageid=" . $message['messageID'] . "\">View</a> / 
                            <a href=\"index.php?mid=690&remove=true&messageid=" . $message['messageID'] . "\">Remove</a>
                            </td>";
                print "</tr>";
            }
            print "</table>";
        }
        ?>
</div>
<div class="contentBoxRight">
    <h2>New Message</h2>
    <form name="newmessage" action="index.php" method="post">
        <input type="hidden" name="mid" id="mid" value="690" />
        <input type="hidden" name="create" id="create" value="true" />
        <label for="title">Message Title</label>
        <input type="text" name="title" id="title" />
        <label for="towho">Send To</label>
        <?php print $objMessages->todropdown(); ?>
        <label for="message">Message</label>
        <textarea name="message" id="message"></textarea>
        <label for="submit">&nbsp;</label>
        <input type="submit" name="submit" value="Send" />
    </form>
</div>
