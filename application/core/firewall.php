<?php

/*
 * Firewall system built into the core framework
 * Extends the main kongreg8app class
 * 
 */

class firewall extends kongreg8app{
    
        /*
         * Check if firewall turned on or off in main settings
         * If turned on return true to function that called it
         * 
         */
         public function checkstate(){
             $sql = "SELECT * FROM settings WHERE settingName='firewall'";
             $result = db::returnrow($sql);
             if($result['settingValue'] == '1'){
                 return true;
             }
             else{
                 return false;
             }
         }
    
    
         /*
          * 
          * Set the firewall state from the main firewall view page
          * Sets to either off or on in the kongreg8 config db table
          * 
          */
         public function setstate($state){
             if($state == 'on'){
                 $sql = "UPDATE settings SET settingValue='1' WHERE settingName='firewall' LIMIT 1";
             }
             elseif($state == 'off'){
                 $sql = "UPDATE settings SET settingValue='0' WHERE settingName='firewall' LIMIT 1";
             }
             $setok = db::execute($sql);
             
         }
    
         /*
         * 
         * Check the firewall rules for system access
         * Runs a check against stored IP addresses and the remote address
         * If a match occurs and the mode is set to allow return true to the
         * script calling it 
         * 
         */
        public function checkip(){
            $localIP = str_replace('.', '', $this->addZeros($this->getIP()));
            $sql = "SELECT * FROM kfirewall WHERE ipaddress >='$localIP' AND '$localIP' <= endaddress";
            $result = db::returnrow($sql);
            if($result){
                if($result['mode'] == 1){
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
         * 
         * Get the current full list of firewall items.
         * Used on the main firewall screen.
         * 
         */
        
        public function getRuleList($rulenumber=''){
            $ruletable = "";
            $rulenumber = db::escapechars($rulenumber);
            
            $sql = "SELECT * FROM kfirewall ORDER BY firewallid ASC";
            $result = db::returnallrows($sql);
            $ruletable .= "<table class=\"firewalltable\">\r\n
                            <tr>\r\n
                            <th>Rule ID</th>\r\n
                            <th>Rule Title</th>\r\n
                            <th>Date Modified</th>\r\n
                            <th>Start</th>\r\n
                            <th>End</th>\r\n
                            <th>Allow/Deny</th>\r\n
                            <th>Status</th>\r\n
                            <th>Modify</th>\r\n
                            </tr>\r\n";
            foreach($result as $rule){
                
                $ruletable .= "<form name=\"ruleedit".$rule['firewallid']."\" action=\"index.php\" method=\"post\">";
                $ruletable .= "<input type=\"hidden\" name=\"mid\" id=\"mid\" value=\"999900\" />";
                $ruletable .= "<input type=\"hidden\" name=\"ruleID\" id=\"ruleID\" value=\"".$rule['firewallid']."\" />";
                $ruletable .= "<input type=\"hidden\" name=\"update\" id=\"update\" value=\"true\" />";
                // Row highlight if it's in selection mode
                if($rule['firewallid'] == $rulenumber){
                    $ruletable .= "<tr class=\"highlight\">\r\n";
                }
                else{
                    $ruletable .= "<tr>\r\n";
                }
                
                $ruletable .= "<td>".$rule['firewallid']."</td>";
                $ruletable .= "<td><input type=\"text\" name=\"ruleTitle\" id=\"ruleTitle\" value=\"".$rule['ruleTitle']."\" /></td>";
                $ruletable .= "<td>".$rule['datemodified']."</td>";
                
                // Sort out the dot in the middle of each of the entries
                $start[0] = substr($rule['ipaddress'], 0 , 3);
                $start[1] = substr($rule['ipaddress'], 3 , 3);
                $start[2] = substr($rule['ipaddress'], 6 , 3);
                $start[3] = substr($rule['ipaddress'], 9 , 3);
                $startfull = $start[0].'.'.$start[1].'.'.$start[2].'.'.$start[3];
                
                $end[0] = substr($rule['endaddress'], 0 , 3);
                $end[1] = substr($rule['endaddress'], 3 , 3);
                $end[2] = substr($rule['endaddress'], 6 , 3);
                $end[3] = substr($rule['endaddress'], 9 , 3);
                $endfull = $end[0].'.'.$end[1].'.'.$end[2].'.'.$end[3];
                
                $ruletable .= "<td><input type=\"text\" name=\"ipstart\" value=\"".$startfull."\" /></td>";

                $ruletable .= "<td><input type=\"text\" name=\"ipend\" value=\"".$endfull."\" /></td>";

                
                $ruletable .= "<td><select name=\"allowdeny\" id=\"allowdeny\">";
                if($rule['mode'] == 0)
                {
                    $ruletable .= "<option value=\"0\">deny</option>";
                    $ruletable .= "<option value=\"1\">allow</option>";
                }
                else
                {
                    $ruletable .= "<option value=\"1\">allow</option>";
                    $ruletable .= "<option value=\"0\">deny</option>";
                }
                
                $ruletable .="</select></td>";

                
                $ruletable .= "<td><select name=\"state\" id=\"state\">";
                if($rule['status'] == 0)
                {
                    $ruletable .= "<option value=\"0\">inactive</option>";
                    $ruletable .= "<option value=\"1\">active</option>";
                }
                else
                {
                    $ruletable .= "<option value=\"1\">active</option>";
                    $ruletable .= "<option value=\"0\">inactive</option>";
                }
                $ruletable .="</select></td>";

                $ruletable .= "<td> <input type=\"submit\" value=\"Save\"/> ";
                $ruletable .= "/ <a href=\"index.php?mid=999900&rid=" . $rule['firewallid'] . "&rm=true\">Remove</a></td>";
                $ruletable .= "</tr>\r\n";
                $ruletable .= "</form>";
            }
            $ruletable .= "<form name=\"firewallrule\" action=\"index.php\" method=\"post\">
                           <input type=\"hidden\" name=\"mid\" id=\"mid\" value=\"999900\"/>
                           <input type=\"hidden\" name=\"store\" id=\"store\" value=\"true\"/>
                            ";
            $ruletable .= "<tr><td>---</td><td>Default Deny</td><td>---</td><td>any</td><td>any</td><td>deny</td><td>active</td><td>&nbsp;</td></tr>";
            
            $ruletable .= "<tr><td>&nbsp;</td>
                                <td><input type=\"text\" maxlength=\"50\" name=\"ruleTitle\" id=\"ruleTitle\" placeholder=\"new rule name\" /></td>
                                <td>&nbsp;</td>
                                <td><input type=\"text\" maxlength=\"15\" name=\"ipstart\" id=\"ipstart\" placeholder=\"" . $_SERVER['REMOTE_ADDR'] . "\" /></td>
                                <td><input type=\"text\" maxlength=\"15\" name=\"ipend\" id=\"ipend\" placeholder=\"" . $_SERVER['REMOTE_ADDR'] . "\" /></td>
                                <td><select name=\"allowdeny\" id=\"allowdeny\">
                                    <option value=\"1\">Allow</option>
                                    <option value=\"0\">Deny</option>
                                    </select>
                                </td>
                                <td><select name=\"state\" id=\"state\">
                                    <option value=\"1\">Active</option>
                                    <option value=\"0\">Inactive</option>
                                    </select>
                                    </td>
                                    <td>
                                    <input type=\"submit\" value=\"Add rule\" />
                                    </td>
                                </tr></form>";
            
            $ruletable .= "</table>\r\n";
            print $ruletable;
        }
        
        /*
         * 
         * Add a rule to the firewall database table
         * to allow or deny a new entry
         * 
         */
        public function addRule($title, $startAddress, $endAddress, $mode, $state)
        {
            // sanitize incoming vars
            $startAddress = db::escapechars($startAddress);
            $endAddress = db::escapechars($endAddress);
            $title = db::escapechars($title);
            
            if($state == '1'){
                $stateset = true;
            }
            else{
                $stateset = false;
            }
            if($mode == '1'){
                $modeset = true;
            }
            else{
                $modeset = false;
            }
            $userID = $this->usernametoid($_SESSION['Kusername']);
            
            $cleanStart = $this->addZeros($startAddress);
            $cleanEnd = $this->addZeros($endAddress);
            
            // pop new item into database
            $sql = "INSERT INTO kfirewall SET
                    ruleTitle = '$title',
                    ipaddress = '$cleanStart',
                    endaddress = '$cleanEnd',
                    userID = '$userID',
                    mode = '$modeset',
                    status = '$stateset',
                    datecreated = NOW(),
                    datemodified = NOW()
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
         * Modify a rule in the firewall database table
         * to change an existing rule
         * 
         * 
         */
        public function editRule($title, $startAddress, $endAddress, $mode, $state, $ruleID)
        {
            // sanitize incoming vars
            $startAddress = db::escapechars($startAddress);
            $endAddress = db::escapechars($endAddress);
            $title = db::escapechars($title);
            
            if($state == '1'){
                $stateset = true;
            }
            else{
                $stateset = false;
            }
            if($mode == '1'){
                $modeset = true;
            }
            else{
                $modeset = false;
            }
            $userID = $this->usernametoid($_SESSION['Kusername']);
            $ruleID = db::escapechars($ruleID);
            
            $cleanStart = $this->addZeros($startAddress);
            $cleanEnd = $this->addZeros($endAddress);
            
            // pop new item into database
            $sql = "UPDATE kfirewall SET
                    ruleTitle = '$title',
                    ipaddress = '$cleanStart',
                    endaddress = '$cleanEnd',
                    userID = '$userID',
                    mode = '$modeset',
                    status = '$stateset',
                    datemodified = NOW()
                    WHERE 
                    firewallid = '$ruleID'
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
         * Remove a rule from the system
         * 
         */
        public function removeItem($ruleID)
        {
            $ruleID = db::escapechars($ruleID);
            $sql = "DELETE FROM kfirewall WHERE firewallid='$ruleID' LIMIT 1";
            $result = db::execute($sql);
            if($result){
                return true;
            }
            else{
                return false;
            }
            
        }
        
        /*
         * Function to add zeros to the IP addresses if they'd forgotten
         * to add them in the main interface.
         * 
         */
        
        public function addZeros($address)
        {
            
            // add extra zeros to the items if they have been entered incorrectly
            $splitaddress = explode('.',$address);
            
            for($i=0; $i<=3; $i++)
            {
                // add zeros to the start address stuff
                if($splitaddress[$i] < 100)
                {
                    if($splitaddress[$i] < 10){
                        $splitaddress[$i] = '00'.intval($splitaddress[$i]);
                    }
                    else{
                        $splitaddress[$i] = '0'.intval($splitaddress[$i]);
                    }
                }
            }
            $cleanAddress = $splitaddress[0].$splitaddress[1].$splitaddress[2].$splitaddress[3];
            return $cleanAddress;
        }
        
        
        
        /*
         * Intrusion Detection System
         * View log of activity between two dates
         * 
         */
        
        public function idsLog($startdate, $enddate)
        {
            $startdate = db::escapechars($startdate);
            $enddate = db:: escapechars($enddate);
            
            $sql = "SELECT * FROM klog WHERE 
                    ( logDate between '$startdate' and '$enddate')
                    AND
                    logValue LIKE '%Failed%'
                    ORDER BY logDate DESC, logTime DESC
                    ";
            $result = db::returnallrows($sql);
            if(db::getnumrows($sql) >0){
                $returnTable = "<table class=\"firewalltable\">
                                <tr>
                                <th>Date</th>
                                <th>Information</th>
                                </tr>
                                ";
                
                foreach($result as $entry){
                    $returnTable .= "<tr>
                                    <td>" . $entry['logDate'] . " " . $entry['logTime'] . "</td>
                                    <td>" . $entry['logValue'] . "</td>
                                    </tr>\r\n
                                    ";
                    
                }
                $returnTable .= "</table>";
                return $returnTable;
            }
            else{
                return false;
            }
        }
}
?>
