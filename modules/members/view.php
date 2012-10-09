<?php

/*
 * Member View information Output
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>

<div class="helpbox" id="helpbox">
    <a href="#" onClick="hidereminder('helpbox');">close help</a>
    <?php print $objHelp->displayHelp('members','1'); ?>
</div>
    

<div class="contentBox">
    <h1>View member</h1>
    <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
    <p>
        Showing all member information for <?php print $member['firstname']." ".$member['surname']; ?>.
    </p>
    <p>
        If you would like to add a similar member <a href="index.php?mid=201&lastid=<?php print $member['memberID']; ?>">click here</a>
    </p>
    <?php
    if($errorMsg != ""){
        print $errorMsg;
    }
    
    ?>
</div>
<div class="contentBoxSmall">
     
    <h2>Basic Information</h2>
      
    <label for="campus">Campus</label>
        <?php print $objCampus->getCampusName($member['campusid']); ?>
       </p>
       <p>
        <label for="memberStatus">Member Status:</label>
	<?php print $member['memberStatus']; ?>
       </p>
       <p>
        <label for="prefix">Prefix</label>
	<?php print $member['prefix']; ?>
       </p>
       <p>
        <label for="prefix">Gender</label>
	<?php print $member['gender']; ?>
       </p>
       <p>
        <label for="firstname">First Name</label>
        <?php print $member['firstname']; ?>
       </p>
       <p>
        <label for="middlename">Middle Name</label>
	<?php print $member['middlename']; ?>
       </p>
       <p>
	<label for="surname">Surname</label>
	<?php print $member['surname']; ?>
       </p>
       <p>
        <label for="address1">Address 1</label>
	<?php print $member['address1']; ?>
       </p>
       <p>
	<label for="address2">Address 2</label>
	<?php print $member['address2']; ?>
       </p>
       <p>
        <label for="address3">Address 3</label>
	<?php print $member['address3']; ?>
       </p>
       <p>
        <label for="address4">Address 4</label>
	<?php print $member['address4']; ?>
       </p>
       <p>
        <label for="postcode">Postcode</label>
	<?php print $member['postcode']; ?>
       </p>
       <p>
        <label for="country">Country</label>
	<?php print $member['country']; ?>
       </p>
       <p>
	<label for="phone">Phone Number</label>
	<?php print $member['homephone']; ?>
       </p>
       <p>
        <label for="mobile">Mobile Number</label>
	<?php print $member['mobilephone']; ?>
       </p>
       <p>
	<label for="email">Email Address</label>
	<?php print $member['email']; ?>
       </p>
       <p>
	<label for="dateofbirth">Date of Birth</label>
	<?php print $member['dateofbirth']; ?>
	</p>
        <p>
        <label for="maritalstatus">Marital Status</label>
	<?php print $member['maritalstatus']; ?>  
        </p>
</div>
	

        
<div class="contentBoxSmall">
		
<h2>Extended Information</h2>
                <p>
                <label for="firstvisit">First Visit</label>
		<?php print $member['firstvisit']; ?>
		
               </p>
               <p>
                <label for="source">Source of data</label>
		<?php print $member['sourceofdata']; ?>
               </p>
               <p>
		<label for="commitmentdate">Commitment Date</label>
                <?php print $member['commitmentdate']; ?>
               </p>
               <p>
		<label for="crbcheck">CRB Checked</label>
		<?php print $member['crbcheck']; ?>
               </p>
               <p>
                <label for="crbcheckdate">CRB Check Date</label>
		<?php print $member['crbcheckdate']; ?>
               </p>
               <p>
                <label for="mainLanguage">Main Language</label>
                    <?php print $member['mainLanguage']; ?>
                </p>
                <p>
		<label for="countryoforigin">Country of Origin:</label>
		<?php print $member['countryoforigin']; ?>
		</p>
                <p>
		<label for="medicalInfo">Other Info:</label>
		<?php print $member['medicalInfo']; ?>
                </p>
                <p>
                <label for="emailoptin">Email Opt-in</label>
		<?php print $member['emailoptin']; ?>
		</p>
                <p>
                <label for="giftaid">GiftAid ID:</label>
		<?php print $member['giftaid']; ?>
                </p>
	
</div>
	
<div class="contentBoxSmall">

    <h2>Work Information</h2>
                <p>
		<label for="employer">Employer:</label>
		<?php print $member['employer']; ?>
               </p>
               <p>
		<label for="occupation">Occupation:</label>
		<?php print $member['occupation']; ?>
               </p>
               <p>
                <label for="workphonenumber">Work Phone Number:</label>
		<?php print $member['workphonenumber']; ?>
		</p>
                <p>
                <label for="workfaxnumber">Work Fax Number:</label>
		<?php print $member['workfaxnumber']; ?>
               </p>
               <p>
		<label for="workemail">Work Email:</label>
		<?php print $member['workemail']; ?>
               </p>
               <p>
		<label for="workwebsite">Website:</workwebsite>
		<?php print $member['workwebsite']; ?>
                </p>
</div>

<div class="contentBoxSmall">
    <h2>Family Links</h2>
    <a href="index.php?mid=230&m=<?php print $member['memberID']; ?>">Add family member</a>
    <?php print $objMember->showFamilyLinks($member['memberID']); ?>
</div>
