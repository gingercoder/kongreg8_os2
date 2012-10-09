<?php

/*
 * Web Service class - to turn services on and off and create API keys
 */

class webservice extends kongreg8app{
    
    
    /*
     * Create an API key and log it against their user account
     * 
     */
    public function createAPIkey($userid)
    {
        $userid = db::escapechars($userid);
        $apikeyraw = "kongreg8".$userID.date('YmdHis').$this->version();
        $apikey = md5($apikeyraw);
        
        $sql = "UPDATE users SET apikey='$apikey' WHERE userID='$userid' LIMIT 1";
        $result = db::execute($sql);
        if($result){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    
    /*
     * Toggle the web service on or off
     * 
     */
    public function toggleWebservice($state='')
    {
        
        if(is_null($state)){
            $sql = "SELECT * FROM settings WHERE settingName='webservice'";
            $result = db::returnrow($sql);
            if($result['settingValue'] == 1){
                $sql = "UPDATE settings SET settingValue='0' WHERE settingName='webservice' LIMIT 1";
                $result = db::execute($sql);
            }
            else{
                $sql = "UPDATE settings SET settingValue='1' WHERE settingName='webservice' LIMIT 1";
                $result = db::execute($sql);
            }
        }
        else{
            $sql = "UPDATE settings SET settingValue='".db::escapechars($state)."' WHERE settingName='webservice' LIMIT 1";
            $result = db::execute($sql);
        }
        return;
    }
    
    /*
     * Check the web service state
     */
    public function checkAPIstate(){
        
        $sql = "SELECT * FROM settings WHERE settingName='webservice'";
        $result = db::returnrow($sql);
        return $result['settingValue'];
    }
    
    
    /*
     * Function to revoke the API key as required
     * (no key = no auth on webservice api)
     */
    public function revokeKey($userid)
    {
        $userID = db::escapechars($userid);
                
        $sql = "UPDATE users SET apikey='' WHERE userID='$userID' LIMIT 1";
        $result = db::execute($sql);
        if($result){
            return true;
        }
        else{
            return false;
        }
    }
    
    
    
    /*
     * Function to show all services users
     * (those users with API keys)
     * 
     */
    public function showServiceUsers($userid='')
    {
        $userid = db::escapechars($userid);
        
        $sql = "SELECT * FROM users WHERE apikey <>'' ORDER BY surname ASC, firstname ASC";
        $result = db::returnallrows($sql);
        if(db::getnumrows($sql)>0){
            print "<table class=\"firewalltable\"><tr><th>Surname</th><th>Firstname</th><th>Username</th><th>API Key</th><th>Action</th></tr>";
            foreach($result as $user){
                if($userid == $user['userID']){
                    print "<tr class=\"selected\">";
                }
                else{
                    print "<tr>";
                }
                
                print "<td>" . $user['surname'] . "</td>";
                print "<td>" . $user['firstname'] . "</td>";
                print "<td>" . $user['username'] . "</td>";
                print "<td>" . $user['apikey'] . "</td>";
                print "<td>
                        <a href=\"index.php?mid=900&u=" . $user['userID'] . "&action=revoke\">Revoke Key</a> / 
                        <a href=\"index.php?mid=900&u=" . $user['userID'] . "&action=mailkey\">Email Key</a>
                        </td>";
                
                print "</tr>";
            }
            print "</table>";

        }
        else{
            print "<p><strong>There are currently no users provided with an API Key</strong></p>";
        }
        return;
    }
    
    
    /*
     * Createa a select dropdown with non-key users
     * 
     */
    public function getNonKeyUserSelect()
    {
        $returnval = "";
        $sql = "SELECT * FROM users WHERE ((apikey ='') || (apikey IS NULL)) ORDER BY username ASC";
        $result = db::returnallrows($sql);
        if(db::getnumrows($sql)>0){
            foreach($result as $user){
                
                $returnval .= "<option value=\"" . $user['userID'] . "\">" . $user['username'] . "</option>\r\n";
               
            }
            

        }
        return $returnval;
    }
    
    
    
    /*
     * Authenticate a user
     * 
     */
    public function authenticate($username, $apikey)
    {
        
        $username = db::escapechars($username);
        $apikey = db::escapechars($apikey);
        if(($username == "")||($apikey == "")){
            return false;
        }
        $userid = $this->usernametoid($username);
        if($userid !=""){
            $sql = "SELECT * FROM users WHERE userID='".$userid."'";
            $result = db::returnrow($sql);
            if(($result['apikey'] == $apikey)&&($result['username'] == $username)){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    
    
    /*
     * Mail the API key to the user
     * Provides the key easily rather than copy&paste
     * 
     */
    public function emailKey($userid)
    {
        $userid = db::escapechars($userid);
        $sql = "SELECT * FROM users WHERE userID='".$userid."'";
        $result = db::returnrow($sql);
        
        if(($result['apikey'] != '')&&($result['emailaddress'] !='')){
            // Send the email to the user
            $message = "*******************************************\r\n";
            $message .= $result['firstname'].", you have been assigned an API Key for the Kongreg8 web service.\r\nYour unique key is:\r\n".$result['apikey']."\r\n";
            $message .= "You will need to use this along with your username to access the Kongreg8 API for your church.\r\n";
            $message .= "*******************************************\r\n";
            
            $sql2 = "SELECT * FROM settings WHERE settingName='mailRoot'";
            $setting = db::returnrow($sql2);
            
            $fromemailsetting = "From: ".$setting['settingValue'];
            $replyemailsetting = "Reply-To: noreply@kongreg8.db";
            $headers =  $fromemailsetting . "\r\n" . $replyemailsetting  . "\r\n" . 'X-Mailer: PHP/' . phpversion();
		
            $dothemail = mail($result['emailaddress'], 'Kongreg8 API Key', $message, $headers);
            
            if($dothemail){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
        
    }
    
    
    
    
    
    /*
     * Search member information based on query pattern
     * 
     */
    public function searchMember($searchterm, $modifier)
    {
        // Cleanse the incomming info
        $searchterm = db::escapechars($searchterm);
        $modifier = db::escapechars($modifier);
        
        // Header XML info
        $headoutput = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\r\n";
        $headoutput .= "<kongreg8db version=\"2.0.1\">\r\n";
        print $headoutput;
        
        // Grab each item of data from the members table based on the search criteria
        $sql = "SELECT memberID, prefix, firstname, middlename, surname, email, homephone, mobilephone, address1, address2, address3, postcode, 
                country, workphonenumber, workfaxnumber, workemail, workwebsite, memberStatus 
                FROM churchmembers 
                WHERE
                " . $modifier . " LIKE '%" . $searchterm . "%'
                ORDER BY surname ASC, 
                firstname ASC, 
                middlename ASC";
        $result = db::returnallrows($sql);
        
        foreach($result as $row){
            // Get the row data and output
            $nextline = "";
            $nextline .= "<member id='" . $row['memberID'] . "'>\r\n";
            $nextline .= "<Title>" . $row['prefix'] . "</Title> 
                          <Firstname>" . $row['firstname'] . "</Firstname>
                          <Middlename>" . $row['middlename'] . "</Middlename>
                          <Surname>" . $row['surname'] . "</Surname>
                          <Email>" . $row['email'] . "</Email>
                          <Phone>" . $row['homephone'] . "</Phone>
                          <Mobile>" . $row['mobilephone'] . "</Mobile>
                          <Address1>" . $row['address1'] . "</Address1>
                          <Address2>" . $row['address2'] . "</Address2>
                          <Address3>" . $row['address3'] . "</Address3>
                          <Postcode>" . $row['postcode'] . "</Postcode>
                          <Country>" . $row['country'] . "</Country>
                          <WorkPhone>" . $row['workphonenumber'] . "</WorkPhone>
                          <WorkEmail>" . $row['workemail'] . "</WorkEmail>
                          <WorkFax>" . $row['workfaxnumber'] . "</WorkFax>
                          <WorkWebsite>" . $row['workwebsite'] . "</WorkWebsite>
                          <MemberType>" . $row['memberStatus'] . "</MemberType>";
            $nextline .= "</member>\r\n";
            print $nextline;
        }
        // Close the XML feed
        print "</kongreg8db>\r\n";
    }
    
    
    /*
     * Search Group information based on query pattern
     * 
     */
    public function searchGroup($searchterm, $modifier)
    {
        // Cleanse the incomming info
        $searchterm = db::escapechars($searchterm);
        $modifier = db::escapechars($modifier);
        
        // Header XML info
        $headoutput = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\r\n";
        $headoutput .= "<kongreg8db version=\"2.0.1\">\r\n";
        print $headoutput;
        
        // Grab each item of data from the members table based on the search criteria
        $sql = "SELECT churchmembers.memberID, churchmembers.prefix, churchmembers.firstname, churchmembers.middlename, churchmembers.surname, 
                churchmembers.email, churchmembers.homephone, churchmembers.mobilephone, churchmembers.address1, churchmembers.address2, 
                churchmembers.address3, churchmembers.postcode, churchmembers.country, churchmembers.workphonenumber, churchmembers.workfaxnumber, 
                churchmembers.workemail, churchmembers.workwebsite, churchmembers.memberStatus, 
                groups.groupname, groups.groupdescription, groupmembers.groupID
                FROM (churchmembers 
                RIGHT JOIN groupmembers ON groupmembers.memberID = churchmembers.memberID 
                RIGHT JOIN groups ON groups.groupID = groupmembers.groupID ) 
                WHERE
                " . $modifier . " LIKE '%" . $searchterm . "%'
                ORDER BY surname ASC, 
                firstname ASC, 
                middlename ASC";
        $result = db::returnallrows($sql);
        
        foreach($result as $row){
            // Get the row data and output
            $nextline = "";
            $nextline .= "<member id='" . $row['memberID'] . "'>\r\n";
            $nextline .= "<Title>" . $row['prefix'] . "</Title> 
                          <Firstname>" . $row['firstname'] . "</Firstname>
                          <Middlename>" . $row['middlename'] . "</Middlename>
                          <Surname>" . $row['surname'] . "</Surname>
                          <Email>" . $row['email'] . "</Email>
                          <Phone>" . $row['homephone'] . "</Phone>
                          <Mobile>" . $row['mobilephone'] . "</Mobile>
                          <Address1>" . $row['address1'] . "</Address1>
                          <Address2>" . $row['address2'] . "</Address2>
                          <Address3>" . $row['address3'] . "</Address3>
                          <Postcode>" . $row['postcode'] . "</Postcode>
                          <Country>" . $row['country'] . "</Country>
                          <WorkPhone>" . $row['workphonenumber'] . "</WorkPhone>
                          <WorkEmail>" . $row['workemail'] . "</WorkEmail>
                          <WorkFax>" . $row['workfaxnumber'] . "</WorkFax>
                          <WorkWebsite>" . $row['workwebsite'] . "</WorkWebsite>
                          <MemberType>" . $row['memberStatus'] . "</MemberType>
                          <GroupName>" . $row['memberStatus'] . "</GroupName>
                          <GroupDescription>" . $row['memberStatus'] . "</GroupDescription>";
            $nextline .= "</member>\r\n";
            print $nextline;
        }
        // Close the XML feed
        print "</kongreg8db>\r\n";
        
    }
    

    
}

?>
