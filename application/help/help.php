<?php

/*
 * Help System Class for displaying the correct help information
 */


class help extends kongreg8app{
    
    /*
     * Primary Help Retrieval for modules
     * 
     */
    public function displayHelp($helparea, $section)
    {
        $helpArea = db::escapechars($helparea);
        $subsection = db::escapechars($section);
        $sql = "SELECT * FROM helpsystem WHERE helpArea = '$helpArea' AND sectionID = '$subsection'";
        $result = db::returnrow($sql);
        if($result !=""){
            $helpMessage = "<h1>" . $result['helpTitle'] . "</h1><p>" . $result['helpContent'] . "</p>";
            return $helpMessage;
        }
        else{
            return "<h1>Check Main Help</h1><p>Sorry, no inline-help is available for this module area at present. Please check the main help area</p>";
        }
        
    }
    
    /*
     * Function to retrieve ALL help in a section
     * Mainly used for the primary help area.
     * 
     */
    
    public function displayHelpSection($helparea)
    {
        $helpArea = db::escapechars($helparea);
        $sql = "SELECT * FROM helpsystem WHERE helpArea = '$helpArea' ORDER BY sectionID ASC";
        $result = db::returnallrows($sql);
        $helpMessage = "";
        foreach($result as $item){
            $helpMessage .= "<h2>" . $item['helpTitle'] . "</h2><p>" . $item['helpContent'] . "</p>";
        }
        return $helpMessage;
       
    }
    
    
}

?>
