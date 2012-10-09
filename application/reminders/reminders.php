<?php

/*
 * Reminder Application Class
 * Includes all modules for the reminder application and notification system
 */


class reminders extends kongreg8app{
    
    /*
     * Get any reminders for the current user
     * and display them in a list for the screen
     * 
     */
    public function viewReminders($tableType, $range, $highlightid){
        $reminderPopup = "";
        $username = $_SESSION['Kusername'];
        $user = $this->usernametoid($username);
        $today = date('Y-m-d');
        $now = date('H:i:s');
        $sql = "SELECT * FROM myreminders WHERE userID = '$user'";
        if($range == 'all')
        {
            $sql .= " ORDER BY reminderDate";
        }
        else
        {
            $sql .= " AND reminderDate >= '$today' ORDER BY reminderDate ASC LIMIT 10";
        }
        
        $reminders = db::returnallrows($sql);
        if(db::getnumrows($sql) > 0){
            if($tableType == 'large')
            {
                print "<p><table class=\"reminderTableLarge\">";
                
                print "<tr><th width=\"100px\">Date/Time</th><th>Event</th><th width=\"120px\">Alert</th><th>Action</th></tr>";
            }
            else{
                print "<p><table class=\"reminderTable\">";
                
            }
            foreach($reminders as $entity){
                if($tableType =='large'){
                    $content = $entity['reminderContent'];
                }
                else{
                    $content = substr($entity['reminderContent'], 0, 20)."...[<a href=\"index.php?mid=600&rid=" . $entity['reminderID'] . "&h=1\">read more</a>]";
                }
                if($highlightid == $entity['reminderID']){
                    print "<tr class=\"highlight\">";
                }
                else{
                    print "<tr>";
                }
                    
                print "<td>" . $entity['reminderDate'] . "<br/>" . $entity['reminderTime'] . "</td>";
                print "<td>" . $entity['reminderTitle'] . "<br/>" . $content . "</td>";
                print "<td align=\"center\">";
                if($entity['reminderAlert'] == true){
                    print "<a href=\"index.php?mid=600&rid=" . $entity['reminderID'] . "&t=0\">";
                    print "<img src=\"images/smallONbutton.png\" alt=\"Off\" title=\"Turn Reminder Off\" border=\"0\" />";
                    print "</a>";
                    $todaydate = date('Y-m-d');
                    if($entity['reminderDate'] == $todaydate){
                        $reminderPopup .= "<span class=\"reminderItem\">" . $entity['reminderTitle']."<br/>On ".$entity['reminderDate']." at ".$entity['reminderTime']. "<br/>";
                        $reminderPopup .= $content."</span>";
                    }
                }
                else{
                    print "<a href=\"index.php?mid=600&rid=" . $entity['reminderID'] . "&t=1\">";
                    print "<img src=\"images/smallOFFbutton.png\" alt=\"On\" title=\"Turn Reminder On\" border=\"0\" />";
                    print "</a>";
                }
                print "</td>";
                if($tableType =='large'){
                    print "<td>
                            <a href=\"index.php?mid=600&remove=true&rid=".$entity['reminderID']."&h=1\">Remove</a> 
                            / 
                            <a href=\"index.php?mid=601&edit=true&rid=".$entity['reminderID']."\">Edit</a>
                            </td>";
                }
                    print "</tr>";
            }
            print "</table></p>";
            if($tableType == 'small')
            {
                return $reminderPopup;
            }
            else
            {
                return true;
            }
        }
        else{
            print "<p>No reminders</p>";
        }
        
    }
    
    
    /*
     * Function to pull the number of reminders set today
     * Used for the main homepage overview
     * 
     */
    public function numreminderstoday(){
        $username = $_SESSION['Kusername'];
        $user = $this->usernametoid($username);
        $reminders = 0;
        $today = date('Y-m-d');
        $now = date('H:i:s');
        $sql = "SELECT * FROM myreminders WHERE userID = '$user' AND reminderDate >= '$today' AND reminderAlert = '1' ORDER BY reminderDate ASC LIMIT 10";
        $reminders = db::getnumrows($sql);
        return $reminders;
    }
    
    /*
     * Toggle a reminder to pull an alert pane
     * or turn off the alert pane requirement
     * 
     */
    public function toggleAlert($reminderID, $state){
        $sql = "UPDATE myreminders SET reminderAlert = ";
        if($state == 'true'){
            $sql .= "'1'";
        }
        else{
            $sql .= "'0'";
        }
        $sql .= " WHERE reminderID='".db::escapechars($reminderID)."' LIMIT 1";
        
        $setAlert = db::execute($sql);
        if($setAlert == true){
            return true;
        }
        else{
            return false;
        }
    }
    
    /*
     * Add a reminder to the system
     * 
     */
    
    public function addReminder($title, $content, $thedate, $thetime, $alert, $user)
    {
        // sanatize anything necessary
        $title = db::escapechars($title);
        $content = db::escapechars($content);
        $user = db::escapechars($user);
        
        $sql = "INSERT INTO myreminders SET
                reminderTitle = '$title',
                reminderContent = '$content',
                reminderDate = '$thedate',
                reminderTime = '$thetime',
                userID = '$user',
                reminderAlert = '$alert'
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
     * Function to check for reminders as you go through the system
     * and returning warnings as you go as necessary
     */
    
    public function checkForReminder()
    {
        $username = $_SESSION['Kusername'];
        $user = $this->usernametoid($username);
        $reminders = 0;
        $today = date('Y-m-d');
        $now = date('H:i:s', mktime(date("H"), date("i") - 5, date("s")));
        $nowplusfive = date('H:i:s', mktime(date("H"), date("i") + 5, date("s")));
        $sql = "SELECT * FROM myreminders WHERE (userID = '$user' AND reminderDate = '$today' AND (reminderTime >= '$now' AND reminderTime <= '$nowplusfive')) AND reminderAlert = '1' ";
        $reminders = db::getnumrows($sql);
        if($reminders > 0){
            $notice =  "
                        <h2>Reminder!</h2><p>Alert! You have a reminder set [ <a href=\"index.php?mid=600\">view reminders now</a> ] or 
                        [ <a href=\"#\" onClick=\"hidereminder('reminderWarning');\">Dismiss</a> ]
                        ";
            return $notice;
        }
        else{
            return false;
        }
    }
    
    /*
     * Function to remove a reminder for a specified current user
     * 
     */
    
    public function removeReminder($reminderID)
    {
        $reminderID = db::escapechars($reminderID);
        
        $sql = "DELETE FROM myreminders WHERE reminderID='$reminderID' LIMIT 1";
        $result = db::execute($sql);
        if($result){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    
    /*
     * Edit an existing reminder in the system
     * 
     */
    public function editReminder($reminderID, $title, $content, $thedate, $thetime, $alert, $user)
    {
        // sanatize anything necessary
        $title = db::escapechars($title);
        $content = db::escapechars($content);
        $user = db::escapechars($user);
        $reminderID = db::escapechars($reminderID);
        
        $sql = "UPDATE myreminders 
                SET
                reminderTitle = '$title',
                reminderContent = '$content',";
        
                if($thedate != '--------'){
                    $sql .= "reminderDate = '$thedate',";
                }
                if($thetime != '--:--'){
                    $sql .= "reminderTime = '$thetime',";
                }
                
        $sql .= "userID = '$user',
                reminderAlert = '$alert'
                WHERE
                reminderID='$reminderID'
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
     * Pull a specific reminder from the system
     * 
     */
    public function viewReminder($reminderID)
    {
        $reminderID = db::escapechars($reminderID);
        $sql = "SELECT * FROM myreminders WHERE reminderID='$reminderID'";
        $result = db::returnrow($sql);
        return $result;
        
    }
}

?>
