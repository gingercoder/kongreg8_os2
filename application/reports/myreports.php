<?php

/*
 * My Reports System
 */
$checkuserlevel = $objKongreg8->checkAccessLevel('MyReports');
if($checkuserlevel == false){
    require_once ('failcodes/userlevel.html');
    exit();
}

require_once ('application/reports/reports.php');
$objReports = new reports();

// If creating new report store the entry
if($_POST['store'] == 'true'){
    if(($_POST['whereA'] !="")&&($_POST['valueA'] !="")&&($_POST['tableName'] !="")){
        
        $setreport = $objReports->createReport($_POST['reportName'], $_POST['reportDescription'], $_POST['tableName'], $_POST['whereA'], $_POST['valueA'], $_POST['whereB'], $_POST['valueB'], $_POST['compareA'], $_POST['compareB'], $_POST['compareBoth']);
        $reportInfo = "Creating MyReport with settings: " . db::escapechars($_POST['reportName']) . ' ' . db::escapechars($_POST['reportDescription']) . ' ' . db::escapechars($_POST['tableName']) . ' ' . db::escapechars($_POST['whereA']) . ' ' . db::escapechars($_POST['compareA']) . ' ' . db::escapechars($_POST['valueA']) . ' ' . db::escapechars($_POST['compareBoth']) . ' ' . db::escapechars($_POST['whereB']) . ' ' . db::escapechars($_POST['compareB']) . ' ' . db::escapechars($_POST['valueB']);
        if($setreport == 'true'){
            $entryupdatemessage = "<p class=\"updated\">New report stored in the system.</p>";
            $objKongreg8->logevent('reports', $reportInfo, 'myreports');
        }
        else{
            $entryupdatemessage = "<p class=\"confirm\">Sorry, I couldn't store your new report in the system, I've logged the fault.</p>";
            $objKongreg8->logerror('reports', $reportInfo, 'myreports');
        }
        
    }
    else{
        $entryupdatemessage = "<p class=\"confirm\">Missing values in Where A , Value A or Table Name. You need to provide these as a minimum.</p>";
    }
    
}


// If deleting a report check and then remove the report
if(($_GET['rm'] == 'true')&&($_GET['r'] !="")){
    
    if($_GET['confirm'] == 'true'){
        $deletereport = $objReports->removeReport($_GET['r']);
        $reportInfo = "Trying to remove MyReport ".db::escapechars($_GET['r'])." from the system";
        if($deletereport == 'true'){
            $entryupdatemessage = "<p class=\"updated\">Report removed from the system.</p>";
            $objKongreg8->logevent('reports', $reportInfo, 'myreports');
        }
        else{
            $entryupdatemessage = "<p class=\"confirm\">Sorry, I couldn't delete your report from the system, I've logged the fault.</p>";
            $objKongreg8->logerror('reports', $reportInfo, 'myreports');
        }
    }
    else{
        $entryupdatemessage = "<p class=\"confirm\">Are you sure you wish to remove this report? &nbsp;&nbsp;
                                <a href=\"index.php?mid=505&r=".$_GET['r']."&rm=true&confirm=true\">Yes, remove it</a>.
                                </p>";
    }
}

require_once ('modules/reports/myreports.php');

?>
