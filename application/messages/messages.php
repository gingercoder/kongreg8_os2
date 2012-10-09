<?php

/*
 * Internal messaging system for admin to admin communication
 */


class messages extends kongreg8app {
    
    /*
     * Number of new messages for a user.
     * 
     */
    public function numberNew($username)
    {

        $sql = "SELECT * FROM messaging WHERE messageto = '" . $this->usernametoid(db::escapechars($username)) . "' AND messageStatus = 'new' ";
    
        $result = db::getnumrows($sql);
        if(is_null($result)){
            return '0';
        }
        else{
            return $result;
        }
    }
    
    /*
     * Get messages for a user
     * function available for main admins incase requried
     * 
     */
    public function returnMessages($username)
    {
        $userid = $this->usernametoid(trim($username));
        
        $sql = "SELECT * FROM (messaging RIGHT JOIN users ON users.userID = messaging.userID)  WHERE messaging.messageto = '" . $userid . "' ORDER BY messaging.datelogged DESC";
        
        $results = db::returnallrows($sql);
        return $results;
    }
    
    /*
     * Get a specific message for a specific user 
     * function available for main admins incase required
     */
    public function getMessage($username, $messageid)
    {
        $userid = $this->usernametoid($username);
        $messageid = db::escapechars($messageid);
        
        $sql = "SELECT * FROM messaging WHERE userID='$userid' AND messageID='$messageid'";
        $result = db::returnrow($sql);
        
        return $result;
        
        
    }
    
    /*
     * function to pull all of the threads for a given message
     * this applies to replies etc.
     */
    public function viewThread($messageid)
    {
        $messageid = db::escapechars($messageid);
        
        $sql = "SELECT * FROM messaging WHERE inReplyTo='$messageid' ORDER BY datelogged DESC";
        $result = db::returnallrows($sql);
        
        return $result;
    }
    
    /*
     * Create an admin-person drop-down for the messaging system
     * 
     */
    public function todropdown()
    {

        $sql = "SELECT * FROM users ORDER BY surname ASC, firstname ASC";
        $result = db::returnallrows($sql);
        
        $dropdown = '<select name="towho" id="towho">';
        
        $dropdown .='<option default value="">Please select</option>';
        foreach($result as $auser){
            $dropdown .= '<option value="' . $auser['userID'] . '">' . $auser['surname'] . ', ' . $auser['firstname'] . '</option>';
        }
        $dropdown .= '</select>';
        
        return $dropdown;
    }
    
    /*
     * Store a message in the system
     * update message status if replying and keep thread information using inReplyTo
     * 
     */
    public function storeMessage($title, $message, $towho, $inReplyTo = '')
    {
        $sql = "INSERT INTO messaging SET
                subject = '" . db::escapechars($title) . "',
                messageto = '" . db::escapechars($towho) . "',
                mainmessage = '" . db::escapechars($message) . "',";
        
        if($inReplyTo !=''){
                
                $sql .= "inReplyTo = '" . db::escapechars($inReplyTo) . "',";
        }
                
        $sql .= "userID = '" . $this->usernametoid($_SESSION['Kusername']) . "',
                messageStatus = 'new',
                datelogged = NOW()
                ";
        $result = db::execute($sql);
        if($result){
            $sql2 = "UPDATE messaging SET messageStatus='reply' WHERE messageID='".$inReplyTo."' LIMIT 1";
            $result2 = db::execute($sql2);
            
            // Log the activity
            $logType = "Messaging";
            $logValue = $_SESSION['Kusername']." sent a message";
            $logArea = "Messaging";				
            $this->logevent($logType, $logValue, $logArea);
            
            return true;
        }
        else{
            // Log the failure
            $logType = "Store Fail";
            $logValue = $_SESSION['Kusername']." failed sending message ".db::escapechars($sql);
            $logArea = "Messaging";				
            $this->logerror($logType, $logValue, $logArea);
            return false;
        }
        
    }
    
    
    /*
     * Delete a message
     * 
     */
    public function deleteMessage($messageid)
    {
        $sql = "DELETE FROM messaging WHERE messageID='" . db::escapechars($messageid) . "' LIMIT 1";
        $result = db::execute($sql);
        if($result){
            // Log the activity
            $logType = "Messaging";
            $logValue = $_SESSION['Kusername']." deleted a message";
            $logArea = "Messaging";				
            $this->logevent($logType, $logValue, $logArea);
            return true;
        }
        else{
            // Log the failure
            $logType = "Delete Fail";
            $logValue = $_SESSION['Kusername']." failed deleting message ".db::escapechars($sql);
            $logArea = "Messaging";				
            $this->logerror($logType, $logValue, $logArea);
            return false;
        }
        
    }
}

?>
