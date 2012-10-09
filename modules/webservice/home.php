<?php

/*
 * Webservice state display
 */


if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('webservice','0'); ?>
</div>
<div class="contentBoxLeft">
    <?php
    // Change the web service state if told by the user
    if($_GET['api'] !="")
    {
        if($_GET['api'] == "off")
        {
            $objWebservice->toggleWebservice(0);
        }
        elseif($_GET['api'] == "on")
        {
            $objWebservice->toggleWebservice(1);
        }
    }
    
    
    $fwstate = $objWebservice->checkAPIstate();
    if($fwstate == TRUE)
    {
        print "<p style=\"float: right;\"><a href=\"index.php?mid=900&api=off\" class=\"fwon\" title=\"Click to turn off\">&nbsp;</a></p>";
    }
    else{
        print "<p style=\"float: right;\"><a href=\"index.php?mid=900&api=on\" class=\"fwoff\" title=\"Click to turn on\">&nbsp;</a></p>";
    }
    ?>
    <h1>Web Service</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <?php
    if($toggleMessage !=""){
        print $toggleMessage;
    }
    ?>
    <p>
        Current Web service users
    </p>
    <?php
        $objWebservice->showServiceUsers();
    ?>
    
</div>
<div class="contentBoxRight">
    <h2>Assign Keys</h2>
    <form name="assignapikey" action="index.php" method="post">
        <input type="hidden" name="mid" id="mid" value="900" />
        <input type="hidden" name="action" id="action" value="createkey"
        <label for="userid">User:</label>
        <select name="userid" id="userid">
            <?php
                print $objWebservice->getNonKeyUserSelect();
            ?>
        </select>
        <label for="submit">&nbsp;</label>
        <input type="submit" name="submit" id="submit" value="Generate Key" />
    </form>
</div>
<div class="contentBox">
    <h2>Web service API information</h2>
    <p>
        The Kongreg8 web service API can be used to access information for use in your own applications. Users <strong>must</strong> have their own assigned 
        API key. This is done on an individual basis using the control above.
    </p>
    <p>
        To get a list of all web services available in this version of the system please see the help area.
    </p>
</div>