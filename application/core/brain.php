<?php

/*
 * Main brain function of the software - initiates the called function 
 * 
 * Works out what is being called and builds the page accordingly
 * 
 * Having a maintained list of modules helps keep track of what is in your system
 * and what features you have enabled in the system.
 * htaccess files deny direct access to the sub-folders and they require this 
 * function to launch the modules.
 * 
 */
?>
<body>
    <div class="mainContainer">
    <?php
    
    // run a session authentication check before allowing launch of a feature
    $authcheck = $objKongreg8->maintainauth();
    if(($authcheck == 'auth') || ($authcheck == 'authing'))
    {
        $loadmodule = $objKongreg8->selectmodule();
        if($authcheck == 'auth')
        {
            require_once('application/core/navigation.php');
        }
    }
    else{
        $loadmodule = '';
    }
    
    // work out what module should be pulled from the maintained list of modules
    switch($loadmodule){
        
        
        /*
         * MEMBER FEATURES SECTION
         */
        case "200":
            // Member Add
            require_once('application/members/add.php');
            break;
        case "201":
            // Member Add Similar to just added
            require_once('application/members/addsimilar.php');
            break;
        case "205":
            // Member Add Thanks
            require_once('application/members/add.php');
            break;
        case "210":
            // Member Search
            require_once('application/members/search.php');
            break;
        case "220":
            // Member Edit
            require_once('application/members/edit.php');
            break;
        case "225":
            // Member View
            require_once('application/members/view.php');
            break;
        case "230":
            // Add family member
            require_once('application/members/familymemberadd.php');
            break;
        case "235":
            // Remove member
            require_once('application/members/remove.php');
            break;
        
        /*
         * CAMPUS FEATURES SECTION
         */
        case "240":
            // Campus Overview
            require_once('application/campus/home.php');
            break;
        case "240":
            // Campus Add and remove
            require_once('application/campus/add.php');
            break;
        case "245":
            // Campus Edit 
            require_once('application/campus/edit.php');
            break;
        
        /*
         * GROUP FEATURES SECTION
         */
        case "300":
            // Group Add
            require_once('application/groups/home.php');
            break;
        case "305":
            // Group Edit
            require_once('application/groups/editGroup.php');
            break;
        case "310":
            // Group Remove
            require_once('application/groups/home.php');
            break;
        case "320":
            // Group Email
            require_once ('application/groups/mailGroup.php');
            break;
        case "321":
            // View Group Members
            require_once ('application/groups/viewMembers.php');
            break;
        
        
        /*
         * KIDS CHURCH FEATURES SECTION
         */
        case "400":
            // Group Add
            require_once('application/kidschurch/home.php');
            break;
        case "405":
            // Group Edit
            require_once('application/kidschurch/editGroup.php');
            break;
        case "410":
            // Group Remove
            require_once('application/kidschurch/home.php');
            break;
        case "420":
            // Group Email
            require_once ('application/kidschurch/mailGroup.php');
            break;
        case "421":
            // View Group Members
            require_once ('application/kidschurch/viewMembers.php');
            break;
        case "430":
            // Resources control
            require_once ('application/kidschurch/resources.php');
            break;
        case "431":
            // Resources Edit
            require_once ('application/kidschurch/resourcesedit.php');
            break;
        
        
        
        /*
         * REPORTS FEATURES SECTION
         */
        case "500":
            require_once('application/reports/home.php');
            break;
        case "505":
            require_once('application/reports/myreports.php');
            break;
        case "506":
            require_once('application/reports/runmyreport.php');
            break;
        case "510":
            require_once('application/reports/rundefined.php');
            break;
        case "520":
            require_once('application/reports/authstats.php');
            break;
        
        case "530":
            require_once('application/stats/livestats.php');
            break;
        
        /*
         * REMINDER FEATURES SECTION
         */
        case "600":
            // View reminders and toggle any alerts
            require_once('application/reminders/home.php');
            break;
        case "601":
            // Edit reminder already existing in the system
            require_once('application/reminders/edit.php');
            break;
        
        /*
         * PASSWORD MODIFICATION
         */
        case "630":
            // Change password form and update mechanism
            require_once('application/core/password.php');
            break;
        
        /*
         *  BIBLE FEATURES
         */
        case "650":
            // view bible information
            require_once('application/bible/home.php');
            break;
        
        /*
         * MY MESSAGES FEATURES SECTION
         * 
         */
        case "690":
            // Messages Home Screen
            require_once('application/messages/home.php');
            break;
        
        case "691":
            // Messages View specific message Screen
            require_once('application/messages/view.php');
            break;
        
        /*
         * EXPORT FEATURES SECTION
         * 
         */
        case "700":
            // Main Export Functions
            require_once('application/export/home.php');
            break;
        
        /*
         * BACKUP FEATURES SECTION
         * 
         */
        case "720":
            // Main Backup Functions
            require_once('application/backup/home.php');
            break;
        
        /*
         * MODULE CONTROL
         */
        case "800":
            // Module Control Function
            require_once('application/core/modulecontrol.php');
            break;
        
        /*
         * WEB SERVICE FEATURES
         * 
         */
        case "900":
            // Main web service function
            require_once('application/webservice/home.php');
            break;
        
        case "909":
            // Settings page
            require_once('application/admin/settings.php');
            break;
        
        /*
         * USER CONTROL MECHANISM
         */
        case "950":
            // View all users
            require_once('application/admin/users.php');
            break;
        
        /*
         * SEARCH FEATURES SECTION
         */
        case "999100":
            // Search System
            require_once('application/search/home.php');
            break;
        
        /*
         * FIREWALL FEATURES SECTION
         */
        case "999900":
            // Firewall System
            require_once('application/admin/firewall.php');
            break;
        /*
         * INTRUSION DETECTION FEATURES SECTION
         */
        case "999901":
            // Firewall System
            require_once('application/admin/ids.php');
            break;
        
        /*
         * HELP FEATURES SECTION
         */
        case "999991":
            // Home
            require_once('application/help/home.php');
            break;
        
        
        /*
         * CORE AUTH / LAUNCH FEATURES SECTION
         * (Including default options)
         */
        case "100":
            // Authenticate 
            require_once('application/core/login.php');
            break;
        case "110":
            // Main Screen
            require_once('application/core/controlpanel.php');
            break;
        case "111":
            // Software Info Screen
            require_once('application/admin/softwareinfo.php');
            break;
        case "999999":
            // Log out
            require_once('application/core/logout.php');
            break;
        default:
            if($authcheck == 'auth'){
                require_once('application/core/controlpanel.php');
            }
            else
            {
                require_once('application/core/login.php');
            }
    }
    
    ?>
    </div>
