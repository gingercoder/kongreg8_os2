<?php

/*
 * Intrusion Detection System Overview
 */

if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
   
?>
<div class="contentBoxLeft">
    <h1>Intrusion Detection System</h1>
    <p>
        The intrusion detection system operates in the background for log-in and module authentication. 
    </p>
    <?php
    
    if(!empty($idsTable)){
        print $idsTable;
    }
    else{
        print "<p>There are no failed entries in the database at this time or matching your search period.</p>";
    }
            
    ?>
</div>

<div class="contentBoxRight">
    <h2>Confine results</h2>
    <form name="idssearch" action="index.php" method="post">
        <input type="hidden" value="999901" name="mid" id="mid" />
        <label for="startdate">Start Date:</label>
        <input type="text" name="sdate" id="sdate" placeholder="yyyy-mm-dd" />
        <label for="startdate">End Date:</label>
        <input type="text" name="edate" id="edate" placeholder="yyyy-mm-dd" />
        <label for="submit">&nbsp;</label>
        <input type="submit" value="Search" name="submit" id="submit" />
    </form>
</div>