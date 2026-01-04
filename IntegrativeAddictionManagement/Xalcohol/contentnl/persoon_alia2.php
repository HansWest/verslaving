<?php
///personalia en middelehistorie gaan we uit elkaar halen
session_start();
$persoon_id = $_SESSION['persoon_id'];
$zoekpersoon = $persoon_id;

$strategie = $_SESSION['strategie'];
$strategieduur = $_SESSION['strategieduur'];
$evaldatum = $_SESSION['evaldatum'];
$totevaldatum = $_SESSION['totevaldatum'];
$nextstep = $_SESSION['nextstep'];


include "gegevens_sma.php";
include "../assets/formulas.php";
//Zorgen dat $_POST en $_GET niet meer vatbaar zijn voor SQL injection 
anti_injection($HTTP_POST_VARS); 
extract($HTTP_POST_VARS);
$hiero1="gegevens";
$zoekpersoon = $_SESSION['persoon_id'];

$layoutnr="350";

include "layoutinc/inc.nltemplate0.php";
$fout = "";
$pemailadres = trim($pemailadres); 
if($pemailadres != "")
{
	$pemailadres=strtolower($pemailadres);
	if(!ereg("^([._a-z0-9-]+[._a-z0-9-]*)@(([a-z0-9-]+\.)*([a-z0-9-]+)(\.[a-z]{2,3})?)$", $pemailadres))
	{
		$fout = "<br>uhhh ik lees [".$pemailadres."], dit lijkt geen bestaand emailadres te zijn. Misschien wil je dat verbeteren?";
	}
}
if ($opdehoogte == "1" && $pemailadres == "")
{
	$fout = "<br>Sorry! Maar als je <i>wel </i>wilt dat ik contact opneem met je partner en je geeft g&eacute;&eacute;n emailadres aan, dan geef je tegenstrijdige signalen <img src=\"../pics/macsmiley.gif\" alt=\"*glimlach*\">. Misschien wil je dat verbeteren?";
}
if ($partner =="1" && $pvoornaam == "" && $pachternaam == "")
{
	echo "<br>jammer dat je deze site niet genoeg vertrouwt om de naam van je partner aan te geven <img src=\"../pics/macsmiley.gif\" alt=\"*glimlach*\">. Het was voldoende geweest om het kruisje niet te zetten...";
}
if ($pgebdag == "" or $pgebdag =="dd")
{
	$pgebdag = "01";
}
if ($pgebmaand == "" or $pgebmaand =="mm")
{
	$pgebmaand = "01";
}
if ($pgebjaar == "" or $pgebjaar =="jjjj")
{
	$pgebdat = "";
}else{
	$pgebdat = "$pgebjaar-$pgebmaand-$pgebdag";
}
if ($fout == "")
{
	//include "persoon_aaa_inc.php";
	//@@@	echo "<table width=\"100%\" heigth=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td valign=\"bottom\">&nbsp;</td><td valign=\"top\" align=\"right\"><a href=\"info_eenheden.php\" target=\"_self\" class=\"menubutton\">maat eenheden</a></td></tr></table>";
	///Naar database wegschrijven
	include '../assets/dbconnect.php';
	///TABLE steunnetwerk
	//net_id,persoon_id,user_name,emailadres,voornaam,achternaam,paswoord,remote_addr,confirm_hash,is_confirmed,date_created,relatietoon,relatietot,relatiegeeft,relatiekost,opdehoogte,net_blokkeert
	//        	$query = "INSERT INTO maatschaplktabel (persoon_id, partner_id, kids, kidsinwonend, woon_sit, opleidingniv, werk_situatie, arbeidsproblem, werkstudie, huishouden, opvoedingzorg)
	$query = "SELECT * 
		FROM steunnetwerk
		WHERE persoon_id = '$zoekpersoon'
		AND relatietot = '1'";
	$result = mysql_query($query);
	if (!$result)
	{
		$fout = $errormain;
	} 
	//@@@	echo $zoekpersoon."<br>xxX". $fout."Xxx gezocht naar partner. rows is ".mysql_num_rows($result) ;
	$pusernaam = $pvoornaam.$zoekpersoon;
	if (mysql_num_rows($result) < 1)
	{
		$feedback = "<br>voornaam wordt: ". $pvoornaam." &amp; achternaam wordt: ".$pachternaam."<br>onthou: <b>usernaamnaam wordt: ". $pusernaam ;
		$feedback .= "</b><br>emailadres is: ". $pemailadres."<br>de geboortedatum is: ".$pgebdat."<br>de toon van de relatie is: ";
		if ($relatietoon == 1) { $feedback .= "lieve ".$pvoornaam ; }
		if ($relatietoon == 2) { $feedback .= "beste ".$pvoornaam ; }
		if ($relatietoon == 3) { $feedback .= "geachte ".$pachternaam ; }

		$query = "INSERT INTO steunnetwerk 
VALUES(NULL, '$zoekpersoon', '$pusernaam', '$pemailadres', '$pvoornaam', '$pachternaam', 'passwoord', '', '', 0, '$datetime', '$pgebdat', '$relatietoon', 1,'','','$opdehoogte','0')";
		///INSERT INTO steunnetwerk VALUES (NULL, '$zoekpersoon', '$pusernaam', '$pemailadres', '$pvoornaam', '$pachternaam', 'passwoord', '', '', 0, '$datetime', '$pgebdat', '$relatietoon', 1,'','','$opdehoogte','$net_blokkeert');

		$result = mysql_query($query);
		if (!$result || mysql_affected_rows() < 1)
		{
			$fout = $errordatabase;
		}
		//@@@echo "<br>xxX". $fout."Xxx nieuw toegevoegd. rows is affected rows".mysql_affected_rows();
	}else{
		$query = "SELECT * 
				FROM steunnetwerk
				WHERE persoon_id = '$zoekpersoon'
				AND relatietot = '1'";
		$result = mysql_query($query);			
	//@@@
	echo "<p class='errortxt'>xxX". $fout."Xxx gezocht naar partner. rows is ".mysql_num_rows($result)."</p>" ;
	if (mysql_num_rows($result) > 0 )
	{
		extract (mysql_fetch_array ($result));
		$query = "UPDATE maatschaplktabel
		SET partner_id = '$net_id',
		WHERE persoon_id = '$zoekpersoon'";
		$result = mysql_query($query);
		if (!$result || mysql_affected_rows() < 1)
		{
			$fout = $errordatabase;
		}
		echo "<p class='errortxt'>xxX". $fout."Xxx gezocht naar partner. rows is ".mysql_num_rows($result)."</p>" ;
	}
if (mysql_num_rows($result) > 1)
{
$fout="Je mag me 'old fashioned' vinden maar ik kom meerdere mensen tegen die als jouw primaire partner staan aangegeven. Dat kan, dat mag natuurlijk... maar uhhh is er niet toevallig eentje iets meer primair dan de ander??? *grinnik* (tja, ik ben maar een computer en verwacht slechts 1 primaire(!) partner)";
}else{
$feedback = "<br>".$voornaam." ".$achternaam." word voortaan: ". $pvoornaam." ".$pachternaam ;
}
if ($fout ="")
{
$query = "UPDATE personalia
SET voornaam = '$pvoornaam',
achternaam = '$pachternaam',
gender = $pgender
WHERE persoon_id = '$zoekpersoon'
AND relatietot = '1'";
$result = mysql_query($query);
if (!$result || mysql_affected_rows() < 1)
{
$fout = $errordatabase;
}
}
}
/*
// TABLE maatschaplktabel
$query = "SELECT * 
FROM maatschaplktabel
WHERE persoon_id = '$zoekpersoon'";
$result = mysql_query($query);
if (!$result || mysql_num_rows($result) < 1) {
$query = "INSERT INTO maatschaplktabel (persoon_id, partner_id, kids, kidsinwonend, woon_sit, opleidingniv, werk_situatie, arbeidsproblem, werkstudie, huishouden, opvoedingzorg)
VALUES(NULL, '$zoekpersoon', '$partner_id', '$kids', '$kidsinwonend', '$woon_sit', '$opleidingniv', '$werk_situatie', '$arbeidsproblem', '$werkstudie', '$huishouden', '$opvoedingzorg')";
} else {
$query = "UPDATE maatschaplktabel
SET partner_id = '$partner_id',
kids = '$kids',
kidsinwonend = '$inwonend',
WHERE persoon_id = '$zoekpersoon'";
$result = mysql_query($query);
if (!$result || mysql_affected_rows() < 1)
{
$fout = $errordatabase;
}
}


///@@@

*/
///

}
include "layoutinc/inc.nltemplate1.php";

?>
<?php
echo "<b><img src=\"../pics/macsmiley.gif\" border=\"0\"> persoonsgegevens ";
if ($partner =="1")
{
echo "partner en ";
}
echo "aanvang</b><br>";

////@@@@$fout = "";
if ($fout != "")
{
echo "<center><form><table border=0 width=100%>";
echo "<tr><td><img src=\"../pics/macmandwn.gif\" alt=\"oeps\" width=\"23\" height=\"28\" border=\"0\"></td><td><b>Ik ondekte een foutje in de invoer:</b></td></tr>";
echo "<tr><td>&nbsp;</td><td class='errortxt'><b>".$fout."</b></td></tr>";
echo "<tr><td><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\"</td><td><INPUT TYPE=\"button\" VALUE=\" terug \" onClick=\"history.go(-1)\"></td></tr>";
echo "</table></form></center>";  
}else{
	$vraag02 = "<tr><td valign=\"top\"><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\"> toen</td><td  valign=\"top\">het begin:</td><td><i><b><i>Hoe oud</i></b></i> was jij (ongeveer) toen je voor het eerst alcohol dronk? <input name=\"eersteleeft\" type=\"text\" size=\"3\" maxlength=\"2\" value=\"jj\" onFocus=\"if(this.value=='jj')this.value='';\"><font color=\"#800040\">*</font>";
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">1ste keer:</td><td><i><b>Hoe beviel</b></i> deze eerste kennismaking?: <font color=\"#800040\">*</font><br><SELECT NAME=\"bevieleerste\"><option value=\"\">maak hier een keuze</option><option value=\"1\">beviel niet echt</option><option value=\"2\">was wel aardig</option><option value=\"3\">voelde gelijk geweldig</option></SELECT></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">&nbsp;</td><td><i>Was dit in het kader van : <font color=\"#800040\">*</font><br><SELECT NAME=\"eerstekader\"><option value=\"\">maak hier een keuze</option><option value=\"1\">experiment / uitproberen hoe dat is</option><option value=\"2\">met een bepaald doel voor ogen</option><option value=\"3\">ik herinner mij dat niet echt meer</option><option value=\"4\">ik voelde mij gedwongen</option></SELECT></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">verloop:</td><td>Er even van uitgaande dat jij nu jouw gebruik wel wat 'teveel' vindt: ben je gestaag meer gaan drinken of is dat 'meer' ineens gekomen?<br><SELECT NAME=\"aanloop\"><option value=\"\">maak hier een keuze</option><option value=\"3\">vanaf eerste moment meer gedronken dan gemiddeld</option><option value=\"2\">ik ben gaandeweg meer gaan drinken</option><option value=\"1\">het was later dat ik 'teveel' ben gaan drinken</option></SELECT></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">contr&ocirc;le verlies:</td><td>Wat was het jaar waarin jij aan jezelf <i><b>begon</b></i> toe te geven dat er mischien toch wel een probleem(pje) was met het controleren van de alcoholinname? <input name=\"toegeefjaar\" type=\"text\" size=\"5\" maxlength=\"4\" value=\"jjjj\" onFocus=\"if(this.value=='jjjj')this.value='';\"><font color=\"#800040\">*</font>";
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">patronen:</td><td><i>Herken jij je meer in het patroon: <font color=\"#800040\">*</font><br><SELECT NAME=\"eerstekader\"><option value=\"1\">experiment / uitproberen hoe dat is</option><option value=\"2\">met een bepaald doel voor ogen</option><option value=\"3\">ik herinner mij dat niet echt meer</option></SELECT></td></tr>";
	$vraag02 .= "<tr><td valign=\"top\"><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\"> en nu...</td><td valign=\"top\">aantallen:</td><td>Hoeveel <b>eenheden</b> drink je nu <b>gemiddeld per week</b>? <input name=\"gemiddeldeweek\" type=\"text\" size=\"3\" maxlength=\"3\"><font color=\"#800040\">*</font> (neem <i>echt</i> even de tijd om te rekenen alsjeblieft)</font>";
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">omgeving:</td><td>Maakt jouw omgeving zich wel eens zorgen over jouw alcohol inname: <font color=\"#800040\">*</font><br><SELECT NAME=\"omgevingzorg\"><option value=\"0\">nee, niemand</option><option value=\"2\">een enkeling</option><option value=\"3\">dat heb ik wel vaker gehoord</option></SELECT></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">pogingen:</td><td>Heb je ooit eerder serieuze stoppogingen ondernomen? <font color=\"#800040\">*</font><br><SELECT NAME=\"stoppogingen\"><option value=\"0\">nee, nooit</option><option value=\"2\">wel eens</option><option value=\"3\">een paar serieuze</option><option value=\"4\">vaak</option></SELECT></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type=\"submit\" name=\"submit\" value=\"".$submittxt."\"> &nbsp; &nbsp; <input type=\"reset\" name=\"reset\" value=\"".$resettxt."\"></td></tr>";

if ($partner == "1")
{
echo "Beste $voornaam,<br>";
	echo "Momenteel heb je een (vaste) relatie met $pvoornaam $pachternaam, geboren $pgebdag/$pgebmaand/$pgebjaar - een ";
	if ($pgender == "")
	{
		echo "...<BR> (uhhh... is je partner <i>echt </i>geslachtsloos?)";
	}
	if ($pgender == 1) {echo "man";}else{echo"vrouw";}
	echo ", nu ongeveer ".(date('Y') - $pgebjaar)." jaar oud.";
}
if ($pgebjaar < (date('Y') - 100) ) {
	echo "... (waardoor ik je partner wel een beetje uhhhh 'op leeftijd' vind... heb je wel <i>vier</i> cijfers ingevuld in het geboortejaar?)";
	}
	echo "<br>&nbsp; &nbsp;<i> (ook hier: klopt het voorgaande niet, ga dan even terug, want zo vaak zal je niet op deze pagina terecht komen)</i><br>";
	echo "<center><form><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\">&nbsp; &nbsp; <INPUT TYPE=\"button\" VALUE=\" terug \" onClick=\"history.go(-1)\"> (klik hier om e.e.a. alsnog in te vullen)</form></center>"; 
}
?>

<p><b><img src="../pics/macsmiley.gif" border="0"> de aanvang van het alcoholverhaal in jouw leven</b><br>
  Het zal duidelijk zijn dat ik in het kader van deze site ook nog graag wat gegevens 
  heb over de manier waarop jij met alcohol omgegaan bent in jouw leven. We gaan 
  daar in de toekomst nog meer in uitzoeken met elkaar. Maar er zijn in ieder geval al een paar 
  dingen die ik graag direct wil vragen.</p>
  <?php
include "layoutinc/inc.nltemplate2.php";
?>
<form name="personalia" action="persoon_alia3.php" method="post">
<table width="100%"  border="0">
<?php 
if ($feedback!= "")
{
	echo "<tr><td>&nbsp;</td><td colspan=\"2\"><div class=\"feedbacktxt\"><b>".$feedback."</b></div></td></tr>";
}
echo $vraag02 ?>
<!--tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="submit" value="<?php echo $submittxt ?>"> &nbsp; &nbsp; <input type="reset" name="reset" value="<?php echo $resettxt ?>"></td></tr-->
</table></form>
</center>
                    
<p>&nbsp;</p>
  <?php
include "layoutinc/inc.nltemplate3.php";
?>
