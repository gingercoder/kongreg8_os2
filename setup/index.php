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

    ?>
        <div class="contentBox">
        <h1>First-Run Set-up</h1>
        <h2>Processing and setting up your new system...</h2>
        <p>
            <strong>Database set-up</strong><br/>
            Creating your database
        </p>
        <p>
            <strong>Creating user</strong><br/>
            Setting up your primary administration account
        </p>
        <p>
            <strong>Preparing your system</strong><br/>
            Setting up your system
        </p>
        
        </div>
        <div class="contentBox">
            <h2>Processing Complete</h2>
        <p>
            <strong>Ready for you</strong><br/>
            Processing now complete - you can now log in using your primary administration account.
        </p>
        <p>
        [ <a href="../index.php">Log me in now</a> ]
        </p>

    <?php
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
            but this may vary depending on your hosting provider.
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
        <form name="setupscript" action="index.php" method="post">
            <h2>Database</h2>
            <input type="hidden" name="save" id="save" value="1" />
            <label for="dbserver">DB Server</label>
            <input type="text" name="dbserver" id="dbserver" placeholder="localhost" />
            <label for="dbuser">DB User</label>
            <input type="text" name="dbuser" id="dbuser" />
            <label for="dbpassword">DB Password</label>
            <input type="text" name="dbpassword" id="dbpassword" />
            <h2>Application Name and Settings</h2>
            <label for="churchname">Church Name</label>
            <input type="text" name="churchname" id="churchname" />
            <label for="kname">Kongreg8 Application Name</label>
            <input type="text" name="kname" id="kname" placeholder="Kongreg8 OS2"/>
            <label for="adminname">Primary Admin User Name</label>
            <input type="text" name="adminname" id="adminname" placeholder="kadmin" />
            <label for="adminpassword">Primary Admin Password</label>
            <input type="password" name="adminpassword" id="adminpassword" />
            <label for="adminname">Primary Admin User Email</label>
            <input type="text" name="adminemail" id="adminemail" />
            <label for="churchemail">church contact email address</label>
            <input type="text" name="churchemail" id="churchemail" />
            
            <br/><br/>
            <input type="submit" value="Save and Launch" />
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