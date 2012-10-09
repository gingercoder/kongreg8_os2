<?php

/*
 * Search results 
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}


$members = $objMember->getMemberList($firstname, $surname, $address, $phonenum);

print "<div class=\"contentBox\">";
print "<table class=\"memberTable\">
        <tr>
            <th>Surname</th>
            <th>Firstname</th>
            <th>Address</th>
            <th>Home Phone</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        ";

foreach($members as $person){

    print "<tr>";
        print "<td>".$person['surname']."</td>";
        print "<td>".$person['firstname']."</td>";
        print "<td>".$person['address1']." ".$person['address2']." ".$person['address3']."</td>";
        print "<td>".$person['homephone']."</td>";
        print "<td>".$person['mobilephone']."</td>";
        print "<td>".$person['emailaddress']."</td>";
        print "<td>
                <a href=\"index.php?mid=225&m=".$person['memberID']."\">View</a> /
                <a href=\"index.php?mid=220&m=".$person['memberID']."\">Edit</a> /
                <a href=\"index.php?mid=235&m=".$person['memberID']."\">Remove</a>
                </td>";
    print "</tr>";
}
print "</table>";
print "</div>";
?>
