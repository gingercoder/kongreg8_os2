<?php

/*
 * Search Results Page
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}

?>
<div class="contentBox">
    <h1>Search</h1>
    <p>
        Currently searching for : <?php echo $searchterm; ?>
    </p>
    
    <?php
    if($searchterm !=""){
        $mysearch->getresults($searchterm);
    }
    else{
        print "<p><strong>Searching for a blank term is not permitted due to the possibility that it may flood your browser session 
            which could lock or crash your computer system.</strong></p>
            <p>Please consider searching for information using a minumum of two characters to reduce the impact on your loading time.</p>";
    }
    ?>

    
</div>