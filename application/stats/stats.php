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
    
}

?>
