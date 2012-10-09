<?php

/*
 * System Info and Config Options
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}

?>

<div class="contentBox">
    <h1>system information</h1>
    
    <?php print $objKongreg8->getSystemInfo(); ?>
    
</div>
<div class="contentBox">
    <h1>Checking for updates...</h1>
    <p>Remote server responds:</p>
    <?php 
        $myversion = $objKongreg8->checkForUpdates(); 
        $runningversion = $objKongreg8->version();
        
        if(number_format(str_replace('.','', $myversion)) > number_format(str_replace('.','', $runningversion)))
        {
            print "<h3>Your version is out of date, consider upgrading soon</h3>";
        }
        else{
            print "<h3>Your version is up to date</h3>";
        }
    ?>
</div>
<br/><br/>