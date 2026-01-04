<?php
/////vars van persoon
///open up database
include '../assets/dbconnect.php';
$persoon_id = $_SESSION['persoon_id'];
	$datetime = strtotime("now");
	$nu= date('Y-m-d', $datetime);
	$deMySQLquery= "SELECT * FROM strategietabel WHERE persoon_id = '$persoon_id'";
    $HetQueryResult = mysql_query($deMySQLquery);
	$strategietab = mysql_fetch_row($HetQueryResult);
    if (!$HetQueryResult || mysql_num_rows($HetQueryResult) < 1)
	{
		$deMySQLquery = "INSERT INTO strategietabel ( persoon_id , krediet , tabelvol, startdatum , strategie , personalmax , date_lastlogin , eerste_probleem , tweede_probleem , berekend_probleem , eerste_middel , tweede_middel , aanpakzelf , aanpaksamen , aanpakmedic , aanpakprofes, aanpaktekst)
VALUES ('$persoon_id', '$tartkrediet', '0', '$nu', '0', '0', '$nu', '0', '0', '0', '1', '0', '1', '0', '0', '0','eens rustig rondkijken op STOPOOKMETDRINKEN.NL','plan B')";
		$result = mysql_query ($deMySQLquery);
    }else{
		$deMySQLquery= "UPDATE strategietabel SET date_lastlogin = '$nu' WHERE persoon_id = '$persoon_id' LIMIT 1";
	    $result = mysql_query($deMySQLquery);
	}

//$result = mysql_query ("SELECT * FROM strategietabel WHERE persoon_id = '$persoon_id'");
//$count = mysql_num_rows($result);
//if ($count) {$strategietab = mysql_fetch_row($result);
//$row = mysql_fetch_row($result);

$_SESSION['krediet'] = $strategietab[1];
$_SESSION['startdatum'] = $strategietab[3];
$_SESSION['strategie'] = $strategietab[4];
$_SESSION['personalmax'] = $strategietab[5];
$_SESSION['date_lastlogin'] = $strategietab[6];
//$_SESSION['eerste_probleem'] = $strategietab[6];
//$_SESSION['tweede_probleem'] = $strategietab[7];
//$_SESSION['berekend_probleem'] = $strategietab[8];
//$_SESSION['eerste_middel'] = $strategietab[9];
//$_SESSION['tweede_middel'] = $strategietab[11];

//} else {
//$fout = "Error, er is een fout in de benadering van de database. Meld je dit even en wil je nu <a href=\"www.helpdisk.nl/alcohol/index.php\">[opnieuw inloggen door hier te klikken]</a>?" ;
//}

?>
