<?php

/*
 * 
 * MemberControl class extends main kongreg8app class
 * provides all of the member control mechanisms necessary
 * for the operation of the members module
 * 
 */


class memberControl extends kongreg8app{

    
        private static $commitmentdatefixed;
        private static $dateofbirthfixed;
        private static $crbcheckdatefixed;
        private static $datefirstvisitfixed;
        
        /*
        * Load Campus Lists
        * Grab the list of campuses for the church
        * to display on the add form
        * 
        */
        public function getCampusList(){
            $campuses = "";
            $sql = "SELECT * FROM campus ORDER BY campusName ASC";
            $result = db::returnallrows($sql);
            foreach($result as $campus){
                $campuses .= "<option value='".$campus['campusid']."'>".$campus['campusName']."</option>";
            }
            
            return $campuses;

        }





        /*
        * 
        * Main member add validation function
        * Validates the incomming information
        * 
        */
        public function runMyValidation($dateofbirth, $commitmentdate, $crbcheckdate, $firstvisit){

            $gothrough = 1;
            $errorMsg = "";

            // Verify Date format and swap it around to the correct database format

            // DATE OF BIRTH SECTION
            $dateofbirth = db::escapechars(trim($dateofbirth));
            $commitmentdate = db::escapechars(trim($commitmentdate));
            $crbcheckdate = db::escapechars(trim($crbcheckdate));
            $firstvisit = db::escapechars(trim($firstvisit));


            if($dateofbirth !==""){
                    if (!ereg ("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $dateofbirth, $regs)) {
                            $errorMsg .= "<br/>Invalid date format for date of birth: $dateofbirth";
                            $gothrough = 0;
                    }
            }
            // COMMITMENT DATE SECTION
            if($commitmentdate !==""){
                    if (!ereg ("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $commitmentdate, $regs)) {
                            $errorMsg .= "<br/>Invalid date format for commitement date: $commitmentdate";
                            $gothrough = 0;
                    }
            }
            // CRB CHECK DATE
            if($crbcheckdate !==""){
                    if (!ereg ("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $crbcheckdate, $regs)) {
                            $errorMsg .= "<br/>Invalid date format for CRB check date: $crbcheckdate";
                            $gothrough = 0;
                    }
            }

            // FIRST VISIT DATE
            if($firstvisit !==""){
                    if (!ereg ("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $firstvisit, $regs)) {
                            $errorMsg = "<br/>Invalid date format for first visit date: $firstvisit";
                            $gothrough = 0;
                    }
            }

            if($gothrough == 0)
            {
                return $errorMsg;
            }
            else
            {
                return true;
            }

        }

        /*
         * Change from UK to DB date format
         * 
         */
        public function changeUKdate($mydate)
        {
            if(ereg ("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $mydate, $regs))
            {
                return $regs[3]."-".$regs[2]."-".$regs[1];
            }
            else{
                return false;
            }
            
        }
        
        /*
         * Change date from DB to UK Format
         * 
         */
        public function changeDBdate($mydate)
        {
            if(ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $mydate, $regs))
            {
                return $regs[3]."-".$regs[2]."-".$regs[1];
            }
            else{
                return false;
            }
            
        }

        /*
        * 
        * Main member add insert function
        * Creates the population of the db
        * 
        */
        public function runInsert(){

                $errorMsg = "";


                // Check language and set correct one for storing
                if($_POST['mainLanguage'] != "other"){
                        $mainLang = db::escapechars(trim($_POST['mainLanguage']));
                }
                else{
                        $mainLang = db::escapechars(trim($_POST['otherLangOption']));
                }

                // set time and date for sql and log
                $theTime = date('H:i:s');
                $theDate = date('Y-m-d');
                
                
                // Fix the UK date format into the database format
                $commitmentdatefixed = $this->changeUKdate(db::escapechars(trim($_POST['commitmentdate'])));
                if($commitmentdatefixed == 'false'){
                    $commitmentdatefixed = '';
                }
                $dateofbirthfixed = $this->changeUKdate(db::escapechars(trim($_POST['dateofbirth'])));
                if($dateofbirthfixed == 'false'){
                    $dateofbirthfixed = '';
                }
                $crbcheckdatefixed = $this->changeUKdate(db::escapechars(trim($_POST['crbcheckdate'])));
                if($crbcheckdatefixed == 'false'){
                    $crbcheckdatefixed = '';
                }
                $firstvisitfixed = $this->changeUKdate(db::escapechars(trim($_POST['firstvisit'])));
                if($firstvisitfixed == 'false'){
                    $firstvisitfixed = '';
                }
                
                // Fix the option boxes
                if(db::escapechars(trim($_POST['mainLanguage'])) == "other:")
                {
                    $mainLanguage = db::escapechars(trim($_POST['otherLangOption']));
                }
                else{
                    $mainLanguage = db::escapechars(trim($_POST['mainLanguage']));
                }
                
                $sql = "INSERT INTO churchmembers 
                        SET
                        prefix='".db::escapechars(trim($_POST['prefix']))."', 
                        surname='".db::escapechars(trim($_POST['surname']))."', 
                        firstname='".db::escapechars(trim($_POST['firstname']))."', 
                        middlename='".db::escapechars(trim($_POST['middlename']))."', 
                        gender='".db::escapechars(trim($_POST['gender']))."', 
                        dateofbirth='".$dateofbirthfixed."', 
                        maritalstatus='".db::escapechars(trim($_POST['maritalstatus']))."', 
                        firstvisit='".$firstvisitfixed."', 
                        contactmethod='".db::escapechars(trim($_POST['contactmethod']))."', 
                        homephone='".db::escapechars(trim($_POST['phone']))."', 
                        mobilephone='".db::escapechars(trim($_POST['mobile']))."', 
                        email='".db::escapechars(trim($_POST['email']))."', 
                        address1='".db::escapechars(trim($_POST['address1']))."', 
                        address2='".db::escapechars(trim($_POST['address2']))."', 
                        address3='".db::escapechars(trim($_POST['address3']))."', 
                        address4='".db::escapechars(trim($_POST['address4']))."', 
                        postcode='".db::escapechars(trim($_POST['postcode']))."', 
                        country='".db::escapechars(trim($_POST['country']))."', 
                        source='".db::escapechars(trim($_POST['source']))."', 
                        commitmentdate='".$commitmentdatefixed."',
                        crbcheck='".db::escapechars(trim($_POST['crbcheck']))."',
                        crbcheckdate='".$crbcheckdatefixed."', 
                        mainLanguage='".$mainLanguage."', 
                        countryoforigin='".db::escapechars(trim($_POST['countryoforigin']))."', 
                        medicalInfo='".db::escapechars(trim($_POST['medicalInfo']))."',
                        memberStatus='".db::escapechars(trim($_POST['memberStatus']))."', 
                        emailoptin='".db::escapechars(trim($_POST['emailoptin']))."', 
                        employer='".db::escapechars(trim($_POST['employer']))."', 
                        occupation='".db::escapechars(trim($_POST['occupation']))."', 
                        workphonenumber='".db::escapechars(trim($_POST['workphonenumber']))."', 
                        workfaxnumber='".db::escapechars(trim($_POST['workfaxnumber']))."', 
                        workemail='".db::escapechars(trim($_POST['workemail']))."', 
                        workwebsite='".db::escapechars(trim($_POST['workwebsite']))."', 
                        giftaid='".db::escapechars(trim($_POST['giftaid']))."',
                        campusid='".db::escapechars(trim($_POST['campus']))."',
                        lastupdatedate = '$theDate',
                        lastupdatetime = '$theTime'
                        ";

                $result = db::execute($sql);
                if($result){
                        $successMsg .= "<h2>Success!</h2>";

                        $successMsg .= "<p>Your new member, ".db::escapechars(trim($_POST['firstname']))." ".$_POST['surname'].", has been added to the Kongreg8 database</p>";

                        $successMsg .= "<p><a href=\"index.php?mid=201&lastid=".db::getlastid()."\">Click here to add similar member</a></p>";
                        
                        // Log the activity
                        $logType = "Members";
                        $logValue = $_SESSION['Kusername']." added member ".db::escapechars(trim($_POST['surname'])).", " . db::escapechars(trim($_POST['firstname']));
                        $logArea = "Members";				
                        $this->logevent($logType, $logValue, $logArea);
                        
                        return $successMsg;
                }
                else{
                        // Log the failure
                        $logType = "Insert Fail";
                        $logValue = $_SESSION['Kusername']." failed adding member ".db::escapechars($sql);
                        $logArea = "Members";				
                        $this->logerror($logType, $logValue, $logArea);
                        return false;
                }

                


        }

        
        
        
        /*
        * 
        * Main member edit update function
        * Creates the population of the db
        * 
        */
        public function runUpdate(){

                $errorMsg = "";

                $memberid = $_POST['m'];
                if(db::escapechars(trim($memberid)) == "")
                {
                    // if no member id you cannot update so you need to exit
                    
                    // Log the failure
                    $logType = "Update Fail";
                    $logValue = $_SESSION['Kusername']." failed editing member - NO MEMBER ID - Cannot continue";
                    $logArea = "Members";				
                    $this->logerror($logType, $logValue, $logArea);
                    return false;
                }
                

                // Check language and set correct one for storing
                if($_POST['mainLanguage'] != "other"){
                        $mainLang = db::escapechars(trim($_POST['mainLanguage']));
                }
                else{
                        $mainLang = db::escapechars(trim($_POST['otherLangOption']));
                }

                // set time and date for sql and log
                $theTime = date('H:i:s');
                $theDate = date('Y-m-d');
                
                
                // Fix the UK date format into the database format
                $commitmentdatefixed = $this->changeUKdate(db::escapechars(trim($_POST['commitmentdate'])));
                if($commitmentdatefixed == 'false'){
                    $commitmentdatefixed = '';
                }
                $dateofbirthfixed = $this->changeUKdate(db::escapechars(trim($_POST['dateofbirth'])));
                if($dateofbirthfixed == 'false'){
                    $dateofbirthfixed = '';
                }
                $crbcheckdatefixed = $this->changeUKdate(db::escapechars(trim($_POST['crbcheckdate'])));
                if($crbcheckdatefixed == 'false'){
                    $crbcheckdatefixed = '';
                }
                $firstvisitfixed = $this->changeUKdate(db::escapechars(trim($_POST['firstvisit'])));
                if($firstvisitfixed == 'false'){
                    $firstvisitfixed = '';
                }
                
                // Fix the option boxes
                if(db::escapechars(trim($_POST['mainLanguage'])) == "other:")
                {
                    $mainLanguage = db::escapechars(trim($_POST['otherLangOption']));
                }
                else{
                    $mainLanguage = db::escapechars(trim($_POST['mainLanguage']));
                }
                
                $sql = "UPDATE churchmembers 
                        SET
                        prefix='".db::escapechars(trim($_POST['prefix']))."', 
                        surname='".db::escapechars(trim($_POST['surname']))."', 
                        firstname='".db::escapechars(trim($_POST['firstname']))."', 
                        middlename='".db::escapechars(trim($_POST['middlename']))."', 
                        gender='".db::escapechars(trim($_POST['gender']))."', 
                        dateofbirth='".$dateofbirthfixed."', 
                        maritalstatus='".db::escapechars(trim($_POST['maritalstatus']))."', 
                        firstvisit='".$firstvisitfixed."', 
                        contactmethod='".db::escapechars(trim($_POST['contactmethod']))."', 
                        homephone='".db::escapechars(trim($_POST['phone']))."', 
                        mobilephone='".db::escapechars(trim($_POST['mobile']))."', 
                        email='".db::escapechars(trim($_POST['email']))."', 
                        address1='".db::escapechars(trim($_POST['address1']))."', 
                        address2='".db::escapechars(trim($_POST['address2']))."', 
                        address3='".db::escapechars(trim($_POST['address3']))."', 
                        address4='".db::escapechars(trim($_POST['address4']))."', 
                        postcode='".db::escapechars(trim($_POST['postcode']))."', 
                        country='".db::escapechars(trim($_POST['country']))."', 
                        source='".db::escapechars(trim($_POST['source']))."', 
                        commitmentdate='".$commitmentdatefixed."',
                        crbcheck='".db::escapechars(trim($_POST['crbcheck']))."',
                        crbcheckdate='".$crbcheckdatefixed."', 
                        mainLanguage='".$mainLanguage."', 
                        countryoforigin='".db::escapechars(trim($_POST['countryoforigin']))."', 
                        medicalInfo='".db::escapechars(trim($_POST['medicalInfo']))."',
                        memberStatus='".db::escapechars(trim($_POST['memberStatus']))."', 
                        emailoptin='".db::escapechars(trim($_POST['emailoptin']))."', 
                        employer='".db::escapechars(trim($_POST['employer']))."', 
                        occupation='".db::escapechars(trim($_POST['occupation']))."', 
                        workphonenumber='".db::escapechars(trim($_POST['workphonenumber']))."', 
                        workfaxnumber='".db::escapechars(trim($_POST['workfaxnumber']))."', 
                        workemail='".db::escapechars(trim($_POST['workemail']))."', 
                        workwebsite='".db::escapechars(trim($_POST['workwebsite']))."', 
                        giftaid='".db::escapechars(trim($_POST['giftaid']))."',
                        campusid='".db::escapechars(trim($_POST['campus']))."',
                        lastupdatedate = '$theDate',
                        lastupdatetime = '$theTime'
                        WHERE memberid = '$memberid' 
                        LIMIT 1
                        ";

                $result = db::execute($sql);
                if($result){
                        $successMsg .= "<h2>Success!</h2>";

                        $successMsg .= "<p>Your member, ".db::escapechars(trim($_POST['firstname']))." ".$_POST['surname'].", has been edited and saved to the Kongreg8 database</p>";

                        $successMsg .= "<p><a href=\"index.php?mid=201&lastid=".$memberid."\">Click here to add similar member</a></p>";
                        
                        // Log the activity
                        $logType = "Members";
                        $logValue = $_SESSION['Kusername']." edited member ".db::escapechars(trim($_POST['surname'])).", " . db::escapechars(trim($_POST['firstname']));
                        $logArea = "Members";				
                        $this->logevent($logType, $logValue, $logArea);
                        
                        return $successMsg;
                }
                else{
                        
                        // Log the failure
                        $logType = "Update Fail";
                        $logValue = $_SESSION['Kusername']." failed editing member ".db::escapechars($sql);
                        $logArea = "Members";				
                        $this->logerror($logType, $logValue, $logArea);
                        return false;
                }

                


        }
        
        
        
        /*
         * Member Search function - grab a list of members given a specific list of search terms
         * 
         */
        public function getMemberList($firstname, $surname, $address, $phonenum)
        {
            $firstname = db::escapechars(trim($firstname));
            $surname = db::escapechars(trim($surname));
            $address = db::escapechars(trim($address));
            $phonenum = db::escapechars(trim($phonenum));
            
            
            $sql = "SELECT * FROM churchmembers WHERE 1=1 ";
            if($firstname != ""){
                $sql .= "AND firstname LIKE '%$firstname%' ";
            }
            if($surname != ""){
                $sql .= "AND surname LIKE '%$surname%' ";
            }
            if($address != ""){
                $sql .= "AND ((address1 LIKE '%$address%') OR (address2 LIKE '%$address%') OR (address3 LIKE '%$address%') OR (address4 LIKE '%$address%')) ";
            }
            if($phonenum != ""){
                $sql .= "AND phonenum LIKE '%$phonenum%' ";
            }
            
            $sql .= "ORDER BY surname ASC, firstname ASC ";
            
            $result = db::returnallrows($sql);
            return $result;
            
        }
        
        /*
         * Member view information
         * 
         */
        public function viewMember($memberid)
        {
            if($memberid == ""){
                return false;
            }
            else{
                
                $sql = "SELECT * FROM churchmembers WHERE memberID='".db::escapechars($memberid)."'";
                $result = db::returnrow($sql);
                
                return $result;
            }
            
            
        }
        
        
        
        /*
         * Show Family Links
         * Creates a list of family members for a given memberid
         */
        public function showFamilyLinks($memberid)
        {
            if($memberid == ""){
                return false;
            }
            else{
                $memberid = db::escapechars($memberid);
                $sql = "SELECT * FROM familyconstruct WHERE fromID='".$memberid."'";
                $result = db::returnallrows($sql);
                
                $familygrid = "<table class=\"familylink\"><tr><th>Member Name</th><th>Relationship</th><th>&nbsp;</th>";
                foreach($result as $member){
                    $familygrid .= "<tr>";
                    
                    if($member['toID'] == $memberid){
                        $familydata = $this->viewMember($member['fromID']);
                    }
                    else{
                        $familydata = $this->viewMember($member['toID']);
                    }
                    
                    $familygrid .= "<td>" . $familydata['firstname'] . " " . $familydata['surname'] . "</td>";
                    $familygrid .= "<td>".$member['relationship']."</td>
                                    <td><a href=\"index.php?mid=225&m=".$familydata['memberID']."\" class=\"runbutton\">View</a>
                                        <a href=\"index.php?mid=230&m=".$familydata['memberID']."&action=remove\" class=\"delbutton\">Remove</a></td>
                                        </tr>";
                }
                
                $familygrid .= "</table>";
                
                return $familygrid;
            }
            
        }
        
        /*
         * Member removal process
         * 
         */
        public function remove($memberid, $membername='')
        {
            if($memberid == ""){
                return false;
            }
            else{
                // clean the member name up for logging
                $membername = db::escapechars($membername);
                
                // Delete the member
                $sql = "DELETE FROM churchmembers WHERE memberID='".db::escapechars($memberid)."' LIMIT 1";
                $result = db::execute($sql);
                // delete the member from groups
                if($result){
                    $sql = "DELETE FROM groupmembers WHERE memberID='".db::escapechars($memberid)."'";
                    $result = db::execute($sql);
                    // delete the member from family constructs
                    if($result){
                        $sql = "DELETE FROM familyconstruct WHERE fromID='".db::escapechars($memberid)."' OR toID='".db::escapechars($memberid)."'";
                        $result = db::execute($sql);
                        if($result){
                            $logType = "Members";
                            $logValue = $_SESSION['Kusername']." deleted member $membername from the system";
                            $logArea = "Members";				
                            $this->logevent($logType, $logValue, $logArea);
                            return true;
                        }
                        else{
                            // failed family construct removal so log and return
                            $logType = "Delete Fail";
                            $logValue = $_SESSION['Kusername']." failed process (Family Construct) deleting member $membername ".db::escapechars($sql);
                            $logArea = "Members";				
                            $this->logerror($logType, $logValue, $logArea);
                            return "<p class=\"confirm\">Error in removal process - the problem has been logged. Sorry.</p>";
                        }
                    }
                    else{
                        // failed the group members removal so log and return
                        $logType = "Delete Fail";
                        $logValue = $_SESSION['Kusername']." failed process (Group Members) deleting member $membername".db::escapechars($sql);
                        $logArea = "Members";				
                        $this->logerror($logType, $logValue, $logArea);
                        return "<p class=\"confirm\">Error in removal process - the problem has been logged. Sorry.</p>";
                    }
                    
                }
                else{
                    // failed the church members entry so log and return
                    $logType = "Delete Fail";
                    $logValue = $_SESSION['Kusername']." failed process (Church Members) deleting member $membername ".db::escapechars($sql);
                    $logArea = "Members";				
                    $this->logerror($logType, $logValue, $logArea);
                    return "<p class=\"confirm\">Could not delete this member right now - the problem has been logged. Sorry.</p>";
                }
                
            }
            
            
        }
        
       
}
?>
