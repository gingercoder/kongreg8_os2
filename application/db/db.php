<?php

/**
 * Primary database control class for the application
 *
 * @author rick
 */
abstract class db {
    
        
    private static $boolConnected;
    
    function dbconnect($dbhost, $dbuser, $dbpass, $dbname){
        // Connect to the database
        if(!self::$boolConnected)
        {
                $conn= mysql_connect($dbhost, $dbuser, $dbpass);
                if($conn === FALSE)
                {
                    include('failcodes/dbconnect.html');
                    //die ("Cannot connect to MySql database control. Please contact your system administrator or try again in 2 minutes.");
                    die();
                }
                else{
                    $db = mysql_select_db($dbname, $conn);
                    if($db === FALSE)
                    {
                        include('failcodes/dbconnect.html');
                        //die ("Cannot connect to your customer database.<br />Please try again and contact your system administrator if problems persist..");
                        die();
                    }
                }
                $boolConnected = true;
        }
        
        
        
    }

    
    
    // Function to run the SQL passed to you from the code
	public function execute($sql){
		
                // Run the requested SQL
		$result = mysql_query($sql);
		if($result)
                {
                    return true;
		}
		else
                {
                    return false;
		}
	}
	
	// Function to return a single row from SQL
	public function returnrow($sql){
		
                $sql .= " LIMIT 1";
		$result = mysql_query($sql);
                
		if($result)
                {
                    return mysql_fetch_array($result);
		}
		else
                {
                    return false;	
		}	
	}
	
        
	public function returnallrows($sql){
		// Get all rows from the database given the SQL from the application
                $result = mysql_query($sql);
		$resultset = array();
                
                while($arow = mysql_fetch_assoc($result)){
                    $resultset[] = $arow;
                }
                
		return $resultset;
		
	}


        public function escapechars($var){
            // Escape any nasty code in the user input text
            return mysql_real_escape_string(trim($var));
            
        }

        public function getnumrows($sql){
            // Get the number of rows for a SQL query
            $result = mysql_query($sql);
            $numrows = mysql_numrows($result);
            return $numrows;
        }
        
        
        public function getlastid(){
            // Get the last inserted SQL ID
            $id = mysql_insert_id();
            return $id;
        }

        public function disconnect(){
            mysql_disconnect;
        }
    
    
}

?>
