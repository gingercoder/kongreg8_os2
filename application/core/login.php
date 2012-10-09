<?php

/*
 * Log In Screen
 */
if($_POST['mid']==100){
    // If submission of login form has occurred:
    
    
    $usrname = $_POST['username'];
    $passwrd = $_POST['passwd'];
    // Verify authentication with the system
    $authstate = $objKongreg8->doauth($usrname, $passwrd);
    // Verify the state the system returns with
    // if error message sent display errors
    if($_GET['error'] == '101')
    {
        // Credentials wrong
        $errors = "Invalid credentials. Try again.";
        require_once('modules/application/login.php');
    }
    elseif($_GET['error'] == '102')
    {
        // Authentication lockout for 5 minutes
        $errors = "Auth Lockout 5 minutes.";
        require_once('modules/application/login.php');
    }
    elseif($authstate == "111")
    {
        // Authenticated okay
        require_once('application/core/navigation.php');
        require_once('application/core/controlpanel.php');
    }
    else{
        // Failure to authenticate so display information
        $errors = "Invalid credentials. Try again.";
        require_once('modules/application/login.php');
    }
}
else{
    // First hit of the log in screen
    require_once('modules/application/login.php');
}
?>
