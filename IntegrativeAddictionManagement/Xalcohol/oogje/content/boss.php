<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../assets/oogje.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
$ref = $HTTP_GET_VARS[ref];
///kijken of er geklooid is met get
$error="";
if (isset($_GET['ref']))
{
	if (strlen($_GET['ref']) > 23)
	{
		$error = "er lijkt met de lengte of de inhoud van de url te zijn gerommeld??? ga zelf niets aan het referentienummer veranderen<BR>maar vraag om assistentie bij problemen...";
	} 
	$action = substr($_SERVER['REQUEST_URI'],-3);
	$task_id= substr($ref,0,strlen($ref)-3);
	if (substr($action,0,1) !="0")
	{
		$error = "er lijkt met de inhoud of de lengte van de url te zijn gerommeld??? ga zelf niets aan het referentienummer veranderen<BR>maar vraag om assistentie bij problemen...";
	}
}
///wat gaan we doen
switch ($action)
{
case "009":
	///mail dat actie niet op tijd is
	$tekst = 'helaas is de volgende taak niet op tijd afgerond';
	break;
case "008":
	///mail dat problemen zijn ontstaan
	$tekst = 'helaas zijn bij de volgende taak problemen ontstaan';
	break;
default:
	$tekst = 'berichtje schrijven';
//					return $ts;
}		

if ($error == '')
{
//berichtid 
$datumtijd = strtotime ("now");
$dbdatumtijd=date('Y-m-d H:i:s', $datumtijd);
$bericht = stripslashes(htmlspecialchars($bericht));
//$persoon_id = ;
//$aanwieid = ;
//$projectid = ;
//$datumtijd = ;
//$soort = ;
//$bericht = stripslashes(htmlspecialchars($bericht));
// "mysql_query(INSERT INTO oogjemail SET berichtid=0, persoon_id=\"$persoon_id\", aanwieid=\"$aanwieid\", projectid=\"$projectid\", datumtijd=\"$dbdatumtijd\", bericht=\"$soort\", bericht=\"$soort\", bericht=\"$bericht\"";
echo "mysql_query(INSERT INTO oogjemail SET berichtid=0, persoon_id=\"$persoon_id\", aanwieid=\"$aanwieid\", projectid=\"$projectid\", datumtijd=\"$dbdatumtijd\", bericht=\"$soort\", bericht=\"$soort\", bericht=\"$bericht\"";
print "ref$ref<P>";
echo ("err$error<P>");
echo ("action $action<P>");
echo ("task $task <P>");
} else {die ($error);}

?>
<p>&nbsp;</p>
<p>aanwieid tinyint(11) NOT NULL default '0',<br>
  --kan persoon zelf zijn aan zichzelf maar meestal rapport<br>
  meekijken in $teamnaam <br>
  afgerond <br>
  datum prioriteit <br>
  achterop prioriteit wat wanneer (voor wanneer) waar wie <br>
  urgency / importance mailto:$supervisor <br>
  mailto:$titel $voornaam $tussen $achternaam, $functie </p>
<p></p>
<p><br>
  vinkje voor terugrappportage in 'organisatie' dat 'dwingt'tot terugrap <br>
  terugrap veld in werkzaamheden <br>
  mbtveld met todo_id in 'mails' <br>
  if terugrapvereisd</p>
</body>
</html>


if ($Submit) {
//	include "data.inc.php";
	$CONNECT = mysql_connect($DB_host, $DB_user, $DB_pass) or die(Mysql_error());
	mysql_select_db($DB_name);

	$notes = stripslashes(htmlspecialchars($notes));
	$date = $year . "-" . $month . "-" . $day;

	$insert = mysql_query("INSERT INTO oogjemail SET date=\"$date\", time=\"$time\", type=\"$type\", notes=\"$notes\"") or die(mysql_error());
	
	mysql_close($CONNECT);
	//header("location: appointments.php?Sec=schedule");
}
