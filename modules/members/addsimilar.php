<?php

/*
 * Member Add Similar Form
 */
if(!empty($errorMsg)){
    print "<div class=\"errors\">$errorMsg</div>";
}
?>
    <div class="helpbox" id="helpbox">
        <a href="#" onClick="hidereminder('helpbox');">close help</a>
        <?php print $objHelp->displayHelp('members','2'); ?>
    </div>
        <form name="edituser" action="index.php" method="post">
            <input type="hidden" name="store" id="store" value="true" /> 
            <input type="hidden" name="mid" id="mid" value="200" />

    <div class="contentBox">
        <h1>Add similar member</h1>
        <input type="submit" value="Save Details" style="float: right; margin-right: 40px;" />
        <span class="helpclass"><a href="#" onClick="showreminder('helpbox');"><img src="images/icons/information.png" alt="Show Help" title="Show Help" border="0" /></a></span>
        <p>
            Enter all information you can for your new member and click on the save button here at the top to add your new member to the system.
        </p>
    </div>

    <div class="contentBoxSmall">

        <h2>Basic Information</h2>

        <label for="campus">Campus</label>
        <select name="campus" id="campus">
            <option default value="<?php print $member['campusid']; ?>"><?php print $objCampus->getCampusName($member['campusid']); ?> (Current)</option>
            <?php print  $objMember->getCampusList();   ?>
        </select>

            <label for="memberStatus">Member Status:</label>
            <select name="memberStatus" id="memberStatus">
                <option value="<?php print $member['memberStatus']; ?>"><?php print $member['memberStatus']; ?> (Current)</option>
                <option default value="active">Member</option>
                <option value="nonmember">Non-Member</option>
                <option value="contact">External Contact</option>
                <option value="visitor">Visitor</option>
                <option value="archived">Archived</option>
            </select>

            <label for="prefix">Prefix</label>
            <select name="prefix" id="prefix">
                <option default value="<?php print $member['prefix']; ?>"><?php print $member['prefix']; ?> (Current)</option>
                <option value="Mr">Mr</option>
                <option value="Mrs">Mrs</option>
                <option value="Miss">Miss</option>
                <option value="Ms">Ms</option>
                <option value="Dr">Dr</option>
                <option value="Rev">Rev</option>
            </select>

            <label for="prefix">Gender</label>
            <select name="gender" >
                <option default value="<?php print $member['gender']; ?>"><?php print $member['gender']; ?> (Current)</option>
                <option value="m">Male</option>
                <option value="f">Female</option>
            </select>

            <label for="firstname">First Name</label>
            <input type="text" name="firstname" size="30" id="firstname"  value="" />

            <label for="middlename">Middle Name</label>
            <input type="text" name="middlename" size="30" id="middlename" value="" />

            <label for="surname">Surname</label>
            <input type="text" name="surname" id="surname" size="30" value="<?php print $member['surname']; ?>" />

            <label for="address1">Address 1</label>
            <input type="text" name="address1" size="30" id="address1" value="<?php print $member['address1']; ?>" />

            <label for="address2">Address 2</label>
            <input type="text" name="address2" size="30" id="address2" value="<?php print $member['address2']; ?>"/>

            <label for="address3">Address 3</label>
            <input type="text" name="address3" size="30" id="address3" value="<?php print $member['address3']; ?>" />

            <label for="address4">Address 4</label>
            <input type="text" name="address4" size="30" id="address4" value="<?php print $member['address4']; ?>" />

            <label for="postcode">Postcode</label>
            <input type="text" name="postcode" size="30" id="postcode" value="<?php print $member['postcode']; ?>" />

            <label for="country">Country</label>
            <input type="text" name="country" size="30" id="country" value="<?php print $member['country']; ?>" />

            <label for="contactmethod">Contact Method</label>
            <select name="contactmethod" id="contactmethod">
                <option value="home">Home Phone</option>
                <option value="mobile">Mobile</option>
                <option value="email">Email</option>
                <option value="mail">Land-Mail</option>
            </select>

            <label for="phone">Phone Number</label>
            <input type="text" name="phone" size="30" id="phone" value="<?php print $member['homephone']; ?>" />

            <label for="mobile">Mobile Number</label>
            <input type="text" name="mobile" size="30" id="mobile" value="" />

            <label for="email">Email Address</label>
            <input type="text" name="email" size="30" id="email" value="" />

            <label for="dateofbirth">Date of Birth</label>
            <input type="text" name="dateofbirth" size="30" id="dateofbirth" placeholder="dd-mm-yyyy"  value="" />

            <label for="maritalstatus">Marital Status</label>
            <select name="maritalstatus" id="maritalstatus">
                <option value="single">Single</option>
                <option value="married">Married</option>
                <option value="divorced">Divorced</option>
                <option value="widowed">Widowed</option>
            </select>

    </div>



    <div class="contentBoxSmall">

    <h2>Extended Information</h2>
                    <label for="firstvisit">First Visit</label>
                    <input type="text" name="firstvisit" size="30" id="firstvisit" placeholder="dd-mm-yyyy" value="" />


                    <label for="source">Source of data</label>
                    <select name="source" id="source">
                        <option default value="<?php print $member['source']; ?>"><?php print $member['source']; ?> (Current)</option>
                        <option value="service">Service</option>
                        <option value="connect">Connect Group</option>
                        <option value="outreach">Outreach</option>
                        <option value="direct">Direct Contact</option>
                    </select>

                    <label for="commitmentdate">Commitment Date</label>
                    <input type="text" name="commitmentdate" size="30" id="commitmentdate" value="" />

                    <label for="crbcheck">CRB Checked</label>
                    <select name="crbcheck" id="crbcheck">
                        <option value="no" default>No</option>
                        <option value="yes">Yes</option>
                    </select>

                    <label for="crbcheckdate">CRB Check Date</label>
                    <input type="text" name="crbcheckdate" size="30" id="crbcheckdate" placeholder="dd-mm-yyyy" value="" />

                    <label for="mainLanguage">
                        <select name="mainLanguage" id="mainLanguage">
                            <option value="English">English</option>
                            <option value="Africaans">Africaans</option>
                            <option value="French">French</option>
                            <option value="German">German</option>
                            <option value="Mandarin">Mandarin</option>
                            <option value="Spanish">Spanish</option>
                            <option value="Urdu">Urdu</option>
                            <option value="other">Other:</option>
                        </select>
                        <input type="text" name="otherLangOption" id="mainLanguage" size="30" value="<?php print $member['otherLangOption']; ?>" />

                    <label for="countryoforigin">Country of Origin:</label>
                    <input type="text" name="countryoforigin" size="30" id="countryoforigin" value="<?php print $member['countryoforigin']; ?>" />

                    <label for="medicalInfo">Other Info:</label>
                    <textarea name="medicalInfo" id="medicalInfo" cols="22" rows="6" placeholder="(Medical Info etc.)"></textarea>

                    <label for="emailoptin">Email Opt-in</label>
                    <select name="emailoptin" id="emailoptin" >
                        <option default value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>

                    <label for="giftaid">GiftAid ID:</label>
                    <input type="text" size="30" maxlength="9" name="giftaid" id="giftaid" value="" />


    </div>

    <div class="contentBoxSmall">

        <h2>Work Information</h2>
                    <label for="employer">Employer:</label>
                    <input type="text" name="employer" id="employer" size="30" value="" />

                    <label for="occupation">Occupation:</label>
                    <input type="text" name="occupation" id="occupation" size="30" value="" />

                    <label for="workphonenumber">Work Phone Number:</label>
                    <input type="text" name="workphonenumber" id="workphonenumber" size="30" value="" />

                    <label for="workfaxnumber">Work Fax Number:</label>
                    <input type="text" name="workfaxnumber" size="30" value="" />

                    <label for="workemail">Work Email:</label>
                    <input type="text" name="workemail" id="workemail" size="30" value="" />

                    <label for="workwebsite">Website:</workwebsite>
                    <input type="text" name="workwebsite" id="workwebsite" size="30" value="" />

    </div>
    </form>


