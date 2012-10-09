<?php

/*
 * Predefined output information
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>

<div class="reportContainer">
    <h1>Report</h1>
    <?php
    $objReports->launchPredefined($_GET['prid']);
    ?>
</div>

<div class="contentBox">
    <h2>Kongreg8</h2>
    <p>
    <strong>Report created by Kongreg8 at <?php echo date('H:i d-m-Y'); ?> by <?php echo $_SESSION['Kusername']; ?></strong>
    </p>
    
</div>