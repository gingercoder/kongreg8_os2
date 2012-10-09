<?php

/*
 * Export function and subsiduary tasks
 */


class export extends kongreg8app{
    
    /*
     * Main export routine
     * 
     */
    public function exportData($area, $format){
        $area = db::escapechars($area);
        $format = db::escapechars($format);
        $dateoutput = date('ymdHis');
        
        // Get the data
        switch($area){
            case "members":
                if($format == 'csv'){
                    $headoutput = "Title, Firstname, Middlename, Surname, Email, Phone, Mobile, Address1, Address2, Address3,Postcode, Country, WorkPhone, WorkFax, WorkEmail, WorkWebsite, MemberType\r\n";
                }
                else{
                    $headoutput = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\r\n";
                    $headoutput .= "<kongreg8db version=\"2.0.1\">";
                }
                $sql = "SELECT memberID, prefix, firstname, middlename, surname, email, homephone, mobilephone, address1, address2, address3, postcode, country, workphonenumber, workfaxnumber, workemail, workwebsite, memberStatus FROM churchmembers ORDER BY surname ASC, firstname ASC, middlename ASC";
                $path = "application/export/files/members".$dateoutput.".".$format;
                break;
            case "groups":
                if($format == 'csv'){
                    $headoutput = "Title, Firstname, MiddleName, Surname, Email, Phone, Mobile, Address1, Address2, Address3, Postcode, Country, WorkPhone, WorkFax, WorkEmail, WorkWebsite, MemberType, GroupName, GroupDescription \r\n";
                }
                else{
                    $headoutput = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\r\n";
                    $headoutput .= "<kongreg8db version=\"2.0.1\">";
                }
                $sql = "SELECT churchmembers.memberID, churchmembers.prefix, churchmembers.firstname, churchmembers.middlename, churchmembers.surname, churchmembers.email, 
                        churchmembers.homephone, churchmembers.mobilephone, churchmembers.address1, churchmembers.address2, churchmembers.address3, 
                        churchmembers.postcode, churchmembers.country, churchmembers.workphonenumber, churchmembers.workfaxnumber, churchmembers.workemail, 
                        churchmembers.workwebsite, churchmembers.memberStatus,  
                        groups.groupname, groups.groupdescription 
                        FROM (churchmembers RIGHT JOIN groupmembers on groupmembers.memberID = churchmembers.memberID RIGHT JOIN groups ON groups.groupID=groupmembers.groupID) 
                        GROUP BY churchmembers.memberID 
                        ORDER BY churchmembers.surname ASC, churchmembers.firstname ASC, churchmembers.middlename ASC";
                $path = "application/export/files/groups".$dateoutput.".".$format;
                break;
        }
        
        // Output it into the correct format
        $result = db::returnallrows($sql);
        
        // OPEN THE FILE FOR OUTPUT
        $fp = fopen($path,'w');
        
        fwrite($fp,$headoutput);
        // Loop through each of the entities
        foreach($result as $row){
            // Get the row data and output
            $nextline = "";
            
            if($format == "xml"){
                $nextline .= "<member id='" . $row['memberID'] . "'>";
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
                                ";
                if($area == "groups"){
                    $nextline .= "<GroupName>" . $row['groupname'] . "</GroupName>
                                <GroupDescription>" . $row['groupdescription'] . "</GroupDescription>
                                ";
                }
                $nextline .= "</member>\r\n";
            }
            
            
            
            // IF XML ADD THE CLOSING MEMBER ENTRY
            if($format == "csv"){
                $nextline .= $row['prefix'] . "," . $row['firstname'] . "," . $row['middlename'] . "," . $row['surname'] . "," . $row['email'] . "," . $row['homephone'] . "," . $row['mobilephone'] . "," . $row['address1'] . "," . $row['address2'] . "," . $row['address3'] . "," . $row['postcode'] . "," . $row['country'];
                $nextline .= "," . $row['workphonenumber']. "," . $row['workfaxnumnber']. "," . $row['workemail']. "," . $row['workwebsite']. "," . $row['memberStatus'];
            
                if($area == "groups"){
                    $nextline .= "," . $row['groupname'] . "," . $row['groupdescription'];
                }
                $nextline .= "\r\n";
            }
            // WRITE THE LINE TO THE FILE
            fwrite($fp,$nextline);
        }
        if($format == "xml"){
            fwrite($fp, '</kongreg8db>\n');
        }
        fclose($fp);
        return;
    }
    
    
    /*
     * Function to show all of the files available to download
     * from the system
     */
    public function displayFiles()
    {
        // Specify the location of the stored files
        $path = "application/export/files/";
        
        // Open the folder 
        $dir_handle = @opendir($path); 

        // Loop through the files 
        while ($file = readdir($dir_handle)) { 

        if($file == "." || $file == ".." || $file == "index.php" ) 

            continue; 
            $myfile = $path.$file;
            $checksum = md5($myfile);
            echo "<a href=\"index.php?mid=700&action=download&f=$file&csum=$checksum&area=export\"><span class=\"iconSpanExport\"><img src=\"images/icons/drive-download.png\" alt=\"User Control\" title=\"User Control\"/><br/>$file</a>"; 

        } 
        // Close 
        closedir($dir_handle); 
        
        return;
        
    }
    

    /*
     * Clear files out of the folder
     * 
     */
    public function clearExports()
    {
        $location = "application/export/files/*.*";
        $files = glob($location); 
        foreach($files as $file){
            unlink($file); 
        }
        return;
    }
}

?>
