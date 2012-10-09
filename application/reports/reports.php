<?php

/*
 * Reports functions for storage and retrieval of reports, my reports and 
 * primary system reports.
 * 
 */


class reports extends kongreg8app{
    
    /*
     * Pull a list of all the reports you have stored
     * 
     */
    public function viewAllMyReports($userID)
    {
        $userID = db::escapechars($userID);
        $sql = "SELECT * FROM myreports WHERE userID = '$userID' ORDER BY reportName ASC";
        $result = db::returnallrows($sql);
        if(db::getnumrows($sql) > 0)
        {
            print "<table class=\"myreports\"><tr><th>Report Name</th><th>Description</th><th>Date Created</th><th>Action</th></tr>";
            foreach($result as $report)
            {
                print "<tr>
                        <td>". $report['reportName'] ."</td><td>". $report['reportDescription'] ."</td><td>". $report['dateCreated'] ."</td>
                        <td><a href=\"index.php?mid=506&r=".$report['reportid']."\">Run Report</a> / 
                        <a href=\"index.php?mid=505&r=".$report['reportid']."&rm=true\">Delete Report</a> 
                        </td>
                        </tr>";
            }
            print "</table>";
        }
        else{
            print "<p>No reports stored at present.</p>";
        }
        return true;
    }
    
    /*
     * Pull the report you specify from myReports
     * Then take the information from this and run the 
     * report based on the table values specified
     * 
     */
    public function viewMyReport($reportID)
    {
        $reportID = db::escapechars($reportID);
        
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

        // first of all get the information about the report and what they want to search for and display
        $sql = "SELECT * FROM myreports WHERE reportid='$reportID'";
        $result = db::returnrow($sql);
        $tableName = $result['selectFrom'];
        
        // construct the new query based on the report settings
        $sql = "SELECT * FROM ".db::escapechars($result['selectFrom'])." WHERE ".db::escapechars($result['whereA'])." "
                  . $result['compareA'] . " '".db::escapechars($result['valueA'])."' ";
                if(($result['whereB'] !="")&&($valueB !="")){
                    $sql .= " AND ".db::escapchars($result['whereB'])." " . $result['compareB'] . " '".db::escapechars($result['valueB'])."'";
                }
                if($campuslock !=""){
                    if(($tableName == 'churchmembers')||($tableName == 'groups')){
                        $sql .= " AND campusid='".db::escapechars($campuslock)."'";
                    }
                }
        $result = db::returnallrows($sql);
        
        if(db::getnumrows($sql) > 0){
            
            // display the output of this report.
            print "<table>";
            // get the column names
            $columnNames = $this->getColumnNames($tableName);
            
            print "<tr>";
            for($i=0; $i<count($columnNames); $i++){
                
                print "<th>".$columnNames[$i]."</th>";
                
            }
            print "</tr>";
            

            for($i=0; $i<count($result); $i++){
                print "<tr>";
                foreach($result[$i] as $item){
                    print "<td>".$item."</td>";
                }
                print "</tr>";
            }
            
            print "</table>";
        }
        return;
    }
    
    
    /*
     * Store the new report created by the user
     * 
     */
    public function createReport($reportname, $reportdescription, $tableName, $whereA, $valueA, $whereB, $valueB, $compareA, $compareB, $compareBoth)
    {
        $reportname = db::escapechars($reportname);
        $reportdescription = db::escapechars($reportdescription);
        $tableName = db::escapechars($tableName);
        $whereA = db::escapechars($whereA);
        $valueA = db::escapechars($valueA);
        $whereB = db::escapechars($whereB);
        $valueB = db::escapechars($valueB);
        $compareA = db::escapechars($compareA);
        $compareB = db::escapechars($compareB);
        $compareBoth = db::escapechars($compareBoth);
        $userID = $this->usernametoid($_SESSION['Kusername']);
        
        $sql = "INSERT INTO myreports SET
                userID = '$userID',
                reportName = '$reportname',
                reportDescription = '$reportdescription',
                selectFrom = '$tableName',
                whereA = '$whereA',
                valueA = '$valueA',
                whereB = '$whereB',
                valueB = '$whereB',
                compareA = '$compareA',
                compareB = '$compareB',
                compareBoth = '$compareBoth',
                dateCreated = NOW()
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
     * 
     * Report removal process
     * 
     */
    public function removeReport($reportID)
    {
        $reportID = db::escapechars($reportID);
        $sql = "DELETE FROM myreports WHERE reportID = '$reportID' LIMIT 1";
        $result = db::execute($sql);
        if($result){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    
    /*
     * 
     * Get column names for the my reports system
     * 
     */
    public function getColumnNames($tableName)
    {
        $tableName = db::escapechars($tableName);
        $sql = "SHOW COLUMNS FROM $tableName";
        $result = db::returnallrows($sql);
        $counter = 0;
        $returnArray = array();
        foreach($result as $column){
            
            $returnArray[$counter] =  $column['Field'];
            $counter++;
        }
        return $returnArray;
        
    }
    
    /*
     * Authentication Statistics display
     * 
     */
    public function viewAuthStats()
    {
        
        $today = date('Y-m-d');
        $lastweek = date('Y-m-d', strtotime("-1 week"));
        $minusone = date('Y-m-d', strtotime("-1 day"));
        $minustwo = date('Y-m-d', strtotime("-2 days"));
        $minusthree = date('Y-m-d', strtotime("-3 days"));
        $minusfour = date('Y-m-d', strtotime("-4 days"));
        $minusfive = date('Y-m-d', strtotime("-5 days"));
        $minussix = date('Y-m-d', strtotime("-6 days"));
        
        $counter_today = 0;
        $counter_minusone = 0;
        $counter_minustwo = 0;
        $counter_minusthree = 0;
        $counter_minusfour = 0;
        $counter_minusfive = 0;
        $counter_minussix = 0;
        $counter_lastweek = 0;
        
        $min = 0;
        $max = 0;
        
        // Failed auth figures
        $sql = "SELECT * FROM klog WHERE logValue LIKE '%Failed sign in%' AND logDate BETWEEN '$lastweek' AND '$today' ORDER BY logDate ASC";
        $result = db::returnallrows($sql);
        if(db::getnumrows($sql) > 0){
            // work out the failed authentication set
            foreach($result as $failure){
                switch($failure['logDate']){
                    case $today:
                        $counter_today++;
                        break;
                    case $minusone:
                        $counter_minusone++;
                        break;
                    case $minustwo:
                        $counter_minustwo++;
                        break;
                    case $minusthree:
                        $counter_minusthree++;
                        break;
                    case $minusfour:
                        $counter_minusfour++;
                        break;
                    case $minusfive:
                        $counter_minusfive++;
                        break;
                    case $minussix:
                        $counter_minussix++;
                        break;
                    case $lastweek:
                        $counter_lastweek++;
                        break;
                }
            }
            $max = max(array($counter_lastweek, $counter_minusfive, $counter_minusfour, $counter_minusone, $counter_minussix, $counter_minusthree, $counter_minustwo, $counter_today));
            $min = min(array($counter_lastweek, $counter_minusfive, $counter_minusfour, $counter_minusone, $counter_minussix, $counter_minusthree, $counter_minustwo, $counter_today));
            print "<h2>Failed authentication over last 7 days</h2>";
            print "<p><img src=\"http://chart.apis.google.com/chart?cht=lc&amp;chd=t:$counter_lastweek,$counter_minussix,$counter_minusfive,$counter_minusfour,$counter_minusthree,$counter_minustwo,$counter_minusone,$counter_today&amp;chs=420x100&amp;chco=990099;&amp;chds=$min,$max\" title=\"Authentication past seven days\" alt=\"Authentication past seven days\" /> </p>";

            
        }
        else{
            // no rows
            print "<p>No failed authentication discovered in the past 7 days</p>";
        }
        
        // Successful auth figures
        
        
        $counter_today = 0;
        $counter_minusone = 0;
        $counter_minustwo = 0;
        $counter_minusthree = 0;
        $counter_minusfour = 0;
        $counter_minusfive = 0;
        $counter_minussix = 0;
        $counter_lastweek = 0;
        
        // Failed auth figures
        $sql = "SELECT * FROM klog WHERE logValue LIKE '%Successful sign in%' AND logDate BETWEEN '$lastweek' AND '$today' ORDER BY logDate ASC";
        $result = db::returnallrows($sql);
        $max = 0;
        $min = 0;
        
        if(db::getnumrows($sql) > 0){
            // work out the failed authentication set
            foreach($result as $failure){
                switch($failure['logDate']){
                    case $today:
                        $counter_today++;
                        break;
                    case $minusone:
                        $counter_minusone++;
                        break;
                    case $minustwo:
                        $counter_minustwo++;
                        break;
                    case $minusthree:
                        $counter_minusthree++;
                        break;
                    case $minusfour:
                        $counter_minusfour++;
                        break;
                    case $minusfive:
                        $counter_minusfive++;
                        break;
                    case $minussix:
                        $counter_minussix++;
                        break;
                    case $lastweek:
                        $counter_lastweek++;
                        break;
                }
                
            }
            $max = max(array($counter_lastweek, $counter_minusfive, $counter_minusfour, $counter_minusone, $counter_minussix, $counter_minusthree, $counter_minustwo, $counter_today));
            $min = min(array($counter_lastweek, $counter_minusfive, $counter_minusfour, $counter_minusone, $counter_minussix, $counter_minusthree, $counter_minustwo, $counter_today));
            
            print "<h2>Successful authentication over last 7 days</h2>";
            print "<p><img src=\"http://chart.apis.google.com/chart?cht=lc&amp;chd=t:$counter_lastweek,$counter_minussix,$counter_minusfive,$counter_minusfour,$counter_minusthree,$counter_minustwo,$counter_minusone,$counter_today&amp;chs=420x100&amp;chco=990099;&amp;chds=$min,$max\" title=\"Authentication past seven days\" alt=\"Authentication past seven days\" /> </p>";

            
        }
        else{
            // no rows
            print "<p>No successful authentication discovered in the past 7 days</p>";
        }
        
        
        return;
    }
    
    
    /*
     * ========================    Pre-defined report section ==========================>
     * ========================    Pre-defined report section ==========================>
     * ========================    Pre-defined report section ==========================>
     * 
     */
    
    
    /*
     * Primary launch function which loads the correct report
     */
    public function launchPredefined($reportid)
    {
        $reportid = db::escapechars($reportid);
        
        if($reportid ==""){
            // no report to load so cancel
            return false;
        }
        switch ($reportid){
            
            case "001":
                $this->predefined001();
                break;
            case "002":
                $this->predefined002();
                break;
            case "003":
                $this->predefined003();
                break;
            case "004":
                $this->predefined004();
                break;
            case "005":
                $this->predefined005();
                break;
            case "006":
                $this->predefined006();
                break;
            case "007":
                $this->predefined007();
                break;
            case "008":
                $this->predefined008();
                break;
            case "009":
                $this->predefined009();
                break;
        }
        
        return true;
        
    }
    
    /*
     * 001 - All members alphabetically
     */
    private function predefined001()
    {
        print "<table class=\reportTable\">";
        print "<tr>
                <th>Surname</th>
                <th>Firstname</th>
                <th>Address 1</th>
                <th>Address 2</th>
                <th>Postcode</th>
                <th>Country</th>
                <th>Home Phone</th>
                <th>Mobile</th>
                <th>Email</th>
               </tr>
                ";
        
        $sql = "SELECT surname, firstname, address1, address2, postcode, country, homephone, mobilephone, email FROM churchmembers ORDER BY surname ASC, firstname ASC";
        $result = db::returnallrows($sql);
        foreach($result as $member){
            print "<tr>";
            print "<td>".$member['surname']."</td>";
            print "<td>".$member['firstname']."</td>";
            print "<td>".$member['address1']."</td>";
            print "<td>".$member['address2']."</td>";
            print "<td>".$member['postcode']."</td>";
            print "<td>".$member['country']."</td>";
            print "<td>".$member['homephone']."</td>";
            print "<td>".$member['mobilephone']."</td>";
            print "<td>".$member['email']."</td>";
            print "</tr>";
        }
        print "</table>";
    }
    
    
    /*
     * 002 -Members per campus alphabetically
     */
    private function predefined002()
    {
        
        $outersql = "SELECT * FROM campus ORDER BY campusName ASC";
        $outer = db::returnallrows($outersql);
        foreach($outer as $campus){
            print "<h2>".$campus['campusName']."</h2>";
            print "<table class=\reportTable\">";
            print "<tr>
                    <th>Surname</th>
                    <th>Firstname</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>Postcode</th>
                    <th>Country</th>
                    <th>Home Phone</th>
                    <th>Mobile</th>
                    <th>Email</th>
                </tr>
                    ";

            $sql = "SELECT surname, firstname, address1, address2, postcode, country, homephone, mobilephone, email FROM churchmembers WHERE campusid = '".$campus['campusid']."' ORDER BY surname ASC, firstname ASC";
            $result = db::returnallrows($sql);
            foreach($result as $member){
                print "<tr>";
                print "<td>".$member['surname']."</td>";
                print "<td>".$member['firstname']."</td>";
                print "<td>".$member['address1']."</td>";
                print "<td>".$member['address2']."</td>";
                print "<td>".$member['postcode']."</td>";
                print "<td>".$member['country']."</td>";
                print "<td>".$member['homephone']."</td>";
                print "<td>".$member['mobilephone']."</td>";
                print "<td>".$member['email']."</td>";
                print "</tr>";
            }
            print "</table>";
        }
    }
    
    /*
     * 003 - Most recent changes
     */
    
     private function predefined003()
    {
        
        
            print "<h2>Changes made this week to members information</h2>";
            print "<table class=\reportTable\">";
            print "<tr>
                    <th>Surname</th>
                    <th>Firstname</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>Postcode</th>
                    <th>Country</th>
                    <th>Home Phone</th>
                    <th>Mobile</th>
                    <th>Email</th>
                </tr>
                    ";

            $sql = "SELECT surname, firstname, address1, address2, postcode, country, homephone, mobilephone, email FROM churchmembers WHERE lastupdatedate >= '" . date( 'Y-m-d' , strtotime( 'today -7 days' ) ) . "' ORDER BY surname ASC, firstname ASC";
            $result = db::returnallrows($sql);
            foreach($result as $member){
                print "<tr>";
                print "<td>".$member['surname']."</td>";
                print "<td>".$member['firstname']."</td>";
                print "<td>".$member['address1']."</td>";
                print "<td>".$member['address2']."</td>";
                print "<td>".$member['postcode']."</td>";
                print "<td>".$member['country']."</td>";
                print "<td>".$member['homephone']."</td>";
                print "<td>".$member['mobilephone']."</td>";
                print "<td>".$member['email']."</td>";
                print "</tr>";
            }
            print "</table>";
     }
    
     
     /*
     * 004 - Members without a mobile phone or email address
     */
    
     private function predefined004()
    {
        
        
            print "<h2>Members without Mobile Phone Number</h2>";
            print "<table class=\reportTable\">";
            print "<tr>
                    <th>Surname</th>
                    <th>Firstname</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>Postcode</th>
                    <th>Country</th>
                    <th>Home Phone</th>
                    <th>Email</th>
                </tr>
                    ";

            $sql = "SELECT surname, firstname, address1, address2, postcode, country, homephone, mobilephone, email FROM churchmembers WHERE mobilephone = '' ORDER BY surname ASC, firstname ASC";
            $result = db::returnallrows($sql);
            foreach($result as $member){
                print "<tr>";
                print "<td>".$member['surname']."</td>";
                print "<td>".$member['firstname']."</td>";
                print "<td>".$member['address1']."</td>";
                print "<td>".$member['address2']."</td>";
                print "<td>".$member['postcode']."</td>";
                print "<td>".$member['country']."</td>";
                print "<td>".$member['homephone']."</td>";
                print "<td>".$member['email']."</td>";
                print "</tr>";
            }
            print "</table>";
            
            print "<hr/>";
            
            print "<h2>Members without Email Address</h2>";
            print "<table class=\reportTable\">";
            print "<tr>
                    <th>Surname</th>
                    <th>Firstname</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>Postcode</th>
                    <th>Country</th>
                    <th>Home Phone</th>
                    <th>Mobile</th>
                </tr>
                    ";

            $sql = "SELECT surname, firstname, address1, address2, postcode, country, homephone, mobilephone, email FROM churchmembers WHERE email = '' ORDER BY surname ASC, firstname ASC";
            $result = db::returnallrows($sql);
            foreach($result as $member){
                print "<tr>";
                print "<td>".$member['surname']."</td>";
                print "<td>".$member['firstname']."</td>";
                print "<td>".$member['address1']."</td>";
                print "<td>".$member['address2']."</td>";
                print "<td>".$member['postcode']."</td>";
                print "<td>".$member['country']."</td>";
                print "<td>".$member['homephone']."</td>";
                print "<td>".$member['mobilephone']."</td>";
                print "</tr>";
            }
            print "</table>";
            
     }
     
     
     
     /*
     * 005 - Monthly visitor breakdown for this past year
     */
    
     private function predefined005()
    {
        
        
            print "<h2>Monthly visitor breakdown for past 12 months</h2>";
            
            
            for($i = 1; $i <= 12; $i++){
                if($i < 10){
                    $month_field = "0".$i;
                }
                else{
                    $month_field = $i;
                }
                    $strtimeconstruct = date('Y'). '-' . $month_field . '-01 01:01:01';
                    $monthReal = date( 'F' , strtotime($strtimeconstruct) );
                    print "<h3>".$monthReal."</h3>";
                    print "<table class=\reportTable\">";
                    print "<tr>
                    <th>First Visit</th>
                    <th>Surname</th>
                    <th>Firstname</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>Postcode</th>
                    <th>Country</th>
                    <th>Home Phone</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    </tr>
                    ";

                $sql = "SELECT surname, firstname, address1, address2, postcode, country, homephone, mobilephone, email, firstvisit FROM churchmembers WHERE firstvisit >= '";
                if(date('m') < $i){
                    $sql .= date( 'Y' , strtotime( 'today -1 year' ) ) . "-" . $month_field ."-01' GROUP BY firstvisit ";
                }
                else{
                    $sql .= date( 'Y' ) . "-" . $month_field ."-01' GROUP BY firstvisit ";
                }
                
                $result = db::returnallrows($sql);
                foreach($result as $member){
                    print "<tr>";
                    print "<td>".$member['firstvisit']."</td>";
                    print "<td>".$member['surname']."</td>";
                    print "<td>".$member['firstname']."</td>";
                    print "<td>".$member['address1']."</td>";
                    print "<td>".$member['address2']."</td>";
                    print "<td>".$member['postcode']."</td>";
                    print "<td>".$member['country']."</td>";
                    print "<td>".$member['homephone']."</td>";
                    print "<td>".$member['mobilephone']."</td>";
                    print "<td>".$member['email']."</td>";
                    print "</tr>";
                    
                    
                }
                print "</table>";
            }
            
     }
     
     
     
     /*
     * 006 - Members with a CRB check in or out of date
     */
    
     private function predefined006()
    {
        
        
            print "<h2>Members with a CRB check</h2>";
            print "<table class=\reportTable\">";
            print "<tr>
                    <th>Surname</th>
                    <th>Firstname</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>Postcode</th>
                    <th>Country</th>
                    <th>Home Phone</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>CRB Date</th>
                   </tr>
                    ";

            $sql = "SELECT surname, firstname, address1, address2, postcode, country, homephone, mobilephone, email, crbcheck, crbcheckdate FROM churchmembers WHERE ( crbcheckdate !='' AND crbcheckdate !='0000-00-00' ) ORDER BY surname ASC, firstname ASC";
            $result = db::returnallrows($sql);
            foreach($result as $member){
                if($member['crbcheck'] == "yes"){
                    print "<tr class=\"okayrow\">";
                }
                else{
                    print "<tr>";
                }
                print "<td>".$member['surname']."</td>";
                print "<td>".$member['firstname']."</td>";
                print "<td>".$member['address1']."</td>";
                print "<td>".$member['address2']."</td>";
                print "<td>".$member['postcode']."</td>";
                print "<td>".$member['country']."</td>";
                print "<td>".$member['homephone']."</td>";
                print "<td>".$member['mobilephone']."</td>";
                print "<td>".$member['email']."</td>";
                print "<td>".$member['crbcheckdate']."</td>";
                print "</tr>";
            }
            print "</table>";
     }
     
    
     /*
     * 007 - Non members grouped into different types
     */
    
     private function predefined007()
    {
        
        
            print "<h2>Non-Members</h2>";
            print "<table class=\reportTable\">";
            print "<tr>
                    <th>Surname</th>
                    <th>Firstname</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>Postcode</th>
                    <th>Country</th>
                    <th>Home Phone</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Type</th>
                   </tr>
                    ";

            $sql = "SELECT surname, firstname, address1, address2, postcode, country, homephone, mobilephone, email, memberStatus FROM churchmembers WHERE memberStatus !='active' ORDER BY memberStatus ASC, surname ASC, firstname ASC";
            $result = db::returnallrows($sql);
            foreach($result as $member){
                print "<tr>";
                print "<td>".$member['surname']."</td>";
                print "<td>".$member['firstname']."</td>";
                print "<td>".$member['address1']."</td>";
                print "<td>".$member['address2']."</td>";
                print "<td>".$member['postcode']."</td>";
                print "<td>".$member['country']."</td>";
                print "<td>".$member['homephone']."</td>";
                print "<td>".$member['mobilephone']."</td>";
                print "<td>".$member['email']."</td>";
                print "<td>".$member['memberStatus']."</td>";
                print "</tr>";
            }
            print "</table>";
     }
    
     
     
     /*
     * 008 - Monthly Birthday Breakdown
     */
    
     private function predefined008()
    {
        
        
            print "<h2>Monthly birthday breakdown</h2>";
            
            
            for($i = 1; $i <= 12; $i++){
                if($i < 10){
                    $month_field = "0".$i;
                }
                else{
                    $month_field = $i;
                }
                    $strtimeconstruct = date('Y'). '-' . $month_field . '-01 01:01:01';
                    $monthReal = date( 'F' , strtotime($strtimeconstruct) );
                    print "<h3>".$monthReal."</h3>";
                    print "<table class=\reportTable\">";
                    print "<tr>
                    <th>Surname</th>
                    <th>Firstname</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>Postcode</th>
                    <th>Country</th>
                    <th>Home Phone</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    </tr>
                    ";

                $sql = "SELECT surname, firstname, address1, address2, postcode, country, homephone, mobilephone, email, dateofbirth FROM churchmembers WHERE dateofbirth LIKE '%-".$month_field."-%' ORDER BY dateofbirth ASC, surname ASC, firstname ASC";
                
                
                $result = db::returnallrows($sql);
                foreach($result as $member){
                    print "<tr>";
                    print "<td>".$member['surname']."</td>";
                    print "<td>".$member['firstname']."</td>";
                    print "<td>".$member['address1']."</td>";
                    print "<td>".$member['address2']."</td>";
                    print "<td>".$member['postcode']."</td>";
                    print "<td>".$member['country']."</td>";
                    print "<td>".$member['homephone']."</td>";
                    print "<td>".$member['mobilephone']."</td>";
                    print "<td>".$member['email']."</td>";
                    print "<td>".$member['dateofbirth']."</td>";
                    print "</tr>";
                    
                    
                }
                print "</table>";
            }
            
     }
     
     
     /*
     * 009 - Group Lists Alphabetically
     */
    
     private function predefined009()
    {
        
         $outersql = "SELECT * FROM groups  ORDER BY groupname ASC";
         $outerresult = db::returnallrows($outersql);
         foreach($outerresult as $group){
             
             $sql = "SELECT * FROM (groupmembers RIGHT JOIN churchmembers on groupmembers.memberID = churchmembers.memberID) WHERE groupID = '" . $group['groupID'] . "' ORDER BY churchmembers.surname ASC, churchmembers.firstname ASC";
             print "<h3>".$group['groupname']."</h3>";
             print "<p>".$group['groupdescription']."</p>";
             print "<table class=\"reportTable\">
                        <tr>
                            <th>Surname</th>
                            <th>Firstname</th>
                            <th>Email</th>
                            <th>Mobile</th>
                        </tr>
                    ";
             $result = db::returnallrows($sql);
             foreach($result as $groupmember){
                 if($group['groupleader'] == $groupmember['memberID']){
                 
                     print "<tr class=\"okayrow\">";
                 }
                 else{
                     print "<tr>";
                 }
                 
                 print "
                            <td>" . $groupmember['surname'] . "</td>
                            <td>" . $groupmember['firstname'] . "</td>
                            <td>" . $groupmember['email'] . "</td>
                            <td>" . $groupmember['mobilephone'] . "</td>
                        </tr>
                        ";
                 
             }
             print "</table>";
             
             
         }
         
     }
     
     
    /*
     * <========================    Pre-defined report section ==========================
     * <========================    Pre-defined report section ==========================
     * <========================    Pre-defined report section ==========================
     * 
     */
    
    
    
}

?>
