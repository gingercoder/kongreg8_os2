<?php

/*
 * Groups control class
 */


class groups extends kongreg8app{
    
    
    /*
     * View all groups in the system for the main home screen
     * 
     */
    public function viewGroups($groupid='')
    {
        $groupid = db::escapechars($groupid);
        $sql = "SELECT * FROM (groups RIGHT JOIN campus on groups.campusid=campus.campusID)ORDER BY groupname ASC";
        
        $result = db::returnallrows($sql);
        
        
        $groupTable = "";
        if(!empty($result)){
            $groupTable .= "<table class=\"memberTable\">
                    <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Leader</th>
                    <th>Campus</th>
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
                    <td>".$groupitem['campusName']."</td>    
                    <td><a href=\"index.php?mid=321&g=".$groupitem['groupID']."\">View</a> /
                        <a href=\"index.php?mid=305&g=".$groupitem['groupID']."&edit=true\">Edit</a> / 
                    <a href=\"index.php?mid=310&g=".$groupitem['groupID']."&remove=true\">Remove</a> 
                    
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
     * Add a group to the system based on the given details
     * from the main home screen
     */
    public function addGroup($groupname, $groupdescription, $groupleader, $campus)
    {
        
        $sql = "INSERT INTO groups SET
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
     * Edit / Update a group that exists in the system and store the new information
     * 
     */
    public function editGroup($groupid, $groupname, $groupdescription, $groupleader, $campus)
    {
        $sql = "UPDATE groups SET 
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
            $logArea = "Groups";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Store Fail";
            $logValue = $_SESSION['Kusername']." failed editing a group ".db::escapechars($sql);
            $logArea = "Groups";				
            $this->logerror($logType, $logValue, $logArea);
            return "Could not update at this time - please try again";
        }
        
    }
    
    /*
     * Delete a group from the system
     * 
     */
    public function groupDelete($groupid)
    {
        $sql = "SELECT groupname FROM groups WHERE groupID='".db::escapechars($groupid)."'";
        $result = db::returnrow($sql);
        $groupname = $result['groupname'];
        
        $sql = "DELETE FROM groups WHERE groupID='".db::escapechars($groupid)."' LIMIT 1";
        $result = db::execute($sql);
        
        if($result){
            // Log the activity
            $logType = "Delete";
            $logValue = $_SESSION['Kusername']." deleted a group, $groupname";
            $logArea = "Groups";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Store Fail";
            $logValue = $_SESSION['Kusername']." failed deleting a group ($groupname) ".db::escapechars($sql);
            $logArea = "Groups";				
            $this->logerror($logType, $logValue, $logArea);
            return false;
        }
    }
    
    /*
     * View a group's information when given a group id 
     * 
     */
    public function groupView($groupid)
    {
        if(!empty($groupid)){
            $sql = "SELECT * FROM groups WHERE groupID='".db::escapechars($groupid)."'";
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
            $personlist .= "[ <a href=\"index.php?mid=300&add=true&groupname=$groupname&groupdescription=$groupdescription&leader=".$person['memberID']."&campus=$campus\" 
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
        $sql = "SELECT groupname FROM groups WHERE groupID='".$groupID."'";
        $result = db::returnrow($sql);
        return $result['groupname'];
        
    }
    
    
    /*
     * Get the list of group members
     * 
     * 
     */
    public function viewGroupMembers($groupID, $memberID='')
    {
        $groupID = db::escapechars($groupID);
        $m = db::escapechars($memberID);
        
        $sql = "SELECT * FROM groupmembers JOIN churchmembers ON groupmembers.memberID = churchmembers.memberID WHERE groupmembers.groupID =  '" . $groupID . "'";
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
                        <a href=\"index.php?mid=321&m=" . $groupmember['memberID'] . "&g=" . $groupID ."&action=remove\" class=\"delbutton\">Remove</a> / 
                        <a href=\"index.php?mid=321&m=" . $groupmember['memberID'] . "&g=" . $groupID ."&action=setleader\" class=\"runbutton\">Set as Leader</a>
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
     * Add members to a group
     * 
     */
    public function addMemberToGroup($groupID, $memberID)
    {
        $groupID = db::escapechars($groupID);
        $memberID = db::escapechars($memberID);
        
        $sql = "INSERT INTO groupmembers SET 
                groupID='" . $groupID . "', 
                memberID='" . $memberID . "'
                ";
        $result = db::execute($sql);
        if($result){
            // Log the activity
            $logType = "Insert";
            $logValue = $_SESSION['Kusername']." added a group member to groupID $groupID";
            $logArea = "Groups";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Store Fail";
            $logValue = $_SESSION['Kusername']." failed adding a group member ".db::escapechars($sql);
            $logArea = "Groups";				
            $this->logerror($logType, $logValue, $logArea);
            return false;
        }
        
    }
    
    /*
     * Remove a member from a group
     * 
     */
    public function removeMemberFromGroup($groupID, $memberID)
    {
        $groupID = db::escapechars($groupID);
        $memberID = db::escapechars($memberID);
        
        $sql = "DELETE FROM groupmembers 
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
            $logArea = "Groups";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Removal Fail";
            $logValue = $_SESSION['Kusername']." failed removing a group member ".db::escapechars($sql);
            $logArea = "Groups";				
            $this->logerror($logType, $logValue, $logArea);
            return false;
        }
        
    }
    
    /*
     * Find a member to add to the 
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
            $personlist .= "[ <a href=\"index.php?mid=321&action=add&g=" . $groupID . "&m=" . $person['memberID'] . "\" 
                title=\"".$person['address1']." ".$person['address2']." ".$person['email']."\" >" 
                    . $person['firstname']." ".$person['middlename']." ". $person['surname']."</a> ] ";
        }
        
        return $personlist;
        
    }
    
    /*
     * Function to change the leader of a group to the new value
     * 
     */
    public function changeGroupLeader($groupID, $leaderID)
    {
        $groupID = db::escapechars($groupID);
        $leaderID = db::escapechars($leaderID);
        
        $sql = "UPDATE groups SET groupLeader='".$leaderID."' WHERE groupID='".$groupID."' LIMIT 1";
        $result = db::execute($sql);
        if($result){
            // Log the activity
            $logType = "Modify";
            $logValue = $_SESSION['Kusername']." edited group, ".db::escapechars($groupname);
            $logArea = "Groups";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Modify Fail";
            $logValue = $_SESSION['Kusername']." failed editing a group ".db::escapechars($sql);
            $logArea = "Groups";				
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
                print "<td><a href=\"index.php?mid=320&action=send&tid=" . $template['templateID'] . "\" class=\"runbutton\">Send</a> / 
                        <a href=\"index.php?mid=320&action=remove&tid=" . $template['templateID'] . "\" class=\"delbutton\">Remove</a>  
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
     * Group Select Dropdown
     * 
     */
    public function groupselectdropdown($campus)
    {
        $campus = db::escapechars($campus);
        if($campus == "all"){
            $sql = "SELECT groupname, groupID FROM groups ORDER BY groupname ASC";
        }
        else{
            $sql = "SELECT groupname, groupID FROM groups WHERE campusid='$campus' ORDER BY groupname ASC";
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
            $logArea = "Groups";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Store Fail";
            $logValue = $_SESSION['Kusername']." failed creating a new email template ".db::escapechars($sql);
            $logArea = "Groups";				
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
            $sql = "SELECT * FROM (groupmembers RIGHT JOIN churchmembers on groupmembers.memberID = churchmembers.memberID) GROUP BY groupmembers.memberID";
        }
        else{
            // Sending to ONE group, 
            $sql = "SELECT * FROM (groupmembers RIGHT JOIN churchmembers on groupmembers.memberID = churchmembers.memberID) WHERE groupmembers.groupID='".$groupID."'";
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
    
}

?>
