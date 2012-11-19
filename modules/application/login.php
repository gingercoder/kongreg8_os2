<?php

/*
 * Main Authentication Screen
 */
$firewallstate = $objFirewall->checkip();
$firewallon = $objFirewall->checkstate();

if(($firewallstate == true)||($firewallon == false)){
?>

<div class="loginForm">
    <span class="logo"><img src="images/klogo_medium.png" alt="Kongreg8 Logo" title="Kongreg8 Logo" border="0" /></span>
    <span class="login">
        <form name="Login" action="index.php" method="post">
        <input type="hidden" name="mid" value="100" id="mid" />
        <label for="username">Username</label>
        <input type="text" name="username" id="username" />
        <label for="passwd">Password</label>
        <input type="password" name="passwd" id="passwd" />
        <label for="submit">&nbsp;</label>
        <input type="submit" value="Log In" class="submit" />
        </form>
    </span>
</div>
<?php
}
else{
    ?>

<div class="loginForm">
    <span><img src="images/klogo_medium_bnw.png" alt="Kongreg8 Logo" title="Kongreg8 Logo" border="0" /></span>
    <h2>Access Denied</h2>
    <p>
        Currently firewall rules do not allow connection from your location. Contact your administrator to allow 
        connections from your location.
    </p>
</div>
    
    <?php
    $logType = "System Auth";
                    $IPAddress = $objKongreg8->getIP();
                    $logValue = "Refused access to $IPAddress";
                    $logArea = "firewall";                 
                    $objKongreg8->logevent('$logType','$logValue','$logArea');
}
if($errors !=''){
    print "<div class=\"errormsg\">$errors</div>";
}
?>