<?php

/*
 * Groups control class
 */


class kidschurch extends kongreg8app{
    
    
    /*
     * View all kidschurch groups in the system for the main home screen
     * 
     */
    public function viewGroups($groupid='')
    {
        $groupid = db::escapechars($groupid);
        $sql = "SELECT * FROM kidschurchgroups ORDER BY groupname ASC";
        
        $result = db::returnallrows($sql);
        
        
        $groupTable = "";
        if(!empty($result)){
            $groupTable .= "<table class=\"memberTable\">
                    <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Leader</th>
                    <th>Action</th>
                    </tr>";
            foreach($result as $groupitem){
                if(($groupitem['groupID'] == $groupid)&&(!empty($groupid))){
                    $groupTable .= "<tr class=\"highlight\">";
                }
                else{
                    $groupTable .= "<tr>";
                }
                $groupTable .= "
                    <td>".$groupitem['groupname']."</td>
                    <td>".$groupitem['groupdescription']."</td>
                    <td>".$this->memberidtoname($groupitem['groupleader'])."</td>
                    <td><a href=\"index.php?mid=421&g=".$groupitem['groupID']."\">View</a> /
                        <a href=\"index.php?mid=405&g=".$groupitem['groupID']."&edit=true\">Edit</a> / 
                    <a href=\"index.php?mid=410&g=".$groupitem['groupID']."&remove=true\">Remove</a> 
                    
                    </td>
                    </tr>";
                
            }
            $groupTable .= "</table>";
        
            return $groupTable;
        }
        else{
            return false;
        }
    }
    
    /*
     * Add a kidschurch group to the system based on the given details
     * from the main home screen
     */
    public function addGroup($groupname, $groupdescription, $groupleader, $campus)
    {
        $sql = "INSERT INTO kidschurchgroups SET
                groupname='".db::escapechars($groupname)."',
                groupdescription='".db::escapechars($groupdescription)."',
                groupleader='".db::escapechars($groupleader)."',
                campusid='".db::escapechars($campus)."'
                ";
        $result = db::execute($sql);
        if($result){
            $lastid = db::getlastid();
            $this->addMemberToGroup($lastID, $groupleader);
            return true;
        }
        else{
            return false;
        }
        
        
    }
    
    /*
     * Edit / Update a kidschurch group that exists in the system and store the new information
     * 
     */
    public function editGroup($groupid, $groupname, $groupdescription, $groupleader, $campus)
    {
        $sql = "UPDATE kidschurchgroups SET 
                groupname='".db::escapechars($groupname)."',
                groupdescription='".db::escapechars($groupdescription)."',
                groupleader='".db::escapechars($groupleader)."',
                campusid='".db::escapechars($campus)."'
                WHERE
                groupID='".db::escapechars($groupid)."'
                ";
        $result = db::execute($sql);
        
        if($result){
            // Log the activity
            $logType = "Insert";
            $logValue = $_SESSION['Kusername']." edited group, ".db::escapechars($groupname);
            $logArea = "Kidschurch";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Store Fail";
            $logValue = $_SESSION['Kusername']." failed editing a group ".db::escapechars($sql);
            $logArea = "Kidschurch";				
            $this->logerror($logType, $logValue, $logArea);
            return "Could not update at this time - please try again";
        }
        
    }
    
    /*
     * Delete a kidschurch group from the system
     * 
     */
    public function groupDelete($groupid)
    {
        $sql = "SELECT groupname FROM kidschurchgroups WHERE groupID='".db::escapechars($groupid)."'";
        $result = db::returnrow($sql);
        $groupname = $result['groupname'];
        
        $sql = "DELETE FROM kidschurchgroups WHERE groupID='".db::escapechars($groupid)."' LIMIT 1";
        $result = db::execute($sql);
        
        if($result){
            // Log the activity
            $logType = "Delete";
            $logValue = $_SESSION['Kusername']." deleted a group, $groupname";
            $logArea = "Kidschurch";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Store Fail";
            $logValue = $_SESSION['Kusername']." failed deleting a group ($groupname) ".db::escapechars($sql);
            $logArea = "Kidschurch";				
            $this->logerror($logType, $logValue, $logArea);
            return false;
        }
    }
    
    /*
     * View a kidschurch group's information when given a group id 
     * 
     */
    public function groupView($groupid)
    {
        if(!empty($groupid)){
            $sql = "SELECT * FROM kidschurchgroups WHERE groupID='".db::escapechars($groupid)."'";
            $result = db::returnrow($sql);

            return $result;
        }
        else{
            return false;
        }
        
        
    }
    
    /*
     * List of leaders to verify from
     * 
     */
    public function verifyGroupLeader($leadername, $groupname, $groupdescription, $campus)
    {
        $leader = db::escapechars($leadername);
        $groupname = db::escapechars($groupname);
        $groupdescription = db::escapechars($groupdescription);
        $campus = db::escapechars($campus);
        
        // Search for the leader and create the search construct from members table
        
        $sql = "SELECT * FROM churchmembers WHERE ";
        
        $splitSearch = split(' ',trim($leader));
        if(count($splitSearch) >= 1){
            $sql .="firstname LIKE '%".$splitSearch[0]."%' ";
                    
            if(count($splitSearch) > 2){      
                $sql .= "AND middlename LIKE '%".$splitSearch[1]."%'
                        AND surname LIKE '%".$splitSearch[2]."%') ";
            }
            if(count($splitSearch) == 2){
                $sql .= " AND surname LIKE '%".$splitSearch[1]."%' ";
            }
                    
        }
        
        $result = db::returnallrows($sql);
        $personlist = "";
        
        // For each member you find, construct a link to select them as member controllers for the group
        foreach($result as $person){
            // Construct the a href entities for the people
            $personlist .= "[ <a href=\"index.php?mid=400&add=true&groupname=$groupname&groupdescription=$groupdescription&campus=$campus&leader=".$person['memberID']."\" 
                title=\"".$person['address1']." ".$person['address2']." ".$person['email']."\" >" 
                    . $person['firstname']." ".$person['middlename']." ". $person['surname']."</a> ] ";
        }
        
        return $personlist;
        
    }
    
    /*
     * Group ID to name function for calls requiring name
     * 
     */
    public function groupIDtoname($groupID)
    {
        $groupID = db::escapechars($groupID);
        $sql = "SELECT groupname FROM kidschurchgroups WHERE groupID='".$groupID."'";
        $result = db::returnrow($sql);
        return $result['groupname'];
        
    }
    
    
    /*
     * Get the list of kidschurch group members
     * 
     * 
     */
    public function viewGroupMembers($groupID, $memberID='')
    {
        $groupID = db::escapechars($groupID);
        $m = db::escapechars($memberID);
        
        $sql = "SELECT * FROM kidschurchgroupmembers JOIN churchmembers ON kidschurchgroupmembers.memberID = churchmembers.memberID WHERE kidschurchgroupmembers.groupID =  '" . $groupID . "'";
        $result = db::returnallrows($sql);
        if(db::getnumrows($sql)>0){
            print "<table class=\"memberTable\"><tr><th>Firstname</th><th>Surname</th><th>Email</th><th>Action</th></tr>";
            
            foreach($result as $groupmember){
                if($groupmember['memberID'] == $m){
                    print "<tr class=\"highlight\">";
                }
                else{
                    print "<tr>";
                }
                print "<td>" . $groupmember['firstname'] . "</td>";
                print "<td>" . $groupmember['surname'] . "</td>";
                print "<td>" . $groupmember['email'] . "</td>";
                print "<td>
                        <a href=\"index.php?mid=421&m=" . $groupmember['memberID'] . "&g=" . $groupID ."&action=remove\" class=\"delbutton\">Remove</a> / 
                        <a href=\"index.php?mid=421&m=" . $groupmember['memberID'] . "&g=" . $groupID ."&action=setleader\" class=\"runbutton\">Set as Leader</a>
                        </td>";
                print "</tr>";
            }
            print "</table>";
            
        }
        else{
            print "<p>No members at the moment</p>";
        }
    }
    
    /*
     * Add members to a kidschurch group
     * 
     */
    public function addMemberToGroup($groupID, $memberID)
    {
        $groupID = db::escapechars($groupID);
        $memberID = db::escapechars($memberID);
        
        $sql = "INSERT INTO kidschurchgroupmembers SET 
                groupID='" . $groupID . "', 
                memberID='" . $memberID . "'
                ";
        $result = db::execute($sql);
        if($result){
            // Log the activity
            $logType = "Insert";
            $logValue = $_SESSION['Kusername']." added a group member to groupID $groupID";
            $logArea = "Kidschurch";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Store Fail";
            $logValue = $_SESSION['Kusername']." failed adding a group member ".db::escapechars($sql);
            $logArea = "KidsChurch";				
            $this->logerror($logType, $logValue, $logArea);
            return false;
        }
        
    }
    
    /*
     * Remove a member from a kidschurch group
     * 
     */
    public function removeMemberFromGroup($groupID, $memberID)
    {
        $groupID = db::escapechars($groupID);
        $memberID = db::escapechars($memberID);
        
        $sql = "DELETE FROM kidschurchgroupmembers 
                WHERE
                groupID='" . $groupID . "'
                AND
                memberID='" . $memberID . "'
                LIMIT 1
                ";
        $result = db::execute($sql);
        if($result){
            // Log the activity
            $logType = "Removal";
            $logValue = $_SESSION['Kusername']." removed a group member from groupID $groupID";
            $logArea = "Kidschurch";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Removal Fail";
            $logValue = $_SESSION['Kusername']." failed removing a group member ".db::escapechars($sql);
            $logArea = "Kidschurch";				
            $this->logerror($logType, $logValue, $logArea);
            return false;
        }
        
    }
    
    /*
     * Find a member to add to the kidschurch group
     * 
     */
    public function findMemberToAdd($searchstring, $groupID)
    {
        $groupperson = db::escapechars($searchstring);
        $groupID = db::escapechars($groupID);
        
        // Search for the leader and create the search construct from members table
        
        $sql = "SELECT * FROM churchmembers WHERE ";
        
        $splitSearch = split(' ',trim($groupperson));
        if(count($splitSearch) >= 1){
            $sql .="firstname LIKE '%".$splitSearch[0]."%'";
                    
            if(count($splitSearch) > 2){      
                $sql .= "AND middlename LIKE '%".$splitSearch[1]."%'
                        AND surname LIKE '%".$splitSearch[2]."%')";
            }
            if(count($splitSearch) == 2){
                $sql .= " AND surname LIKE '%".$splitSearch[1]."%'";
            }
                    
        }
        
        $result = db::returnallrows($sql);
        $personlist = "";
        
        // For each member you find, construct a link to select them as member controllers for the group
        foreach($result as $person){
            // Construct the a href entities for the people
            $personlist .= "[ <a href=\"index.php?mid=421&action=add&g=" . $groupID . "&m=" . $person['memberID'] . "\" 
                title=\"".$person['address1']." ".$person['address2']." ".$person['email']."\" >" 
                    . $person['firstname']." ".$person['middlename']." ". $person['surname']."</a> ] ";
        }
        
        return $personlist;
        
    }
    
    /*
     * Function to change the leader of a kidschurch group to the new value
     * 
     */
    public function changeGroupLeader($groupID, $leaderID)
    {
        $groupID = db::escapechars($groupID);
        $leaderID = db::escapechars($leaderID);
        
        $sql = "UPDATE kidschurchgroups SET groupLeader='".$leaderID."' WHERE groupID='".$groupID."' LIMIT 1";
        $result = db::execute($sql);
        if($result){
            // Log the activity
            $logType = "Modify";
            $logValue = $_SESSION['Kusername']." edited group, ".db::escapechars($groupname);
            $logArea = "Kidschurch";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Modify Fail";
            $logValue = $_SESSION['Kusername']." failed editing a group ".db::escapechars($sql);
            $logArea = "Kidschurch";				
            $this->logerror($logType, $logValue, $logArea);
            return false;
        }
        
    }
    
    /*
     * Function pulls all of the currently stored message templates for the user 
     * 
     */
    public function viewStoredTemplates($username, $tid='')
    {
        // change username to ID
        $userid = $this->usernametoid(db::escapechars($username));
        $tid = $this->usernametoid(db::escapechars($tid));
        // get all the email messages waiting to be sent
        $sql = "SELECT * FROM emailtemplate WHERE userID='".$userid."' ORDER BY datecreated DESC";
        $result = db::returnallrows($sql);
        if(db::getnumrows($sql)>0){
            
            print "<table class=\"memberTable\">";
           
            print "<tr>
                        <th>Date Created</th>
                        <th>Subject</th>
                        <th>Group</th>
                        <th>Action</th>
                    </tr>
                    ";
            foreach($result as $template){
                if($template['templateID'] == $tid){
                    print "<tr class=\"selected\">";
                }
                else{
                    print "<tr>";
                }
                print "<td>" . $template['datecreated'] . "</td>";
                print "<td>" . $template['subject'] . "</td>";
                if($template['groupID'] == 0){
                    print "<td>All Groups</td>";
                }
                else{
                    print "<td>" . $this->groupIDtoname($template['groupID']) . "</td>";
                }
                print "<td><a href=\"index.php?mid=420&action=send&tid=" . $template['templateID'] . "\" class=\"runbutton\">Send</a> / 
                        <a href=\"index.php?mid=420&action=remove&tid=" . $template['templateID'] . "\" class=\"delbutton\">Remove</a>  
                        </td>";
                print "</tr>";

            }
            
            print "</table>";
        }
        else{
            print "<p>No templates stored currently</p>";
        }
        return;
        
    }
    
    
    /*
     * Kidschurch Group Select Dropdown
     * 
     */
    public function groupselectdropdown($campus)
    {
        $campus = db::escapechars($campus);
        if($campus == "all"){
            $sql = "SELECT groupname, groupID FROM kidschurchgroups ORDER BY groupname ASC";
        }
        else{
            $sql = "SELECT groupname, groupID FROM kidschurchgroups WHERE campusid='$campus' ORDER BY groupname ASC";
        }
        $result = db::returnallrows($sql);
        
        $grouplist = "";
        
        foreach($result as $group){
            $grouplist .= "<option value=\"" . $group['groupID'] . "\">" . $group['groupname'] . "</option>";
        }
        
        return $grouplist;
        
    }
    
    
    /*
     * Add an email template to the system
     * 
     */
    public function addEmailTemplate($subject, $message, $group, $campus)
    {
        $subject = db::escapechars($subject);
        $message = db::escapechars($message);
        $group = db::escapechars($group);
        $campus = db::escapechars($campus);
        
        $sql = "INSERT INTO emailtemplate SET
                subject='" . $subject . "',
                mainmessage='" . $message . "',
                groupID='" . $group ."',
                userID='" . db::escapechars($this->usernametoid($_SESSION['Kusername'])) ."',
                campusID='" . $campus ."',
                datecreated = NOW()
                ";
        $result = db::execute($sql);
        if($result){
            // Log the activity
            $logType = "Insert";
            $logValue = $_SESSION['Kusername']." created a new email template , $subject";
            $logArea = "Kidschurch";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Store Fail";
            $logValue = $_SESSION['Kusername']." failed creating a new email template ".db::escapechars($sql);
            $logArea = "Kidschurch";				
            $this->logerror($logType, $logValue, $logArea);
            return false;
        }
        
    }
    
    /*
     * Function to send all of the email campaign to the members
     * using the templates generated by the user
     * TODO: COMPLETE THIS FUNCTION TODO: COMPLETE THIS FUNCTION TODO: COMPLETE THIS FUNCTION TODO: COMPLETE THIS FUNCTION TODO: COMPLETE THIS FUNCTION 
     */
    public function sendEmailCampaign($templateID)
    {
        // Get the template information of what is to be sent and who to
        $templateID = db::escapechars($templateID);
        $sql = "SELECT * FROM emailtemplate WHERE templateID = '" . $templateID ."'";
        $result = returnrow($sql);
        $subject = $result['subject'];
        $mainmessage = $result['mainmessage'];
        
        $groupID = $result['groupID'];
        // get the information on who is in a group
        
        if($groupID == 0){
            // Sending to EVERY group, make sure you don't send duplicate copies to members tagged to different groups
            $sql = "SELECT * FROM (kidschurchgroupmembers RIGHT JOIN churchmembers on kidschurchgroupmembers.memberID = churchmembers.memberID) GROUP BY kidschurchgroupmembers.memberID";
        }
        else{
            // Sending to ONE group, 
            $sql = "SELECT * FROM (kidschurchgroupmembers RIGHT JOIN churchmembers on kidschurchgroupmembers.memberID = churchmembers.memberID) WHERE kidschurchgroupmembers.groupID='".$groupID."'";
        }
        $result = db::returnallrows($sql);
        // For each member we need to send an email to
        foreach($result as $member){
            // Craft the email text
            
            $mailmessage = $subject."\r'n".$mainmessage;
            // Send the email
            
            $sendmail = mail($to, $subject, $mailmessage, $headers);
            if($sendmail){
                $sql = "UPDATE emailtemp WHERE mailID";
            }

            
        }
        return;
        
    }
    
    
    
    /*
     * View Resource List
     */
    public function viewResources($resourceid='')
    {
        $resourceid = db::escapechars($resourceid);
        
        $sql = "SELECT * FROM kidschurchresources ORDER BY resourceName ASC";
        $resources = db::returnallrows($sql);
        if(count($resources) > 0){
            $resourceOutput = "<table class=\"memberTable\"><tr><th>ID</th><th>Name</th><th>Description</th><th>Type</th><th>Quantity</th><th>Task</th></tr>";
            foreach($resources as $resource){
                if($resource['resourceID'] == $resourceid){
                    $resourceOutput .= "<tr class=\"highlight\">";
                }
                else{
                    $resourceOutput .= "<tr>";
                }
                $resourceOutput .= "<td>".$resource['resourceID']."</td>";
                $resourceOutput .= "<td>".$resource['resourceName']."</td>";
                $resourceOutput .= "<td>".$resource['resourceDescription']."</td>";
                $resourceOutput .= "<td>".$resource['resourceType']."</td>";
                $resourceOutput .= "<td>".$resource['resourceQuantity']."</td>";
                $resourceOutput .= "<td>  
                                        <a href=\"index.php?mid=431&action=edit&resourceID=".$resource['resourceID']."\" class=\"runbutton\">Edit</a>
                                        <a href=\"index.php?mid=430&action=remove&resourceID=".$resource['resourceID']."\" class=\"delbutton\">Remove</a>
                                    </td>";
                $resourceOutput .= "<tr>";
            }
            $resourceOutput .= "</table>";
        }
        else{
            $resourceOutput = "<p>There are no resources stored at present.</p>";
        }
        return $resourceOutput;
    }
    
    /*
     * Add a resource to the system
     * 
     */
    public function addResource($resname, $resdesc, $restype, $resquantity)
    {
        $resname = db::escapechars($resname);
        $resdesc = db::escapechars($resdesc);
        $restype = db::escapechars($restype);
        $resquantity = db::escapechars($resquantity);
        
        $sql = "INSERT INTO kidschurchresources SET
                resourceName = '$resname',
                resourceDescription = '$resdesc',
                resourceType = '$restype',
                resourceQuantity = '$resquantity'
                ";
        $result = db::execute($sql);
        if($result){
            return true;
        }
        else{
            return false;
        }
    }
    
    
    /*
     * Edit a resource in the system
     * 
     */
    public function editResource($resname, $resdesc, $restype, $resquantity, $resID)
    {
        $resname = db::escapechars($resname);
        $resdesc = db::escapechars($resdesc);
        $restype = db::escapechars($restype);
        $resquantity = db::escapechars($resquantity);
        $resID = db::escapechars($resID);
        
        $sql = "UPDATE kidschurchresources SET
                resourceName = '$resname',
                resourceDescription = '$resdesc',
                resourceType = '$restype',
                resourceQuantity = '$resquantity'
                WHERE
                resourceID = '$resID'
                LIMIT 1
                ";
        $result = db::execute($sql);
        if($result){
            return true;
        }
        else{
            return false;
        }
    }
    
    /*
     * Remove a resource from the system
     * 
     */
    public function removeResource($resourceID)
    {
        $resourceID = db::escapechars($resourceID);
        $sql = "DELETE FROM kidschurchresources WHERE resourceID='$resourceID' LIMIT 1";
        $result = db::execute($sql);
        if($result){
            return true;
        }
        else{
            return false;
        }
    }
    /*
     * Get a specific resource
     * 
     */
    public function getResource($resourceid)
    {
        $resourceid = db::escapechars($resourceid);
        $sql = "SELECT * FROM kidschurchresources WHERE resourceID='$resourceid'";
        $result = db::returnrow($sql);
        return $result;
    }
    
    /*
     * 
     * 
     */
    public function findMember($searchString, $campus)
    {
        $searchString = db::escapechars($searchString);
        $campus = db::escapechars($campus);
        
        $sql = "SELECT * FROM churchmembers WHERE ";
        
        $splitSearch = split(' ',trim($searchString));
        if(count($splitSearch) >= 1){
            $sql .="firstname LIKE '%".$splitSearch[0]."%' ";
                    
            if(count($splitSearch) > 2){      
                $sql .= "AND middlename LIKE '%".$splitSearch[1]."%'
                        AND surname LIKE '%".$splitSearch[2]."%') ";
            }
            if(count($splitSearch) == 2){
                $sql .= " AND surname LIKE '%".$splitSearch[1]."%' ";
            }
                    
        }
        if($campus != 'all'){
            $sql .= " AND campus='$campus'";
        }
        
        $result = db::returnallrows($sql);
        $personlist = "";
        
        // For each member you find, construct a link to select them as member controllers for the group
        foreach($result as $person){
            // Construct the a href entities for the people
            $personlist .= "<option value=\"".$person['memberID']."\">" . $person['firstname']." ".$person['middlename']." ". $person['surname']."</option>\r\t";
        }
        
        return $personlist;
        
    }
    
    /*
     * Function to sign children in to kids church
     * 
     */
    public function signChildIn($memberid, $groupid, $parentid)
    {
        $memberid = db::escapechars($memberid);
        $groupid = db::escapechars($groupid);
        $parentid = db::escapechars($parentid);
        
        $sql = "INSERT INTO kidschurchregister SET
                childid = '".$memberid."',
                userid = '".$this->usernametoid($_SESSION['Kusername'])."',
                kidschurchgroupid='$groupid',
                parentid='".$parentid."',
                timein=NOW()
                ";
        
        $result = db::execute($sql); 
        if($result){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    
    /*
     * Function to sign children out of kids church
     * 
     */
    public function signChildOut($memberid, $groupid, $parentid)
    {
        $memberid = db::escapechars($memberid);
        $groupid = db::escapechars($groupid);
        $parentid = db::escapechars($parentid);
        
        $sql = "INSERT INTO kidschurchregister SET
                childid = '".$memberid."',
                userid = '".$this->usernametoid($_SESSION['Kusername'])."',
                kidschurchgroupid='$groupid',
                parentid='".$parentid."',
                timeout=NOW()
                ";
        
        $result = db::execute($sql); 
        if($result){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    
    /*
     * Function to provide a list of all children signed in 
     * grouped by the kids church group
     */
    public function displaySignedIn()
    {
        $sql = "SELECT * FROM kidschurchregister WHERE timeout IS NULL";
        if(db::getnumrows($sql) > 0){
            print "<p>There are ".db::getnumrows($sql)." children currently signed-in.</p>";
            $result = db::returnallrows($sql);
            $outputtable = "<ul class=\"itemList\">";
            
            foreach($result as $child){
                $sql2 = "SELECT * FROM kidschurchgroups WHERE groupID='".$child['kidschurchgroupid']."'";
                $result2 = db::returnrow($sql2);
                $sql3 = "SELECT firstname, surname FROM churchmembers WHERE memberID='".$child['childid']."'";
                $result3 = db::returnrow($sql3);
                $outputtable .= "<li>&lt;<strong> " . $child['registerid']. " </strong>&gt; " . $result3['firstname'] . " " . $result3['surname'] . " in ". $result2['groupname'] . "  [ <a href=\"index.php?mid=460&function=signout&person=".$child['childid']."&rid=".$child['registerid']."\">Sign Out</a> ]</li>";
                
            }
            
            $outputtable .= "</ul>";
        }
        else{
            print "<p class=\"confirm\">There are no children currently signed-in.</p>";
        }
        print $outputtable;
    }
    
    /*
     * Function to display the historic registers for a given date
     * 
     */
    public function displayHistoricRegister($registerDate)
    {
        $registerDate = db::escapechars($registerDate);
        
        $sql = "SELECT * FROM kidschurchregister WHERE timein LIKE '$registerDate%'";
        if(db::getnumrows($sql) > 0){
            $result = db::returnallrows($sql);
            print "<h2>Register for $registerDate</h2>";
            $outputtable = "<ul class=\"itemList\">";
            
            foreach($result as $child){
                $sql2 = "SELECT * FROM kidschurchgroups WHERE groupID='".$child['kidschurchgroupid']."'";
                $result2 = db::returnrow($sql2);
                $sql3 = "SELECT firstname, surname FROM churchmembers WHERE memberID='".$child['childid']."'";
                $result3 = db::returnrow($sql3);
                $outputtable .= "<li>&lt;<strong> " . $child['registerid']. " </strong>&gt; " . $result3['firstname'] . " " . $result3['surname'] . " in ". $result2['groupname'] . " in at " . $child['timein'] . " out at " . $child['timeout'] . "</li>";
                
            }
            
            $outputtable .= "</ul>";
        }
        else{
            print "<p class=\"confirm\">There are no children currently signed-in.</p>";
        }
        print $outputtable;
    }
    
}

?>
