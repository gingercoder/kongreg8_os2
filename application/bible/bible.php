<?php

/*
 * Bible search and display system
 * Based on NKJ version
 */


class bible extends kongreg8app{
    
    /*
     * Function to get the book/chapter/verse from the db
     * 
     */
    
    public function getVerse($book, $chapter, $verse)
    {
    
        // Grab a verse
        $sql = "SELECT * FROM bible_nkj WHERE 1=1";
        if($book != ""){
            $sql .= " AND booknumber='$book'";
        }
        if($chapter !=""){
            $sql .= " AND chapter='$chapter'";
        }
        if(($verse != "") && ($verse != "xxx")){
            $sql .= " AND verse='$verse'";
        }
        $sql .= " ORDER BY chapter ASC, verse ASC";
        
        $result = db::returnrow($sql);
        
        $returnverse = "<h2>".$result['bookname']." : chapter ".$result['chapter']."</h2>";
        
        if(($verse != "") && ($verse != "xxx")){
            $returnverse .= "<p>[".$result['verse']."]"." ".$result['passage']."</p>";
        }
        else{
            $sql = "SELECT DISTINCT verse FROM bible_nkj WHERE booknumber = '$book' AND chapter = '$chapter'";
            $numverses = db::getnumrows($sql);
            $counter = 1;
            
            while($counter <= $numverses){
                $sql = "SELECT * FROM bible_nkj WHERE booknumber = '$book' AND chapter = '$chapter' AND verse='$counter'";
                $result = db::returnrow($sql);
                $returnverse .= "<p><span class=\"verseNumber\">[".$result['verse']."]</span>"." ".$result['passage']."</p>";
                $counter++;
            }
        }
        $returnverse .= "<br/>";
        return $returnverse;
    }
    
    
    /*
     * Get the list of books for the drop down selector
     * 
     */
    
    public function getBookList()
    {
        $sql = "SELECT DISTINCT bookname FROM bible_nkj";
        $result = db::returnallrows($sql);
        $list = "";
        foreach($result as $book){
            $sql2 = "SELECT booknumber FROM bible_nkj WHERE bookname='".$book['bookname']."'";
            $result2 = db::returnrow($sql2);
            
            $list .= "<option value=\"".$result2['booknumber']."\">".$book['bookname']."</option>";
            
        }
        return $list;
    }
    
}

?>
