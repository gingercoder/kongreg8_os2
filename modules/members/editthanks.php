<?php

/*
 * once processing complete of member update, show this page
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>
<div class="contentBox">
    <h1>Edit member</h1>
    
    <?php
    print $toggleMessage;
    
    if($errorMsg !=""){
        print "<h2>Errors Encountered</h2>".$errorMsg;
    }
    
    ?>
</div>
