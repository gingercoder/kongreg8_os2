<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class backup extends kongreg8app{
    
    /*
     * Main Backup function
     * 
     */
    public function backupDatabase($backupbible='')
    {
        // Check if backing up bible as well
        if(db::escapechars($backupbible) == true){
            $allfiles == true;
        }
        else{
            $allfiles == false;
        }
        //save file
        $path = 'application/backup/files/backup-'.date('YmdHis').'.sql';
        $fp = fopen($path,'w');

        // populate a list of all the tables
        
        $tables = db::returnallrows('SHOW TABLES');
        // iterate through each table
        foreach($tables as $table)
        {
            foreach($table as $item){
                if(($item == 'nkjv_bible')&&($allfiles == false)){
                    $return = '-- OMMITTING '.$item.';\n\n';
                }
                else{
                    $return = '-- DUMPING CONSTRUCT AND DATA FOR '.$item.';\n\n';

                    $sql = "SHOW CREATE TABLE $item";


                    $result = db::returnallrows($sql);
                    // Dump the generate SQL
                    foreach($result as $entry){
                        foreach($entry as $entryarray){
                            $return .= $entryarray . ";\n\n";
                        }
                    }

                    // Dump the data for the table
                    $sql = "SELECT * FROM $item";
                    $data = db::returnallrows($sql);
                    $fieldsql = 'SHOW COLUMNS FROM '.$item;
                    $num_fields = db::getnumrows($fieldsql);

                    foreach($data as $output){
                        $return .= "INSERT INTO $item VALUES(";

                        $i = 1;
                        foreach($output as $blob){

                            $blob = addslashes($blob);
                            $blob = ereg_replace("\n","\\n",$blob);

                            $return .= "$blob";
                            if($i < $num_fields){
                                $return .= ",";
                            }

                            $i++;
                        }
                        $return .= ");\n\n";

                    }
                }
                fwrite($fp,$return);
                
            }
        }
        
        
        
        fclose($fp);
        
        return true;
    }
    
    /*
     * Function to show all of the files available to download
     * from the system
     */
    public function displayFiles()
    {
        // Specify the location of the stored files
        $path = "application/backup/files/";
        
        // Open the folder 
        $dir_handle = @opendir($path); 
        $numfiles = 0;
        // Loop through the files 
        while ($file = readdir($dir_handle)) { 

        if($file == "." || $file == ".." || $file == "index.php" ) 

            continue; 
            $myfile = $path.$file;
            $checksum = md5($myfile);
            print "<a href=\"index.php?mid=720&action=download&f=$file&csum=$checksum&area=backup\"><span class=\"iconSpanBackup\"><img src=\"images/icons/database.png\" alt=\"User Control\" title=\"User Control\"/><br/>$file</span></a>"; 
            $numfiles++;
        } 
        // Close 
        closedir($dir_handle); 
        print "<span class=\"clearSpan\"></span><p>Found (".$numfiles.") backup files</p>";
        return;
        
    }
    

    /*
     * Clear files out of the folder
     * 
     */
    public function clearBackups()
    {
        $location = "application/backup/files/*.*";
        $files = glob($location); 
        foreach($files as $file){
            unlink($file); 
        }
        return;
    }
    
    
    
}
?>
