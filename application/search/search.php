<?php



/**
 * Search system DB access and rendering script
 * Searches the various areas of the system
 * Each module has it's own function set to use - these can be used together or separately.
 *
 */


class search extends kongreg8app{
    
    
    public $searchTerm;
    
    /*
     * Main Get results function pulls all items
     * If you develop your own modules, it is recommended that you create a search function
     * for them within the search class and then link to them in the getresults function
     * 
     */
    public function getresults($searchterm)
    {
        $searchTerm = db::escapechars(trim($searchterm));
        
        // Check if there is a campus lock
        $campus = $this->checkCampus();
        if($campus == 'true')
        {
            // Access to all campuses
            $campuslock = '';
        }
        else{
            if($campus == 'false'){
                // No access to search results - no campus specified
                return;
            }
            else{
                $campuslock = $campus; 
            }
        }
        // Get the results from the system and display the output
        if(!is_null($searchTerm)){
            $this->findhelp($searchTerm, $campuslock);
            $this->findmembers($searchTerm, $campuslock);
            $this->findgroup($searchTerm, $campuslock);
            $this->findmessages($searchTerm);
            $this->findreminders($searchTerm);
        }
        else{
            print "<p>No search term provided</p>";
        }
        
        return;
    }
    
    /*
     * Find information from the members table
     * 
     */
    public function findmembers($searchTerm, $campus)
    {
        // Search the members and display output
        $sql = "SELECT * FROM churchmembers WHERE 
                    (";
        
        $splitSearch = split(' ',trim($searchTerm));
        if(count($splitSearch) > 1){
            $sql .="firstname LIKE '%".$splitSearch[0]."%'";
                    
            if(count($splitSearch) > 2){      
                $sql .= "AND middlename LIKE '%".$splitSearch[1]."%'
                        AND surname LIKE '%".$splitSearch[2]."%')";
                $searchcriteria = "<p>Discovered a first name , middle name and surname possibility - searching specifically</p>";
            }
            else{
                $sql .= " AND surname LIKE '%".$splitSearch[1]."%')";
                $searchcriteria = "<p>Discovered a first name and surname possibility - searching specifically</p>";
            }
                    
        }
        else{
            $sql .="
                    firstname LIKE '%$searchTerm%'
                    OR
                    middlename LIKE '%$searchTerm%'
                    OR 
                    surname LIKE '%$searchTerm%'
                    OR 
                    address1 LIKE '%$searchTerm%'
                    OR 
                    address2 LIKE '%$searchTerm%'
                    OR 
                    address4 LIKE '%$searchTerm%'
                    OR
                    postcode LIKE '%$searchTerm%'
                    OR
                    homephone LIKE '%$searchTerm%'
                    OR 
                    mobilephone LIKE '%$searchTerm%'
                    OR
                    email LIKE '%$searchTerm%'
                    OR 
                    medicalInfo LIKE '%$searchTerm%'
                    OR
                    memberStatus LIKE '%$searchTerm%'
                    OR 
                    workphonenumber LIKE '%$searchTerm%'
                    OR 
                    workemail LIKE '%$searchTerm%'
                    OR
                    occupation LIKE '%$searchTerm%'
                    OR
                    employer LIKE '%$searchTerm%'
                    )";
                    $searchcriteria = "<p>Searching broad-term on members area</p>";
        }
        
        
                    if($campus !=''){
                        $sql .= " AND campusid='".db::escapechars($campus)."'";
                    }
                    $sql .= "
                    ORDER BY surname ASC, firstname ASC
                    ";
            
            // Output the table
            $numentities = 0;
            $numentities = db::getnumrows($sql);
            print "<p>" . $numentities . " discovered in members.</p>";
            if($numentities > 0)
                {
                print "<h2>Member Results</h2>";
                print $searchcriteria;
                print "<p><table class=\"searchtable\">";
                print "<tr><th>Surname</th><th>Firstname</th><th>Address 1</th><th>Postcode</th><th>Action</th></tr>";
                $data = db::returnallrows($sql);
                foreach($data as $result)
                {
                    // Display the member information
                    print "<tr>";
                    print "<td>" . $result['surname'] . "</td>";
                    print "<td>" . $result['firstname'] . "</td>";
                    print "<td>" . $result['address1'] . "</td>";
                    print "<td>" . $result['postcode'] . "</td>";
                    print "<td><a href=\"index.php?mid=225&m=" . $result['memberID'] . "\">View</a></td>";
                    print "</tr>";
                }
                print "</table>";
                print "</p>";
            }
            
            
            
            return true;
    }
    
    /*
     * Find information from the groups table
     * 
     */
    public function findgroup($searchTerm, $campus)
    {
        // Search the groups
        $sql = "SELECT * FROM groups WHERE
                (groupname LIKE '%$searchTerm%'
                OR
                groupdescription LIKE '%$searchTerm%')
                ";
                if($campus !=""){
                    $sql .= " AND campusid='".db::escapechars($campus)."'";
                }
        
        // Output the table
            $numentities = 0;
            $numentities = db::getnumrows($sql);
            print "<p>" . $numentities . " discovered in groups.</p>";
            if($numentities > 0)
                {
                print "<h2>Group Results</h2>";
                print "<p><table class=\"searchtable\">";
                print "<tr><th>Group name</th><th>Description</th><th>Action</th></tr>";
                $data = db::returnallrows($sql);
                foreach($data as $result)
                {
                    // Display the group information
                    print "<tr>";
                    print "<td>" . $result['groupname'] . "</td>";
                    print "<td>" . $result['groupdescription'] . "</td>";
                    print "<td><a href=\"index.php?mid=1010&g=" . $result['groupID'] . "\">View</a></td>";
                    print "</tr>";
                }
                print "</table>";
                print "</p>";
            }
        
    }
    
    public function findhelp($searchTerm, $campus)
    {
        // Search the groups
        $sql = "SELECT * FROM helpsystem WHERE
                helpTitle LIKE '%$searchTerm%'
                OR
                helpContent LIKE '%$searchTerm%'
                ";
        
        // Output the table
            $numentities = 0;
            $numentities = db::getnumrows($sql);
            print "<p>" . $numentities . " discovered in help.</p>";
            if($numentities > 0)
                {
                print "<h2>Help Results</h2>";
                print "<p><table class=\"searchtable\">";
                print "<tr><th>Help title</th><th>Content</th></tr>";
                $data = db::returnallrows($sql);
                foreach($data as $result)
                {
                    // Display the group information
                    print "<tr>";
                    print "<td>" . $result['helpTitle'] . "</td>";
                    print "<td>" . $result['helpContent'] . "</td>";
                    print "</tr>";
                }
                print "</table>";
                print "</p>";
            }
        
    }
    
    
    public function findmessages($searchTerm)
    {
        
        $userid = $this->usernametoid($_SESSION['Kusername']);

        // Search the groups
        $sql = "SELECT * FROM messaging 
                WHERE
                ((subject LIKE '%$searchTerm%')
                OR
                (mainmessage LIKE '%$searchTerm%'))
                AND
                ((userID='$userid') OR (messageto='$userid'))
                ";
        // Output the table
            $numentities = 0;
            $numentities = db::getnumrows($sql);
            print "<p>" . $numentities . " discovered in messages.</p>";
            if($numentities > 0)
                {
                print "<h2>Your Message Box Results</h2>";
                print "<p><table class=\"searchtable\">";
                print "<tr><th>Message title</th><th>Content</th><th>Date</th></tr>";
                $data = db::returnallrows($sql);
                foreach($data as $result)
                {
                    // Display the group information
                    print "<tr>";
                    print "<td>" . $result['subject'] . "</td>";
                    print "<td>" . $result['mainmessage'] . "</td>";
                    print "<td>" . $result['datelogged'] . "</td>";
                    print "</tr>";
                }
                print "</table>";
                print "</p>";
            }
        
    }
    
    
    public function findreminders($searchTerm)
    {
        
        $userid = $this->usernametoid($_SESSION['Kusername']);

        // Search the groups
        $sql = "SELECT * FROM myreminders 
                WHERE
                ((reminderTitle LIKE '%$searchTerm%')
                OR
                (reminderContent LIKE '%$searchTerm%'))
                AND
                (userID='$userid')
                ";
        // Output the table
            $numentities = 0;
            $numentities = db::getnumrows($sql);
            print "<p>" . $numentities . " discovered in reminders.</p>";
            if($numentities > 0)
                {
                print "<h2>Your Reminder System Results</h2>";
                print "<p><table class=\"searchtable\">";
                print "<tr><th>Reminder title</th><th>Content</th><th>Date / Time</th><th>Action</th></tr>";
                $data = db::returnallrows($sql);
                foreach($data as $result)
                {
                    // Display the group information
                    print "<tr>";
                    print "<td>" . $result['reminderTitle'] . "</td>";
                    print "<td>" . $result['reminderContent'] . "</td>";
                    print "<td>" . $result['reminderDate'] . " " . $result['reminderTime'] . "</td>";
                    print "<td><a href=\"index.php?mid=600&rid=" . $result['reminderID'] . "&h=1\">View</a></td>";
                    print "</tr>";
                }
                print "</table>";
                print "</p>";
            }
        
    }
}

?>
