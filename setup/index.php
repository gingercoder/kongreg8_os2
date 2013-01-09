    <html>
    <head>
        <title>Kongreg8 Setup</title>
        <link rel="stylesheet" href="../css/screen.css" media="all" type="text/css" />
    </head>
    <body>
<?php

/*
 * First launch set up script
 */

if($_POST['save'] == 1){

    // Create the DB links, build the database and prepare the user account
    
    $mydbname = strip_tags(stripslashes(trim($_POST['dbname'])));
    $mydbuser = strip_tags(stripslashes(trim($_POST['dbuser'])));
    $mydbserver = strip_tags(stripslashes(trim($_POST['dbserver'])));
    $mydbpass = strip_tags(stripslashes(trim($_POST['dbpassword'])));
    $churchname = strip_tags(stripslashes(trim($_POST['churchname'])));
    $appname = strip_tags(stripslashes(trim($_POST['kname'])));
    $adminname = strip_tags(stripslashes(trim($_POST['adminname'])));
    $adminpass = strip_tags(stripslashes(trim($_POST['adminpassword'])));
    $adminemail = strip_tags(stripslashes(trim($_POST['adminemail'])));
    $churchemail = strip_tags(stripslashes(trim($_POST['churchemail'])));
    
    if(($mydbname == "")||($mydbuser == "")||($adminname == "")||($adminpass == "")){
                
        print "<h1>Error!</h1><p>You did not provide core information necessary to build your system, please try again.</p>";
    }
    else{
    ?>
        <div class="contentBox">
        <h1>First-Run Set-up</h1>
        <h2>Processing and setting up your new system...</h2>
        <p>
            <strong>Database set-up</strong><br/>
            Creating your database
        </p>
        <?php
        // Create the DB Link
            $dbdetails = "<?php \r\n\r\n// DB CONNECTION FILE\r\n\r\n";
            
            $dbdetails .= "\$dbuser = '".$mydbuser."';\r\n\$dbhost = '".$mydbserver."';\r\n\$dbpass = '".$mydbpass."';\r\n\$dbname = '".$mydbname."';\r\n";
            $dbdetails .= "db::dbconnect(\$dbhost, \$dbuser, \$dbpass, \$dbname);\r\n?>";
        
            $path = "../application/db/connect.php";
        
            $fp = fopen($path,'w');
                fwrite($fp,$dbdetails);
            fclose($fp);
        ?>
        <p>
            <strong>Creating user</strong><br/>
            Setting up your primary administration account
        </p>
        <?php
        // Insert the user into the system
            require_once('../application/db/db.php');    
            require_once('../application/db/connect.php');
            
                       
            // Load SQL Function
            function loadSQLintoDB($myfile){
                //load file
                $commands = file_get_contents($myfile);

                //delete comments
                $lines = explode("\n",$commands);
                $commands = '';
                foreach($lines as $line){
                    $line = trim($line);
                    if( $line && (substr($line,0,2) != '--') ){
                        $commands .= $line . "\n";
                    }
                }

                //convert to array
                $commands = explode(";", $commands);

                //run commands
                $total = $success = 0;
                foreach($commands as $command){
                    if(trim($command)){
                        db::execute($command);
                    }
                }
            }
            print "<p>Loading primary DB...</p>";
            // open the primary sql file
            $myfile = 'dbconstruct.sql';
            $loadPrimary = loadSQLintoDB($myfile);
            print "<p>Primary System DB constructed</p>";
            
            
        ?>
        <p>
            <strong>Preparing your system</strong><br/>
            Setting up your system
        </p>
        <?php
        // Store the main settings
        
        // Create user account
        $md5pass = md5($adminpass);
        $sql = "INSERT INTO users SET firstname='System', surname='Admin', username='$adminname', password='$md5pass', userlevel='5', emailaddress='$adminemail', campus='all'";
        $result = db::execute($sql);
        $userID = db::getlastid();
        
        // Update System settings
        $sql = "UPDATE settings SET settingValue='$churchname' WHERE settingName='scrTitle'";
        $result = db::execute($sql);
        $sql = "UPDATE settings SET settingValue='$adminemail' WHERE settingName='mailRoot'";
        $result = db::execute($sql);
        $sql = "UPDATE settings SET settingValue='$churchemail' WHERE settingName='commsEmail'";
        $result = db::execute($sql);
        $sql = "UPDATE settings SET settingValue='$churchname' WHERE settingName='licensedto'";
        $result = db::execute($sql);
        
        // Set access privs for the new super user
        $sql = "SELECT * FROM kmodules";
        $result = db::returnallrows($sql);
        foreach($result as $module){
            $sql2 = "INSERT INTO useraccess SET userID='".$userID."', moduleName='".$module['moduleName']."'";
            db::execute($sql2);
        }
        
        
        print "<p>Loading NKJV Bible into DB...</p>";
            $myfile = 'bible_nkj.csv';
            $handle = fopen($myfile, "r");
                while (!feof($handle)) {
                    $data = fgetcsv($handle, 2048, ",");

                    $sql = "INSERT INTO bible_nkj VALUES ('".db::escapechars($data[0])."','".db::escapechars($data[1])."','".db::escapechars($data[2])."','".db::escapechars($data[3])."','".db::escapechars($data[4])."')";
                    db::execute($sql);
                }
            fclose($handle);
            
            
            print "<p>Bible verses inserted</p>";
            
            
        ?>
        
        </div>
        <div class="contentBox">
            <h2>Processing Complete</h2>
        <p>
            <strong>Ready for you</strong><br/>
            Processing now complete - you can now log in using your primary administration account.
        </p>
        <p>
            <strong>You should now delete your setup folder on your server to ensure security of your new system.</strong>
        </p>
        <p>
        [ <a href="../index.php">Continue to log in window</a> ]
        </p>

    <?php
    }
}
else{
?>
        <div class="contentBox">
        <h1>First-Run Set-up</h1>
        <h2>Welcome to Kongreg8 OS2 - The Church Member Database Application</h2>
        <p>
            <strong>Database set-up</strong><br/>
            Please enter some information about your database server and what you would like as your primary settings to get you started. If you don't know what your database 
            server is called or it's IP address, contact your server administrator. It is most likely called &quot;localhost&quot; 
            but this may vary depending on your hosting provider.<br/>You will need to create or have a blank database ready and provide the name below.
        </p>
        <p>
            <strong>Administration Team</strong><br/>
            Once you're going with your primary administration user you can create more accounts for different members of your church 
            administration team. There are different access levels depending on how much responsibility each member has within the 
            team. It's up to you what type of access you decide to provide them with.
        </p>
        <p>
            <strong>First Use?</strong><br/>
            If this is your first time using this software, it may be a good time to read the user manual to familiarize yourself 
            with the operation of the system. Don't worry though, help is at hand throughout the software with a new integrated 
            help system.
        </p>
        <p>
            <strong>Keep up to date</strong><br/>Keep up to date with the latest development thread on 
            [ <a href="http://www.twitter.com/#!/kongreg8" target="twitterwin">twitter</a> ] 
            or on the 
            [ <a href="http://www.pizzaboxsoftware.co.uk" target="pizzaboxwin">PizzaBoxSoftware website</a> ]
        </p>
        </div>
        <div class="contentBox">
            <strong>Please ensure the application/db folder is write enabled (755 or 777) during the setup process.</strong><br/>
        <form name="setupscript" action="index.php" method="post">
            <h2>Database</h2>
            <input type="hidden" name="save" id="save" value="1" />
            <label for="dbserver">DB Server</label>
            <input type="text" name="dbserver" id="dbserver" placeholder="localhost" />*
            <label for="dbname">DB Name</label>
            <input type="text" name="dbname" id="dbname" />*
            <label for="dbuser">DB User</label>
            <input type="text" name="dbuser" id="dbuser" />*
            <label for="dbpassword">DB Password</label>
            <input type="text" name="dbpassword" id="dbpassword" />*
            <h2>Application Name and Settings</h2>
            <label for="churchname">Church Name</label>
            <input type="text" name="churchname" id="churchname" />
            <label for="kname">Kongreg8 Application Name</label>
            <input type="text" name="kname" id="kname" placeholder="Kongreg8 OS2"/>
            <label for="adminname">Primary Admin User Name</label>
            <input type="text" name="adminname" id="adminname" placeholder="kadmin" />*
            <label for="adminpassword">Primary Admin Password</label>
            <input type="password" name="adminpassword" id="adminpassword" />*
            <label for="adminname">Primary Admin User Email</label>
            <input type="text" name="adminemail" id="adminemail" />*
            <label for="churchemail">church contact email address</label>
            <input type="text" name="churchemail" id="churchemail" />*
            <br/>
            <strong>* Please ensure you enter correct values for these fields - essential to be able to log in correctly</strong>
            <br/><br/>
            <input type="submit" value="Install Now" />
        </form>
        </div>
        <div class="contentBox">
            <h2>Progress</h2>
            <br/><br/>
            <strong>You are at step 1 of 2 installing Kongreg8 OS 2</strong><br/>
            Estimated time to completion: 5 minutes.<br/>
            Next step &gt; Use this data to create the database and set up your system.
        </div>

<?php
}
?>    
    </body>
</html>