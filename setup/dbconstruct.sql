-- Kongreg8
-- version 2.0.1
-- http://www.pizzaboxsoftware.co.uk



SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `kongreg8`
--

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE IF NOT EXISTS `campus` (
  `campusid` mediumint(11) NOT NULL AUTO_INCREMENT,
  `campusName` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `campusDescription` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `address1` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `address2` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `postcode` varchar(7) COLLATE latin1_general_ci NOT NULL,
  `telephoneNumber` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `emailAddress` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `campusURL` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateModified` datetime NOT NULL,
  PRIMARY KEY (`campusid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Church Campus Information' AUTO_INCREMENT=2 ;


INSERT INTO `campus` (`campusid`, `campusName`, `campusDescription`, `address1`, `address2`, `postcode`, `telephoneNumber`, `emailAddress`, `campusURL`, `dateCreated`, `dateModified`) VALUES
(1, 'Main', 'Main Campus', '', '', '', '', '', '', '2012-10-10 15:00:00', '2012-10-10 15:00:00');


-- --------------------------------------------------------

--
-- Table structure for table `churchmembers`
--

CREATE TABLE IF NOT EXISTS `churchmembers` (
  `memberID` bigint(20) NOT NULL AUTO_INCREMENT,
  `prefix` text,
  `surname` text,
  `firstname` text,
  `middlename` text,
  `gender` text,
  `dateofbirth` date DEFAULT NULL,
  `maritalstatus` text,
  `firstvisit` date DEFAULT NULL,
  `contactmethod` text,
  `homephone` text,
  `mobilephone` text,
  `email` text,
  `address1` text,
  `address2` text,
  `address3` text,
  `address4` text,
  `postcode` text,
  `country` text,
  `source` text,
  `commitmentdate` date DEFAULT NULL,
  `crbcheck` char(3) DEFAULT NULL,
  `crbcheckdate` date DEFAULT NULL,
  `mainLanguage` varchar(30) DEFAULT NULL,
  `countryoforigin` varchar(80) DEFAULT NULL,
  `medicalInfo` text,
  `memberStatus` varchar(10) DEFAULT NULL,
  `emailoptin` char(3) DEFAULT NULL,
  `employer` varchar(100) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `workphonenumber` varchar(30) DEFAULT NULL,
  `workfaxnumber` varchar(30) DEFAULT NULL,
  `workemail` varchar(100) DEFAULT NULL,
  `workwebsite` varchar(100) DEFAULT NULL,
  `lastupdatedate` date DEFAULT NULL,
  `lastupdatetime` time DEFAULT NULL,
  `giftaid` varchar(9) DEFAULT NULL,
  `campusid` int(11) NOT NULL,
  PRIMARY KEY (`memberID`),
  KEY `campusid` (`campusid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Church Member Information' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `emailtemp`
--

CREATE TABLE IF NOT EXISTS `emailtemp` (
  `mailID` bigint(20) NOT NULL AUTO_INCREMENT,
  `thesubject` text,
  `thebody` text,
  `sendto` text,
  `mailstatus` varchar(20) DEFAULT NULL,
  `userID` bigint(20) NOT NULL,
  `datecreated` datetime NOT NULL,
  PRIMARY KEY (`mailID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Temporary Email Storage Table' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `emailtemplate`
--

CREATE TABLE IF NOT EXISTS `emailtemplate` (
  `templateID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` bigint(20) NOT NULL,
  `groupID` bigint(20) NOT NULL,
  `campusid` bigint(20) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `mainmessage` text NOT NULL,
  `datecreated` datetime NOT NULL,
  PRIMARY KEY (`templateID`),
  KEY `userID` (`userID`),
  KEY `groupID` (`groupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Email Templates for the Group Messaging System' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `familyconstruct`
--

CREATE TABLE IF NOT EXISTS `familyconstruct` (
  `relationshipID` bigint(20) NOT NULL AUTO_INCREMENT,
  `fromID` bigint(20) DEFAULT NULL,
  `toID` bigint(20) DEFAULT NULL,
  `relationship` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`relationshipID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Famiy Constructor table' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groupmembers`
--

CREATE TABLE IF NOT EXISTS `groupmembers` (
  `groupID` bigint(20) DEFAULT NULL,
  `memberID` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Members of the groups';

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `groupID` bigint(20) NOT NULL AUTO_INCREMENT,
  `groupname` text,
  `groupdescription` text,
  `groupleader` bigint(20) DEFAULT NULL,
  `campusid` int(11) NOT NULL,
  PRIMARY KEY (`groupID`),
  KEY `groupleader` (`groupleader`),
  KEY `campusid` (`campusid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Groups or Teams' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `helpsystem`
--

CREATE TABLE IF NOT EXISTS `helpsystem` (
  `helpID` int(11) NOT NULL AUTO_INCREMENT,
  `helpTitle` varchar(180) COLLATE latin1_general_ci NOT NULL,
  `helpContent` text COLLATE latin1_general_ci NOT NULL,
  `helpArea` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `sectionID` int(5) NOT NULL,
  PRIMARY KEY (`helpID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Help System Core System Information' AUTO_INCREMENT=26 ;

-- --------------------------------------------------------
--
-- Dumping data for table `helpsystem`
--

INSERT INTO `helpsystem` (`helpID`, `helpTitle`, `helpContent`, `helpArea`, `sectionID`) VALUES
(1, 'Adding a Member', 'To add a member to the system, enter the information into the boxes provided. You should at least insert the: first name; surname; member status and campus for the new member. Once you have entered your information click on the SAVE DETAILS button at the right of your screen to store the details in Kongreg8.', 'members', 1),
(2, 'Reminders Overview', 'The reminder system is your own personal time-based notepad. It allows you to create a message that will remind you on a specific date. Think of it as a mini diary that will remind you of events or meetings whenever you sign in to Kongreg8. You can toggle the reminder pane visibility with the on/off switches - you will still see a reminder on screen for the next ten reminders you have stored. Reminders will disappear once you pass the date of your item. Use the Add Reminder pane to create a new entry in the system. Select your date and time from the drop-down boxes, give your reminder a title and a message and click the CREATE button to save your new item in the system.', 'reminders', 1),
(3, 'Firewall Overview', 'The firewall system controls access to your Kongreg8 system. It allows or denies access to the sign-in facility based on an IP address or a range of IP addresses. By default, if you do not specify IP addresses in the firewall rules table, you will be denied access to the system. This maintains maximum security at all times. To turn the firewall on and off click on the ON/OFF button on the right of your screen. Please read the full firewall documentation if you are not sure on how to best utilise this feature as it is possible to lock yourself out of the system entirely. This will require a database modification to cure.', 'firewall', 1),
(4, 'About this System', 'Kongreg8 OS2 is the latest version of the Kongreg8 church member database system. It was created in 2007 by Rick Trotter and has since been modified and completely redeveloped to provide the best platform for church administrators and developers to use. At the heart is a desire to allow administrators the ability to get on with what they''re good at without worrying about paperwork and being chained to the office filing cabinet. The system is licensed under GNU GPL v3. A copy of this license should have been included with your core system.<br/>Kongreg8 version: 2.0.1<br/>Build: Primary<br/>Developers: Rick Trotter<br/>Support: rick@pizzaboxsoftware.co.uk<br/><br/>This release is the BETA release of the new framework. Whilst every effort has been made to provide this software free from errors it is still in development and does not include fully responsive interface design as yet. Additional functionality and features will appear in the subsequent releases.', 'about', 1),
(5, 'Contributors', 'Contributors in this version:<br/>Rick Trotter', 'about', 2),
(6, 'License', 'Kongreg8 - Church Member Database System\r\n    <br/>Copyright (C) 2012  Rick Trotter\r\n<br/>\r\n    This program is free software: you can redistribute it and/or modify\r\n    it under the terms of the GNU General Public License as published by\r\n    the Free Software Foundation, either version 3 of the License, or\r\n    any later version.\r\n<br/>\r\n    This program is distributed in the hope that it will be useful,\r\n    but WITHOUT ANY WARRANTY; without even the implied warranty of\r\n    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the\r\n    GNU General Public License for more details.\r\n<br/>\r\n    You should have received a copy of the GNU General Public License\r\n    along with this program.  If not, see <a href="http://www.gnu.org/licenses/">&lt;http://www.gnu.org/licenses/&gt;</a>.', 'about', 3),
(7, 'Campus Overview', 'Kongreg8 provides the ability to store members against different campuses for churches that operate multiple locations. An example of this would be a primary (main) campus and off-shoot churches that are tied back to the same main campus but operate independently. Administrators can be ''tagged'' to a campus so that their results are tailored specifically to that campus. In effect, Kongreg8 allows multiple instances of itself to operate seamlessly or as a whole church. You will need to create at least one campus that can be used to tag members to.', 'campus', 1),
(8, 'Developers', 'The Kongreg8 framework has been built to allow the development of new features and redevelopment of the system to meet the requirements of the church. If you wish to undertake any module development or redevelopment work there is a GitHub project for Kongreg8_OS2 to pull the latest source files. <br/>Kongreg8 is licensed under GNU GPL v3 so that you can provide the software to others once it has been reworked. You must include information of the primary authors in accordance with the GNU GPL and links to the main source thread. <br/>If you have a great module please feel free to contact the main development team to look to include this in the main development thread for the next release.<br/>Kongreg8 includes many comments within the codebase to make development easier - a developer''s manual will become available through lulu.com as the system matures.', 'about', 4),
(9, 'My Reports Overview', 'The My Reports system allows you to construct your own simple SQL statements based on a generic template mechanism. Construct a report on the live data for things you want to see, then review this live report any time you choose. If you are unsure on the column names please consult the developer guide / advanced user guide for more information.', 'myreports', 1),
(10, 'Reports System', '<p>\r\nThe main reports system allows access to pre-defined reports that come packaged with your installation and any reports you have generated in the My Reports section.\r\n</p>\r\n<p>\r\nThe reports system is designed to provide information in print-ready format for creating paper output for auditing.\r\n</p>', 'Reports', 1),
(11, 'Searching for members', 'Searching for members allows access to information as well as edit and removal procedures. Enter any relevant information and click on the search button. You do not have to fill all of the information in, just as much as you know or want to search on. Partial field input is acceptable.', 'members', 6),
(12, 'Adding Entries', 'To add a new entry to the firewall system, input your IP addresses into the boxes provided at the bottom of the firewall rule table. Ensure you have selected the correct ALLOW or DENY option , whether the entry is ACTIVE or INACTIVE and click on the Add Rule button. This will add your new entry to the firewall system and make it active.', 'Firewall', 2),
(13, 'Turning the firewall on/off', 'To turn the firewall on or off, click on the red switch icon on the top right of the Firewall rules screen. This will toggle the state on or off and reflect the change in the image displayed. It is important if you turn on the firewall that your current IP is set to ALLOW otherwise you will be locked out of the system and you will either have to use an allowed IP address to change the configuration or modify the database to recover from a locked system.', 'Firewall', 3),
(14, 'Recovering from a locked system', 'If you manage to lock the system and cannot gain entry through the user accounts the only way to gain access to the system is through modification of the Kongreg8 database. Log in to your MySQL system via the command line or via a phpMyAdmin interface and navigate to your database. Select the settings table and modify the firewall option. Set the value to 0. You should now be able to access the Kongreg8 system through the web interface again now.', 'Firewall', 4),
(15, 'Editing a member', 'To edit a member, search for the member using the Find Member utility or the top search. Click on the Edit link and a form similar to the Add Member form will appear. The stored information for your member will load into this form - make any modifications you wish to (pre-saved values are denoted by brackets) and then click on the Save button to store your new information for the member.', 'members', 2),
(16, 'Group Add / Edit / Removal', 'To add a group enter the information for your new group into the box on the right of the group overview screen. For the leader information, enter as you would with the search boxes - firstname, (optional) middle name, surname - or partial items thereof - separated by spaces. You will be provided with a confirmation link when you click on the Add button. To edit an existing group, click on the Edit link next to the item in the table below. To Remove a group, click on the link next to the item in the table below. Confirm your action with the I AGREE link.', 'Groups', 0),
(17, 'Editing a Reminder', 'Once you have selected your reminder from the main screen, modify the information to correct any faults or updates in your previous entry. Click on the Save button once you have finished modifying your information to store your revised data. If you wish to cancel the process simply navigate away from the page.', 'reminders', 2),
(18, 'My Messages module', 'The messaging system is for communication between administrators on the Kongreg8 system. Clicking on your My Messages icon results in a view of your entire inbox. To view a message (and all of it''s associated responses) click on the VIEW link next to your message item. Messages are marked as new, read or reply depending on their state. To create a new message to an administrator, enter your information into the form on the message inbox screen. Remember to select the administrator you wish to send the message to from the drop-down box.', 'messages', 0),
(19, 'Changing your password', 'To change your password, enter your old password and then your new password (repeating your new password in the third box) and click on CHANGE PASSWORD. This will reset your current password to the new password you typed in. You will not have to log out for this to take effect, the system modifies your current session information so that you can keep working.', 'password', 0),
(20, 'Authentication Stats', 'The failed authentication stats provide you with feedback on how the system is coping with failed or blocked access to the system.', 'authstats', 0),
(21, 'Contacting a group', 'To send a message to a group, first create your template (achieved through the form on the contact group page). Once you have created and stored your template you can simply send the message to the group by clicking on the SEND link next to the message template you have created. If you wish to remove a template, simply click on the REMOVE link next to the item you wish to delete and then confirm the removal with the I AGREE link. When you send a message to all members of a group it may take a while to complete the task (a processing warning will appear while processing).', 'Groups', 5),
(22, 'Modifying group members / leader', 'When displaying the members of a group you have the ability to specify a new leader by clicking on the SET LEADER button next to the member you wish to set as your group leader. To add new members to the group, enter the name of the church member into the box (or partial first / second / surname as with other forms). Click on FIND AND ADD and then confirm which member it is from the list provided.  If you wish to remove a member, click on the REMOVE button and confirm the removal of the member.', 'Groups', 3),
(23, 'Exporting data', 'To use your data from the system in a format you can import into a spreadsheet, the export function provides the ability to output CSV (Comma Separated Value) or XML (Extensible Markup Language) format. Select the area you wish to export and what format you require from the form on the left of the screen. It is most likely that you will want CSV format. Click on Export to generate your file. This will then compile the information in the correct format and create a link on the right-hand-side of the screen for you to download now or later.', 'export', 0),
(24, 'Running a Backup', 'To create a full SQL backup of your system (all tables and content) click on the Run Backup button on the right hand side of the screen. Any previous backups operated will display on the left hand side of the screen. Click on the icon of your backup to download it to your machine. To clear any previous backups from the system, click on the REMOVE FILES link on the right hand side of the screen.', 'backup', 0),
(25, 'Web Service Overview', 'The Web Services built into Kongreg8 allow you to build your own applications and connect your data to them. To use the web services you must turn on your web service API and then assign a key to your user. Using your username and the API key you can access the Kongreg8 web service. If you need to lock access to the system you can either revoke a key (and re-instate later) or turn the service off completely.', 'webservice', 0);



--
-- Table structure for table `kerrorlog`
--

CREATE TABLE IF NOT EXISTS `kerrorlog` (
  `errorID` bigint(20) NOT NULL AUTO_INCREMENT,
  `logTime` time DEFAULT NULL,
  `logDate` date DEFAULT NULL,
  `logType` varchar(100) DEFAULT NULL,
  `logValue` text,
  `logArea` varchar(50) DEFAULT NULL,
  UNIQUE KEY `errorID` (`errorID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='System Error Logs' AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `kfirewall`
--

CREATE TABLE IF NOT EXISTS `kfirewall` (
  `firewallid` mediumint(11) NOT NULL AUTO_INCREMENT,
  `ruleTitle` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ipaddress` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `endaddress` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `userID` mediumint(20) DEFAULT NULL,
  `mode` int(1) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `datecreated` datetime DEFAULT NULL,
  `datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`firewallid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Firewall Rules for Kongreg8 authentication and access' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kidschurchgroupmembers`
--

CREATE TABLE IF NOT EXISTS `kidschurchgroupmembers` (
  `groupID` bigint(20) DEFAULT NULL,
  `memberID` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Members of kids church groups';

-- --------------------------------------------------------

--
-- Table structure for table `kidschurchgroups`
--

CREATE TABLE IF NOT EXISTS `kidschurchgroups` (
  `groupID` bigint(20) NOT NULL AUTO_INCREMENT,
  `groupname` text,
  `groupdescription` text,
  `groupleader` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`groupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Kids Church Groups' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kidschurchplans`
--

CREATE TABLE IF NOT EXISTS `kidschurchplans` (
  `planID` bigint(20) NOT NULL AUTO_INCREMENT,
  `activityTitle` varchar(100) DEFAULT NULL,
  `activityTheme` text,
  `activities` text,
  `activityDate` date DEFAULT NULL,
  `materialsNeeded` text,
  `consentRequired` char(3) DEFAULT NULL,
  PRIMARY KEY (`planID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Kids Church Activities plan' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kidschurchregister`
--

CREATE TABLE IF NOT EXISTS `kidschurchregister` (
  `registerid` int(11) NOT NULL AUTO_INCREMENT,
  `childid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `kidschurchgroupid` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `timein` datetime NOT NULL,
  `timeout` datetime NOT NULL,
  PRIMARY KEY (`registerid`),
  KEY `childid` (`childid`,`userid`,`kidschurchgroupid`,`parentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Kids church register table for signing children in and out o' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kidschurchresources`
--

CREATE TABLE IF NOT EXISTS `kidschurchresources` (
  `resourceID` int(11) NOT NULL AUTO_INCREMENT,
  `resourceName` varchar(50) DEFAULT NULL,
  `resourceDescription` text,
  `resourceType` varchar(100) DEFAULT NULL,
  `resourceQuantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`resourceID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Kids Church Resources' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `klog`
--

CREATE TABLE IF NOT EXISTS `klog` (
  `logID` bigint(20) NOT NULL AUTO_INCREMENT,
  `logTime` time DEFAULT NULL,
  `logDate` date DEFAULT NULL,
  `logType` varchar(100) DEFAULT NULL,
  `logValue` text,
  `logArea` varchar(50) DEFAULT NULL,
  UNIQUE KEY `logID` (`logID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='System Logs' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kmodules`
--

CREATE TABLE IF NOT EXISTS `kmodules` (
  `moduleName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `moduleVersion` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `moduleAuthor` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `userlevel` int(1) NOT NULL,
  KEY `moduleName` (`moduleName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Module Information';

-- --------------------------------------------------------

--
-- Table structure for table `memberregister`
--

CREATE TABLE IF NOT EXISTS `memberregister` (
  `registerdate` date DEFAULT NULL,
  `memberfigures` bigint(20) DEFAULT NULL,
  `males` bigint(20) DEFAULT NULL,
  `females` bigint(20) DEFAULT NULL,
  `girls` bigint(20) DEFAULT NULL,
  `boys` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Weekly register of members in meeting';

-- --------------------------------------------------------

--
-- Table structure for table `messaging`
--

CREATE TABLE IF NOT EXISTS `messaging` (
  `messageID` bigint(20) NOT NULL AUTO_INCREMENT,
  `datelogged` datetime DEFAULT NULL,
  `userID` bigint(20) DEFAULT NULL,
  `messageto` bigint(20) DEFAULT NULL,
  `subject` text,
  `mainmessage` text,
  `messageStatus` varchar(5) DEFAULT NULL,
  `inReplyTo` int(20) NOT NULL,
  PRIMARY KEY (`messageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Messaging System' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myreminders`
--

CREATE TABLE IF NOT EXISTS `myreminders` (
  `reminderID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(20) NOT NULL,
  `reminderDate` date NOT NULL,
  `reminderTime` time NOT NULL,
  `reminderTitle` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `reminderContent` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `reminderAlert` tinyint(1) NOT NULL,
  PRIMARY KEY (`reminderID`),
  KEY `userID` (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Reminders system' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myreports`
--

CREATE TABLE IF NOT EXISTS `myreports` (
  `reportid` mediumint(11) NOT NULL AUTO_INCREMENT,
  `userID` int(20) NOT NULL,
  `reportName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `reportDescription` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `selectFrom` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `whereA` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `valueA` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `whereB` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `valueB` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `compareA` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `compareB` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `compareBoth` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`reportid`),
  KEY `reportName` (`reportName`),
  KEY `userID` (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='My Reports system user defined reports' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `offerings`
--

CREATE TABLE IF NOT EXISTS `offerings` (
  `offeringdate` date DEFAULT NULL,
  `offeringfigures` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Weekly Offering Figures';

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `settingName` varchar(30) DEFAULT NULL,
  `settingValue` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Systemwide settings';

-- --------------------------------------------------------

INSERT INTO `settings` (`settingName`, `settingValue`) VALUES
('scrTitle', 'Kongreg8'),
('welcomeGreeting', 'Welcome online to Kongreg8 (church databases made easy).'),
('mailRoot', 'noreply@pizzaboxsoftware.co.uk'),
('commsEmail', 'noreply@pizzaboxsoftware.co.uk'),
('emailFooter', 'If you wish to be removed from email updates from church please contact us using this email address'),
('licensedto', 'PizzaBoxSoftware'),
('firewall', '0'),
('systemVersion', '2.0.1'),
('webservice', '0');

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` text,
  `surname` text,
  `username` text,
  `password` text,
  `userlevel` int(11) DEFAULT NULL,
  `emailaddress` varchar(100) DEFAULT NULL,
  `campus` varchar(11) NOT NULL,
  `apikey` varchar(32) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='System Users' AUTO_INCREMENT=1 ;
