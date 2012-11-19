<?php

/*
 * Google Graphing API Links and generated output
 */
?>
<!--Load the AJAX API-->
            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <script type="text/javascript">

            // Load the Visualization API and the piechart package.
            google.load('visualization', '1.0', {'packages':['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.setOnLoadCallback(drawGroupBarChart);
            google.setOnLoadCallback(drawGenderPieChart);

           <?php 
                print $objStats->groupBarChart(); 
                print $objStats->genderPieChart();
                
           ?>
            </script>