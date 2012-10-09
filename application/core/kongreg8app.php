<?php


/**
 * kongreg8app
 * Main functions for the Kongreg8 application framework
 * Pulls data from the DB and calculates / maintains settings
 * for the whole of the Kongreg8 framework.
 * 
 * The kongreg8app function is used as the basis for extensions in other modules
 * allowing the targeting of information using $this->
 * 
 * @author rick
 */
class kongreg8app{
    
    
    /*
     * Provide information about the version number and what updates have
     * been applied to the system
     * 
     */
    
    public function version()
    {
        
        // Get the current system version from the database
        
        $sql = "SELECT * FROM settings WHERE settingName='systemVersion'";
        $result = db::returnrow($sql);
        
        return $result['settingValue'];
        
    }
    
    /*
     * System Information and Configuration Options
     * 
     */
    public function getSystemInfo()
    {
        print "Kongreg8 v" . $this->version();
        
        print "<br/>Server PHP Version: " . phpversion();
        
        print "<h2>module info</h2>" . $this->getModuleList();
        
        print help::displayHelp('about', '1');
    }
    
    /*
     * Entire Module List (maintained in DB)
     * 
     */
    public function getModuleList()
    {
        
        $sql = "SELECT * FROM kmodules ORDER BY moduleName ASC";
        $result = db::returnallrows($sql);
        $modulelist = "";
        foreach($result as $module){
            
            $modulelist .= "<span class=\"moduleName\">" . $module['moduleName'] . "</span> - version " . $module['moduleVersion'] . " -  Author " . $module['moduleAuthor'];
            $modulelist .= "<span class=\"moduleRequire\"> [ Requires Level " . $module['userlevel'] . " ]</span><br/>";
        }
        return $modulelist;
    }
    /*
     * Select what module we are loading by cleansing incomming vars
     * in partnership with the brain function
     * 
     */
    
    public function selectmodule()
    {
        // Get what I'm supposed to load as a module from the URL 
        // Or passed variables
        if($_POST['mid'] !=""){
            $module = db::escapechars(trim($_POST['mid']));
        }
        else{
            $module = db::escapechars(trim($_GET['mid']));
        }
        return $module;
    }
    
    
    
    
    /*
     * 
     * Do main authentication for the system checking credentials passed from login
     * to here and then set session variables or provide error code response.
     * 
     * 
     */
    
    public function doauth($username, $password)
    {
        // Authenticate from the main log in form
        
        $username = stripslashes(db::escapechars($username));
        $password = stripslashes(db::escapechars($password));
        
        
        
        // --- IDS Detection Routine -- 
        // check how many failed authentications have taken place
        $startTime = date('H:i:s',mktime(date('H'), (date('i')-5), date('s'))); // five minutes ago
        $nowTime = date ('H:i:s'); // now

        $todayDate = date('Y-m-d'); // today
        $sql = "SELECT * FROM klog WHERE logValue LIKE '$username Failed sign in%'";
        $sql .= " AND logDate = '$todayDate' AND (logTime BETWEEN '$startTime' AND '$nowTime')";
        
        $numFailedAuths = 0;
        $numFailedAuths = db::getnumrows($sql);
        // IF less than maximum of 4 failed authentications reached do auth, else give a message.
        if($numFailedAuths < 5)
        {
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = db::returnrow($sql);
            if($result)
            {
                $resultArray = db::returnrow($sql);
                // If there is a match set the session variables
                $md5Pass = md5($password);
                if($md5Pass == $resultArray['password'])
                {
                    $userID = $resultArray['userID'];
                    $userLevel = $resultArray['userlevel'];

                    // Set the session variables
                    $_SESSION['Kusername']= $username;
                    $_SESSION['Kpasswd'] = $md5Pass;
                    $_SESSION['Kulevel'] = $userLevel;

                    // Log the activity
                    $logType = "System Auth";
                    $IPAddress = $_SERVER["REMOTE_ADDR"];
                    $logValue = "$username Successful sign in from $IPAddress";
                    $logArea = "Auth";
                    
                    $this->logevent($logType, $logValue, $logArea);

                    
                    // return success of auth
                    $successcode = "111";
                    return $successcode;
                }
                else
                {
                    // Log the activity
                    $logType = "System Auth";
                    $IPAddress = $_SERVER["REMOTE_ADDR"];
                    $logValue = "$username Failed sign in from $IPAddress";
                    $logArea = "Auth";
                   
                    $this->logevent($logType, $logValue, $logArea);
                    
                    
                    // return failure
                    $failcode = "101";
                    return $failcode;
                }
         }
         else
             {
                 // Couldn't find the username in the database
                 // Log the activity
                 $logType = "System Auth";
                 $IPAddress = $_SERVER["REMOTE_ADDR"];
                 $logValue = "$username Failed sign in from $IPAddress";
                 $logArea = "Auth";
                 
                 $this->logevent($logType, $logValue, $logArea);
                 
                 // Return the failure code
                 $failcode = "101";
                 return $failcode;
             }
       }
       else
       {
            // Maximum failure attempts reached - return failure code
           $failcode = "102";
           return $failcode;
       }
        
    }
    
    
    
    
    
    /*
     * 
     * Maintain authentication of the system throughout page loads
     * re-check the session variables against the system in case of
     * injection or manipulation
     * 
     */
    
    
    public function maintainauth()
    {
        
        // Maintain Authentication using session variables and a connection to the DB
        
        if(($_SESSION['Kusername'] == "") || ($_SESSION['Kpasswd'] == "") || ($_SESSION['Kulevel'] == ""))
        {
            if(($_POST['username'] !== "") && ($_POST['passwd'] !== "") && ($_POST['mid'] == "100"))
            {
                // Authenticating against scripts so allow through this check script
                return 'authing';
            }
            else
            {
                // Log in form required
                return 'noauth';    
            }
        }
        else
        {
            /*
            *
            * Should be authenticated ok but always check the authentication
            * in case SESSION vars are being tampered with
            *
            */
            $Kusername = strip_tags(stripslashes($_SESSION['Kusername']));
            $sql = "SELECT * FROM users WHERE username = '".$Kusername."'";
            $result = db::returnrow($sql);
            if($result){
                    // If there is a match set the session variables
                    if($_SESSION['Kpasswd'] == $result['password']){
                            $_SESSION['Kusername'] = $Kusername;
                            $_SESSION['Kpasswd'] = $_SESSION['Kpasswd'];
                            $_SESSION['Kulevel'] = $result['userlevel'];
                            $_SESSION['Kcampus'] = $result['campus'];
                            
                            return 'auth';
                    }
                    else{
                            // Stored data doesn't match that passed to it
                            // Kill the session variables and give an error message
                            $_SESSION['Kusername'] = "";
                            $_SESSION['Kpasswd'] = "";
                            $_SESSION['Kulevel'] = "";
                            $_SESSION['Kcampus'] = "";
                            session_destroy();
                            
                            return 'noauth';
                    }
            }
            else{
                    // Couldn't get the username - need to authenticate again because something is wrong
                    
                    return 'noauth';
            }
         }
        }
        
        
        
        
        
        
        /*
         * LOG OUT OF THE SYSTEM
         * Kill all session variables
         * 
         */
        public function logout()
        {
            // Kill the session variables and give an error message
            $_SESSION['Kusername'] = "";
            $_SESSION['Kpasswd'] = "";
            $_SESSION['Kulevel'] = "";
            $_SESSION['Kcampus'] = "";
            session_destroy();
        }
        
        
        /*
         * CHECK WHAT CAMPUS INFORMATION YOU SHOULD SEE
         * This is used to limit administrators to a specific campus
         * information set, or to allow access to all.
         */
        public function checkCampus(){
            if($_SESSION['Kcampus'] == 'all'){
                return true;
            }
            else{
                if($_SESSION['Kcampus'] != ""){
                    return intval($_SESSION['Kcampus']);
                }
                else{
                    return false;
                }
            }
        }
        
        
        /*
         * 
         * Log events in the system, passed parameters from each module
         * 
         */
        
        public function logevent($logType, $logValue, $logArea)
        {
            $theTime = date('H:i:s');
            $theDate = date('y-m-d');
            $sql = "INSERT INTO klog
                    SET
                    logTime='$theTime',
                    logDate='$theDate',
                    logType='" . db::escapechars($logType) . "',
                    logValue='" . db::escapechars($logValue) . "',
                    logArea='" . db::escapechars($logArea) . "'
                    ";
            
            $result = db::execute($sql);
        }
        
        
        /*
         * 
         * Log errors in the system, passed parameters from each module
         * 
         */
        
        public function logerror($logType, $logValue, $logArea)
        {
            $theTime = date('H:i:s');
            $theDate = date('y-m-d');
            $sql = "INSERT INTO kerrorlog
                    SET
                    logTime='$theTime',
                    logDate='$theDate',
                    logType='" . db::escapechars($logType) . "',
                    logValue='" . db::escapechars($logValue) . "',
                    logArea='" . db::escapechars($logArea) . "'
                    ";
            
            $result = db::execute($sql);
        }
        
        /*
         * 
         * Last Log In by a user
         * 
         */
        public function lastlogin($username){
            $sql = "SELECT * FROM klog WHERE logValue LIKE '" . db::escapechars($username) . " Successful sign in%' ORDER BY logDate DESC";
            $result = db::returnrow($sql);
            $lastlogintime =  $result['logDate']." at " .$result['logTime'];
            return $lastlogintime;
        }
        
        /*
         * return the user ID for a particular user name
         * used in several functions throughout the system
         * 
         */
        public function usernametoid($username){
            $userName = db::escapechars($username);
            $sql = "SELECT * FROM users WHERE username = '$userName'";
            $result = db::returnrow($sql);
            return $result['userID'];
        }
        
        
        /*
         * return the name of the user for the ID for a particular user name
         * used in several functions throughout the system
         * 
         */
        public function useridtoname($userid){
            $userID = db::escapechars($userid);
            $sql = "SELECT * FROM users WHERE userID = '$userID'";
            $result = db::returnrow($sql);
            return $result['firstname'] . " " . $result['surname'];
        }
        
        /*
         * Function to return the member name from the memberID passed
         * Used for various functions like groups
         */
        public function memberidtoname($userid){
            $userid = db::escapechars($userid);
            $sql = "SELECT firstname, surname FROM churchmembers WHERE memberID='$userid'";
            $result = db::returnrow($sql);
            if($result){
                return $result['firstname']." ".$result['surname'];
            }
            else{
                return false;
            }
        }
        
        /*
         * Check the user level for modules and allow or deny based on the response
         * Used for each module to re-validate the ability of a user to have access
         * to a module. This allows access levels to change without a sign out/in
         * for the user if a higher-level administrator is online, and also allows 
         * the revoking of privileges should it be necessary instantaneously.
         * 
         */
        public function checkAccessLevel($modulename){
            
            $modulename = db::escapechars($modulename);
            $userid =$this->usernametoid($_SESSION['Kusername']);
            $sql = "SELECT * FROM kmodules WHERE moduleName = '$modulename'";
            $result = db::returnrow($sql);
            $moduleuserlevel = $result['userlevel'];
            
            $userlevel = $_SESSION['Kulevel'];
                if($userlevel >= $moduleuserlevel){
                    
                    return true;
                }
                else{
                    
                    return false;
                }
            
            
        }
        
        /*
        * Generate Date and Time field input boxes for any forms requiring them
        * across the whole appication 
        */
        public function generateTimeDateInput(){

            print "Date: ";
            // Create the Day input field
            print "<select name=\"dateDay\" id=\"dateDate\">";
            print "<option value=\"--\">--</option>";
                for($i=1;$i<=31;$i++){
                    print "<option value=\"$i\">$i</option>";
                }
            print "</select>";

            // Create the Month input field
            print "<select name=\"dateMonth\" id=\"dateMonth\">";
                print "<option value=\"--\">--</option>";
                print "<option value=\"01\">January</option>";
                print "<option value=\"02\">February</option>";
                print "<option value=\"03\">March</option>";
                print "<option value=\"04\">April</option>";
                print "<option value=\"05\">May</option>";
                print "<option value=\"06\">June</option>";
                print "<option value=\"07\">July</option>";
                print "<option value=\"08\">August</option>";
                print "<option value=\"09\">September</option>";
                print "<option value=\"10\">October</option>";
                print "<option value=\"11\">November</option>";
                print "<option value=\"12\">December</option>";
            print "</select>";

            // Create the Day input field
            print "<select name=\"dateYear\" id=\"dateYear\">";
                print "<option value=\"--\">--</option>";
                $theyear = date('Y');
                for($i=1;$i<10;$i++){
                    print "<option value=\"$theyear\">$theyear</option>";
                    $theyear++;
                }
            print "</select>";

            print "<br/>";
            print "Time: ";
            // Create the Hour input field
            print "<select name=\"dateHour\" id=\"dateHour\">";
                print "<option value=\"--\">--</option>";
                for($i=1;$i<=24;$i++){
                    if($i < 10){
                        print "<option value=\"0$i\">0$i</option>";
                    }
                    else{
                        print "<option value=\"$i\">$i</option>";
                    }
                }
            print "</select>";

            // Create the Minute input field
            print "<select name=\"dateMinute\" id=\"dateMinute\">";
            print "<option value=\"--\">--</option>";
                for($i=0;$i<=59;$i++){
                    if($i < 10){
                        print "<option value=\"0$i\">0$i</option>";
                    }
                    else{
                        print "<option value=\"$i\">$i</option>";
                    }
                }
            print "</select>";

            print "<br/>";
        }
    
        
        
        /*
         * 
         * Phone Home to check for new updates of the software
         * 
         */
        public function checkForUpdates()
        {
            
            // Run a call back to the PizzaBoxSoftware site to check for current versions 
            $xml = simplexml_load_file("http://www.pizzaboxsoftware.co.uk/kongreg8os2/updates/current.xml");

            print $xml->getName() . "<br />";

            foreach($xml->children() as $child)
            {
                print $child->getName() . ": " . $child . "<br/>";
                if($child->getName() == "version")
                {
                    $myversion = $child;
                }
            }
            return $myversion;
            
            
        }
        
        /*
         * Get error overview for the system - any major errors that have occurred in the last 7 days
         * 
         * 
         */
        public function getErrorOverview()
        {
            // Today and last week variables for SQL
            $today = date('Y-m-d');
            $lastweek = date('Y-m-d', strtotime("-1 week"));
                
            $sql = "SELECT * FROM kerrorlog WHERE logDate >= $lastweek AND logDate <= $today";
            $numitems = db::getnumrows($sql);
            print "<p>There have been $numitems errors discovered in the last 7 days by the application</p>";
            return;
        }
        
        
        /*
         * Change password function
         * 
         */
        public function changePassword($oldpass, $newpass)
        {
            $oldpass = md5($oldpass);
            $newpass = md5($newpass);
            
            if($oldpass == $_SESSION['Kpasswd']){
                
                $sql = "UPDATE users SET password='".$newpass."' WHERE username='".$_SESSION['Kusername']."' LIMIT 1";
                $result = db::execute($sql);
                if($result){
                    $_SESSION['Kpasswd'] = $newpass;
                    // Log the activity
                        $logType = "Account Update";
                        $logValue = $_SESSION['Kusername']." changed their password";
                        $logArea = "Account";				
                        $this->logevent($logType, $logValue, $logArea);
                    return true;
                }
                else{
                    // Log the failure
                        $logType = "Update Fail";
                        $logValue = $_SESSION['Kusername']." failed updating password ".db::escapechars($sql);
                        $logArea = "Account";				
                        $this->logerror($logType, $logValue, $logArea);
                    return false;
                }
            }
            else{
                return false;
            }
            
        }
        
        
        /*
         * 
         * Function to check for htaccess files in correct locations
         * Creates the files if they do not exist and warns the user
         * 
         */
        public function checkhtaccess()
        {
            $appPath = "application/.htaccess";
            $modPath = "modules/.htaccess";
            
            if(!file_exists($appPath)){
                print "<strong>htaccess file missing from application path - creating now</strong> ";
                $fh = fopen($appPath, 'w') or print("can't create file");
                $accessText = "order allow,deny\nallow from 127.0.0.1\ndeny from all\n";
                fwrite($fh, $accessText);
                fclose($fh);
                print "<br/>Written";
            }
            else{
                print "htaccess application file exists<br/>";
            }
            if(!file_exists($modPath)){
                print "<strong>htaccess file missing from module path - creating now</strong> ";
                $fh = fopen($modPath, 'w') or print("can't create file");
                $accessText = "order allow,deny\nallow from 127.0.0.1\ndeny from all\n";
                fwrite($fh, $accessText);
                fclose($fh);
                print "<br/>Written";
            }
            else{
                print "htaccess module file exists<br/>";
            }
            return;
        }
        
        
     /*
     * Function to allow the downloading of a file
     * 
     */
    public function downloadExport($filename,$checksum)
    {
        
        $filename = db::escapechars($filename);
        $checksum = db::escapechars($checksum);
        $filepath = "application/export/files/";
        $myfile = $filepath . $filename;
        if(md5($myfile) == $checksum){
            if(file_exists($myfile)){
                $fsize = filesize($myfile);
                header("Content-disposition: filename=$filename"); 
                header('Content-type: application/octet-stream'); 
                header("Content-length: $fsize");
                $fd = fopen ($myfile, "r");
                
                while(!feof($fd)) {
                    $buffer = fread($fd, 2048);
                    echo $buffer;
                } 
                
                return true;
            }
            else{
                return "File not found";
            }
        }
        else{
            print "Incorrect link";
            return false;
        }
        
    }
    
     /*
     * Function to allow the downloading of a backup file
     * 
     */
    public function downloadBackup($filename,$checksum)
    {
        
        $filename = db::escapechars($filename);
        $checksum = db::escapechars($checksum);
        $filepath = "application/backup/files/";
        $myfile = $filepath . $filename;
        if(md5($myfile) == $checksum){
            if(file_exists($myfile)){
                $fsize = filesize($myfile);
                header("Content-disposition: filename=$filename"); 
                header('Content-type: application/octet-stream'); 
                header("Content-length: $fsize");
                $fd = fopen ($myfile, "r");
                
                while(!feof($fd)) {
                    $buffer = fread($fd, 2048);
                    echo $buffer;
                } 
                
                return true;
            }
            else{
                return "File not found";
            }
        }
        else{
            print "Incorrect link";
            return false;
        }
        
    }
}

?>
