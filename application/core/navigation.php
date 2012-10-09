<?php

/*
 * Navigation menu for users at the top of the screen.
 */

/*
 * Instantiate the reminders system in the navigation element
 * If you have reached an event point, give a warning message and link
 */

// If you're not logging out then display the navigation and any reminder information
if($_GET['mid'] !="999999"){
    require_once('application/reminders/reminders.php');
    $objReminder = new reminders();

    $warningreminder = $objReminder->checkForReminder();
    if($warningreminder != false)
    {
        print "<div class=\"reminderWarning\" id=\"reminderWarning\">$warningreminder</div>";
    }
    

?>
<div class="menuBar">
    <a href="index.php?mid=110">home</a> :: 
    <a href="index.php?mid=999991">help</a> :: 
    <a href="index.php?mid=999999">log out</a>
    <span class="searchSpan">
        <form name="searchForm" id="searchForm" action="index.php" method="post">
            <input type="text" size="30" name="searchTerm" id="searchTerm" />
            <input type="hidden" name="mid" id="mid" value="999100" />
            <input type="submit" value="Find" />
        </form>
    </span>
</div>
<br/><br/>
<?php
}
// End check of logging out
?>

