<?php

/*
 * Campus Control System for multi-site churches
 */

class campus extends kongreg8app{
    
    
    /*
     * Pull a list of all campuses available on the system
     * 
     */
    public function showAvailable($campusid='')
    {
        // If passed a campus ID then highlight that row
        if($campusid !=""){
            $campusid = db::escapechars($campusid);
        }
        $sql = "SELECT * FROM campus ORDER BY campusName ASC";
        $result = db::returnallrows($sql);
        if(db::getnumrows($sql) >0){
            print "<table class=\"campusTable\">";
            print "<tr><th>Name</th><th>Description</th><th>Postcode</th><th>Phone</th><th>Email</th><th>Action</th></tr>";
            foreach($result as $campus){
                if($campus['campusid'] == $campusid){
                    print "<tr class=\"highlight\">";
                }
                else{
                    print "<tr>";
                }
                print "<td>" . $campus['campusName'] . "</td>";
                print "<td>" . $campus['campusDescription'] . "</td>";
                print "<td>" . $campus['postcode'] . "</td>";
                print "<td>" . $campus['telephoneNumber'] . "</td>";
                print "<td>" . $campus['emailAddress'] . "</td>";
                print "<td><a href=\"index.php?mid=245&cid=" . $campus['campusid'] . "\">Edit</a> / <a href=\"index.php?mid=240&c=" . $campus['campusid'] ."&remove=true\">Remove</a></td>";
                print "</tr>";
            }
            print "</table>";
        }
        return true;
    }
    
    
    /*
     * Insert a new campus into the system
     * 
     */
    public function createNew($campusName, $campusDescription, $campusAddress1, $campusAddress2, $campusPostcode, $campusPhone, $campusEmail, $campusURL)
    {
        

        $sql = "INSERT INTO campus SET
                campusName='".db::escapechars($campusName)."',
                campusDescription='".db::escapechars($campusDescription)."',
                address1='".db::escapechars($campusAddress1)."',
                address2='".db::escapechars($campusAddress2)."',
                postcode='".db::escapechars($campusPostcode)."',
                emailAddress='".db::escapechars($campusEmail)."',
                campusURL='".db::escapechars($campusURL)."',
                telephoneNumber='".db::escapechars($campusPhone)."',
                dateCreated = NOW(),
                dateModified = NOW()
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
     * Get Campus Name function - derives the name of the campus for a given campus ID
     * 
     */
    public function getCampusName($campusid)
    {
        if($campusid == ""){
            return false;
        }
        else{
            $sql = "SELECT campusName FROM campus WHERE campusid = '".db::escapechars($campusid)."'";
            $result = db::returnrow($sql);
            return $result['campusName'];
        }
        
    }
    
    /*
     * Remove a campus from the system
     * Due to links that exist with members and users, the function needs to loop through 
     * these as well and change them to a blank value where necessary.
     */
    public function removeCampus($campusid)
    {
        // clean incomming
        $remcampus = db::escapechars(trim($campusid));
        // get campus name before deleting
        $campusName = $this->getCampusName($campusid);
        
        // Delete the campus
        $sql = "DELETE FROM campus WHERE campusid='$remcampus' LIMIT 1";
        $result = db::execute($sql);
        if($result){
            // Campus was removed from the system - now log the activity and 
             
             
            
            // remove links for church members table to non-existent campus
            $sql = "UPDATE churchmembers SET campusid='0' WHERE campus='$remcampus'";
            $result = db::execute($sql);
            if($result){
                // Log the activity
                
                // Now remove links for admin users
                $sql = "UPDATE users SET campus='0' WHERE campus='$remcampus'";
                $result = db::execute($sql);
                if($result){
                    // Went through okay - log the activity and return
                    $logType = "Campus";
                    $logValue = $_SESSION['kusername']." removed campus $campusName";
                    $logArea = "Members";
                    $this->logevent($logType, $logValue, $logArea);
                    return true;
                    
                }
                else{
                    // Log the failure
                    $logType = "Campus Removal Fail";
                    $logValue = $_SESSION['kusername']." failed campus removal process (changing admins for $campusName) with  ".db::escapechars($sql);
                    $logArea = "Campus";
                    $this->logerror($logType, $logValue, $logArea);
                }
            }
            else{
                // Didn't update the church members section - log incident and return
                $logType = "Campus Removal Fail";
                $logValue = $_SESSION['kusername']." failed campus removal process (church members for $campusName) with  ".db::escapechars($sql);
                $logArea = "Campus";
                $this->logerror($logType, $logValue, $logArea);
            }
        }
        else{
            // Campus was not removed from the system - log incident and return
            $logType = "Campus Removal Fail";
            $logValue = $_SESSION['kusername']." failed campus removal process (removing campus $campusName) with  ".db::escapechars($sql);
            $logArea = "Campus";
            $this->logerror($logType, $logValue, $logArea);
            return false;
        }
        
    }
    
    /*
     * Get campus information for edit screen and general information windows
     * 
     */
    public function viewCampusInfo($campusid)
    {
        $campusid = db::escapechars($campusid);
        
        $sql = "SELECT * FROM campus WHERE campusid = '$campusid'";
        $result = db::returnrow($sql);
        if($result){
            return $result;
            
        }
        else{
            return false;
        }
        
        
    }
    
    
    
    /*
     * Update campus
     * 
     */
    public function runUpdate($campusid, $campusName, $campusDescription, $campusAddress1, $campusAddress2, $campusPostcode, $campusPhone, $campusEmail, $campusURL)
    {
        

        $sql = "UPDATE campus SET
                campusName='".db::escapechars($campusName)."',
                campusDescription='".db::escapechars($campusDescription)."',
                address1='".db::escapechars($campusAddress1)."',
                address2='".db::escapechars($campusAddress2)."',
                postcode='".db::escapechars($campusPostcode)."',
                emailAddress='".db::escapechars($campusEmail)."',
                campusURL='".db::escapechars($campusURL)."',
                telephoneNumber='".db::escapechars($campusPhone)."',
                dateModified = NOW()
                WHERE
                campusid='" . db::escapechars($campusid) . "'
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
    
}

?>
