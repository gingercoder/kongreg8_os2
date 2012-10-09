<?php

/*
 * Firewall Settings Page
 */

if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>
<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('firewall','1'); ?>
</div>
<div class="contentBox">
    <?php
    // Change the firewall state if told by the user
    if($_GET['fw'] !="")
    {
        if($_GET['fw'] == "off")
        {
            $objFirewall->setstate('off');
        }
        elseif($_GET['fw'] == "on")
        {
            $objFirewall->setstate('on');
        }
    }
    
    
    $fwstate = $objFirewall->checkstate();
    if($fwstate == TRUE)
    {
        print "<p style=\"float: right;\"><a href=\"index.php?mid=999900&fw=off\" class=\"fwon\" title=\"Click to turn off\">&nbsp;</a></p>";
    }
    else{
        print "<p style=\"float: right;\"><a href=\"index.php?mid=999900&fw=on\" class=\"fwoff\" title=\"Click to turn on\">&nbsp;</a></p>";
    }
    ?>
    <h1>Firewall</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <?php
    if($entryupdatemessage !=""){
        print $entryupdatemessage;
    }
    ?>
    <p>
        Current firewall settings for your Kongreg8 installation:
    </p>
    
    <?php
    
    if($_GET['rid'] !=""){
        $ruleid = db::escapechars($_GET['rid']);
    }
    else{
        $ruleid = '';
    }
    
    $objFirewall->getRuleList($ruleid);
    
    ?>
    
    
</div>
<div class="contentBox">
    <h2>Warning !</h2>
    <p>
        <strong>Changes made here can lock you out of the system. Use the firewall setting wisely. If you are unsure 
        how to specify the details correctly please refer to the help documentation.</strong>
    </p>
    <p>
        If you are having persistent failed attempts from a single I.P. address it is better to simply deny this address than 
        to deny everything outright and only allow a handful of I.P. addresses.<br/>
        It <em>is</em> better security practice to only allow a small sub-set of I.P. addresses, however. Use the facility 
        wisely knowing what the consequences are.
    </p>
    <p>
        Please note :- the firewall system works on a default deny basis - if you do not implicitly give an any-allow before the default 
        setting it will default to a secure lock-down.
    </p>
</div>