<?php

/*
 * Main Control Panel Screen 
 * Displays all of the core features allowing selection
 * Pulls any core stats and reminders straight away.
 */


require_once('application/stats/stats.php');
$objStats = new stats();

require_once('application/messages/messages.php');
$objMessages = new messages();


$memberNonMemberStats = $objStats->storingPieChart();
        


require_once('modules/application/homepage.php');
?>
