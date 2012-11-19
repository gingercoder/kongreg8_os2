<?php

/*
 * Statistics Functions 
 */


class stats extends kongreg8app{
        
        /*
         * WHAT ARE WE STORING? MEMBERS NON MEMBERS PERCENTAGES
         * 
         */
        public function storingPieChart()
        {
            
            $memberNonMemberStats = "";

            $members = 0;
            $nonMembers = 0;
            $contact = 0;
            $visitors = 0;
            $archivedMembers = 0;

            $sql = "SELECT * FROM churchmembers WHERE memberStatus='active'";
            $members = db::getnumrows($sql);

            $sql = "SELECT * FROM churchmembers WHERE memberStatus='nonmember'";
            $nonMembers = db::getnumrows($sql);

            $sql = "SELECT * FROM churchmembers WHERE memberStatus='contact'";
            $contact = db::getnumrows($sql);

            $sql = "SELECT * FROM churchmembers WHERE memberStatus='visitor'";
            $visitors = db::getnumrows($sql);

            $sql = "SELECT * FROM churchmembers WHERE memberStatus='archived'";
            $archivedMembers = db::getnumrows($sql);

            $totalMembers = 0;
            $totalMembers = $members + $nonMembers + $contact + $visitors + $archivedMembers;

            if($totalMembers != 0){
                    $membersPercentage = ceil(($members/$totalMembers)*100);
                    $nonMembersPercentage = ceil(($nonMembers/$totalMembers)*100);
                    $contactPercentage = ceil(($contact/$totalMembers)*100);
                    $visitorsPercentage = ceil(($visitors/$totalMembers)*100);
                    $archivedMembersPercentage = ceil(($archivedMembers/$totalMembers)*100);

                    $memberNonMemberStats .= "<img src=\"http://chart.apis.google.com/chart?cht=p&amp;chd=t:$membersPercentage,$nonMembersPercentage,$contactPercentage,$visitorsPercentage,$archivedMembersPercentage&amp;chs=350x100&amp;chl=Members($members)|Non-Members($nonMembers)|Contacts($contact)|Visitors($visitors)|Archived($archivedMembers)&amp;chf=bg,s,efefef00&amp;chco=990099\" title=\"Storage View\" alt=\"Storage View\" /> ";
            }
            return $memberNonMemberStats;
            
            
        }
        
        /*
         * Group breakdown bar chart 
         * 
         */
        public function groupBarChart()
        {
            $returnData = "
            function drawGroupBarChart() {

            var data = new google.visualization.arrayToDataTable([
            ['Group Name', 'Number of Members']";
            
            $sql = "SELECT * FROM (groups RIGHT JOIN campus on groups.campusID=campus.campusID) ORDER BY groupName ASC;";
            $result = db::returnallrows($sql);
            foreach($result as $group){
                $sql2 = "SELECT * FROM groupmembers WHERE groupID='".$group['groupID']."'";
                $numrows = db::getnumrows($sql2);
                
                $returnData .= ",\r\n\t['" . $group['groupname'] . " (". $group['campusName'] . ")', ".$numrows."]";
            }
            
            $returnData .="]);

            // Set chart options
            var options = {title: 'Number of Members per Group',
                            width: 'auto',
                            height: '300',
                            hAxis: {title: 'Groups', titleTextStyle: {color: 'Blue'}}
                            };
                            
                var chart = new google.visualization.ColumnChart(document.getElementById('groupBarChart_div'));
                chart.draw(data, options);
            }
            ";
            
            
            return $returnData;
        }
        
        
        /*
         * Gender Pie Chart breakdown
         * 
         */
        public function genderPieChart()
        {
            $returnData = "
            function drawGenderPieChart() {

            var data = new google.visualization.arrayToDataTable([
            ['Group Name', 'Number of Members']";
            
            $sql1 = "SELECT gender FROM churchmembers WHERE gender='m' ";
            $sql2 = "SELECT gender FROM churchmembers WHERE gender='f' ";
            
            $males = db::getnumrows($sql1);
            $females = db::getnumrows($sql2);
            $returnData .= ",\r\n\t['Male', ".$males."]";
            $returnData .= ",\r\n\t['Female', ".$females."]";
            
            $returnData .= "]);

            // Set chart options
            var options = {title: 'Gender breakdown cross-campus'
                            };
                            
                var chart = new google.visualization.PieChart(document.getElementById('genderPieChart_div'));
                chart.draw(data, options);
            }
            ";
            
            
            return $returnData;
        }
        
        
        
}

?>
