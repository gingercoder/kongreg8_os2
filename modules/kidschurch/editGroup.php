<?php

/*
 * Edit a group already in existence
 */

if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
   
?>

<div class="contentBox">
<h2>Edit Kidschurch Group &quot;<?php print $groupname; ?>&quot;</h2>
<?php 
        if(!empty($toggleMessage)){
            print $toggleMessage;
        }
?>

<p><a href="index.php?mid=300">&lt;&lt; Back to groups</a></p>
    <form name="addgroup" action="index.php" method="post" >
        <input type="hidden" name="mid" id="mid" value="405" />
        <input type="hidden" name="leader" id="leader" value="<?php print $leader; ?>" />
        <input type="hidden" name="g" id="g" value="<?php print $groupid; ?>" />
        <input type="hidden" name="action" id="action" value="save" />
        <label for="groupname">Group Name</label>
        <input type="text" name="groupname" id="groupname" value="<?php print $groupname; ?>"/>
        <label for="groupdescription">Description</label>
        <textarea id="groupdescription" name="groupdescription"><?php print $groupdescription; ?></textarea>
        <label for="submit">&nbsp;</label>
        <input type="submit" value="Update" />
    </form>
</div>