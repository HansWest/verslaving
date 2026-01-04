<?php
require_once('../assets/db_inc_login_funcs.php');
if (!user_isloggedin()) {
  header("Location: login.php");
}
session_start();
$persoon_id = $_SESSION['persoon_id'];
$zoekpersoon = $persoon_id;

$strategie = $_SESSION['strategie'];
$strategieduur = $_SESSION['strategieduur'];
$evaldatum = $_SESSION['evaldatum'];
$totevaldatum = $_SESSION['totevaldatum'];
$nextstep = $_SESSION['nextstep'];


//@@@
if (!$_SESSION['voornaam']) {
  header("Location: login.php");
}
///@@@
include "gegevens_sma.php";
include "../assets/formulas.php";
//Zorgen dat $_POST en $_GET niet meer vatbaar zijn voor SQL injection 
anti_injection($HTTP_POST_VARS); 
extract($HTTP_POST_VARS);
$hiero1="personalia"; 

$layoutnr="325";

include "layoutinc/inc.nltemplate0.php";

///
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
		FROM versl_gesch1
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
		$feedback .= "<br>voornaam wordt: ". $pvoornaam." &amp; achternaam wordt: ".$pachternaam."<br>onthou: <b>usernaamnaam wordt: ". $pusernaam ;
		$feedback .= "</b><br>emailadres is: ". $pemailadres."<br>de geboortedatum is: ".$pgebdat."<br>de toon van de relatie is: ";
		if ($relatietoon == 1) { $feedback .= "lieve ".$pvoornaam ; }
		if ($relatietoon == 2) { $feedback .= "beste ".$pvoornaam ; }
		if ($relatietoon == 3) { $feedback .= "geachte ".$pachternaam ; }

		$query = "INSERT INTO versl_gesch1 
VALUES(NULL, '$zoekpersoon', '$pusernaam', '$pemailadres', '$pvoornaam', '$pachternaam', 'passwoord', '', '', 0, '$datetime', '$pgebdat', '$relatietoon', 1,'','','$opdehoogte')";
		///INSERT INTO versl_gesch1 VALUES (NULL, '$zoekpersoon', '$pusernaam', '$pemailadres', '$pvoornaam', '$pachternaam', 'passwoord', '', '', 0, '$datetime', '$pgebdat', '$relatietoon', 1,'','','$opdehoogte');

		$result = mysql_query($query);
		if (!$result || mysql_affected_rows() < 1)
		{
			$fout = $errordatabase;
		}
		//@@@echo "<br>xxX". $fout."Xxx nieuw toegevoegd. rows is affected rows".mysql_affected_rows();
	}else{
		$query = "SELECT * 
				FROM versl_gesch1
				WHERE persoon_id = '$zoekpersoon'
				AND relatietot = '1'";
		$result = mysql_query($query);			
	//@@@	echo "<br>xxX". $fout."Xxx gezocht naar partner. rows is ".mysql_num_rows($result) ;
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
		echo "<p class='errortxt'>xxX". $fout."Xxx gezocht naar partner. rows is ".mysql_affected_rows($result)."</p>" ;
	}
if (mysql_num_rows($result) > 1)
{
$fout="Je mag me 'old fashioned' vinden maar ik kom meerdere mensen tegen die als jouw primaire partner staan aangegeven. Dat kan, dat mag natuurlijk... maar uhhh is er niet toevallig eentje iets meer primair dan de ander??? *grinnik* (tja, ik ben maar een computer en verwacht slechts 1 primaire(!) partner)";
}else{
$feedback = "<br>".$voornaam." ".$achternaam." word voortaan: ". $pvoornaam." ".$pachternaam ;
}
if ($fout ="")
{
$query = "UPDATE versl_gesch1
SET net_voornaam = '$pvoornaam',
net_achternaam = '$pachternaam',
net_gender = $pgender
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

?><body>
<b><img src="../pics/macsmiley.gif" border="0"> persoonsgegevens</b><P>&nbsp;</P>
<?php
///@@@ $fout = "";
//echo "<p>XXX".$zoekpersoon."XXX".$partner."XXX".$_SESSION['persoon_id']."XXX".$_SESSION['voornaam']."XXX";
/////

if ($fout != "")
{
	echo "<center><form><table border=0 width=100%>";
	echo "<tr><td><img src=\"../pics/macmandwn.gif\" alt=\"oeps\" width=\"23\" height=\"28\" border=\"0\"></td><td><b>Hey $voornaam, ik ondekte foutjes in de invoer:</b></td></tr>";
	echo "<tr><td>&nbsp;</td><td class='errortxt'><b>".$fout."</b></td></tr>";
	echo "<tr><td><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\"</td><td><INPUT TYPE=\"button\" VALUE=\" terug \" onClick=\"history.go(-1)\"></td></tr>";
	echo "</table></form></center>";  
}else{
	//net_id,persoon_id,user_name,emailadres,voornaam,achternaam,paswoord,remote_addr,confirm_hash,is_confirmed,date_created,relatietoon,relatietot,relatiegeeft,relatiekost,opdehoogte

	$vraag02 = "<tr><td>&nbsp;</td><td>&nbsp;</td><td><b>partner gegevens</b></td></tr>";
	$vraag02 .= "<tr><td><img src=\"../pics/mensje.gif\" alt=\"mens\"  width=\"10\" height=\"12\"  border=\"0\"></td><td>voornaam:</td><td><input name=\"pvoornaam\" type=\"text\" size=\"20\" maxlength=\"20\"></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td>achternaam:</td><td><input name=\"pachternaam\" type=\"text\" size=\"30\" maxlength=\"30\"></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">geboortedatum:</td><td>dag:<input name=\"pgebdag\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"dd\" onFocus=\"if(this.value=='dd')this.value='\".$gebdag.\"';\"> maand: <input name=\"pgebmaand\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"mm\" onFocus=\"if(this.value=='mm')this.value='\".$gebmaand.\"';\"> jaar: <input name=\"pgebjaar\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"jjjj\" onFocus=\"if(this.value=='jjjj')this.value='\".$gebjaar.\"';\"></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">geslacht:</td><td><input type=\"radio\" name=\"pgender\" value=\"0\">
		  mijn partner is van het vrouwelijk geslacht<br><input type=\"radio\" name=\"pgender\" value=\"1\">
		  mijn partner is van het mannelijk geslacht</td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td>toon:</td><td>Wat is de toon waarin jullie met elkaar spreken?: <SELECT NAME=\"relatietoon\"><option value=\"1\">lieve ...</option><option value=\"2\">beste ...</option><option value=\"3\">geachte ...</option></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td>samenwerking:</td><td><input type=\"checkbox\" name=\"opdehoogte\" value=\"1\">
mijn partner mag op de hoogte worden gesteld van dit traject <font color=\"#800040\">* (N.B. privacy wetgeving)</font></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td>email:</td><td><input name=\"pemailadres\" type=\"text\" size=\"35\" maxlength=\"35\"></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td colspan=\"2\"><font color=\"#800040\"><img src=\"../pics/uitroeptekentje.gif\" alt=\"klemtoon\" boder=0><i>* 
als je samenwerking wenst met jouw partner dan is het aanvinken hier verplicht in verband met de wet op de privacy en persoonsgegevens. anders mogen wij geen berichten uitzenden naar derden (en het zal duidelijk zijn dat we dan ook een email nodig hebben).</i></font></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type=\"submit\" name=\"submit\" value=\"".$submittxt."\"> &nbsp; &nbsp; <input type=\"reset\" name=\"reset\" value=\"".$resettxt."\"></td></tr>";

echo "Beste $voornaam,<br>";
	echo "Momenteel heb je een (vaste) relatie met $pvoornaam $pachternaam, geboren $pgebdag/$pgebmaand/$pgebjaar - een ";
	if ($pgender == "")
	{
		echo "...(uhhh... is je partner <i>echt </i>geslachtsloos?)";
	}
	if ($pgender == 1)
	{
		echo "man";
	}else{
		echo"vrouw";
	}
	echo ", nu ongeveer ".(date('Y') - $pgebjaar)." jaar oud.";
}
if ($pgebjaar < (date('Y') - 100) ) 
{
	echo "... (waardoor ik je partner wel een beetje uhhhh 'op leeftijd' vind... heb je wel <i>vier</i> cijfers ingevuld in het geboortejaar?)";
}
	echo "<br>&nbsp; &nbsp;<i> (ook hier: klopt het voorgaande niet, ga dan even terug, want zo vaak zal je niet op deze pagina terecht komen)</i><br>";
	echo "<center><form><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\">&nbsp; &nbsp; <INPUT TYPE=\"button\" VALUE=\" terug \" onClick=\"history.go(-1)\"> (klik hier om e.e.a. alsnog in te vullen)</form></center>"; 
//@@}
?>
<P> Klopt het voorgaande niet, klik dan hier om even terug te gaan en de gegevens te verbeteren, want zo vaak zal je niet op 
  deze pagina terecht komen.<br>
<center><form>
	<img src="../pics/mensje.gif" alt="mens invoer"  width="10" height="12"  border="0">&nbsp; 
	&nbsp; 
	<INPUT TYPE="button" VALUE=" terug " onClick="history.go(-1)"> (klik hier om e.e.a. nogmaals in te kunnen vullen)
</form></center>
<?php
if ($partner == "1")
{
echo "<p><b>over jouw partner...</b><br>";
echo "Je hebt aangegeven een partner te hebben. Daar zal ik in de toekomst nog wel 
  eens aan refereren. Daarom zij er een paar dingen die ik over hem/haar wil weten. 
  Daarbij zal ik ook vragen om emailadres. Dat kun je gerust leeg laten maar het 
  zal duidelijk zijn dat ik dan mensen niet op de hoogte kan brengen.<br>
  Dit kan altijd achteraf worden ingevuld als je daar anders over mocht denken 
  in de toekomst.</p>";
echo "<p>Zelf denk ik meestal dat je het verst komt als iedereen op een eerlijke manier 
  met zichzelf en met de ander omgaat. Maar wil je dat liever niet, bijvoorbeeld 
  uit angst dat jouw partner er achter komt dat jij serieus aan het werk bent 
  met een lastig automatisme dat je bij jezelf ontdekt hebt? Ook OK <img src=\"../pics/macwink.gif\" border=\"0\" align=\"texttop\">";
echo "<br><i>(even zonder dollen: ik kan mij uitstekend voorstellen dat er echt hele goede redenen zijn om niets te willen zeggen tegen je partner. Ik ga er meestal wel vanuit dat je samen het verste komt als je eerlijk en open kunt zijn naar elkaar... maar jij zal er vast over hebben nagedacht voor je aankruist of je dit project al-dan-niet samen wilt werken met jouw partner)</i></p>";
}
?>
<p>&nbsp;</P>
<?php
//@@}
include "layoutinc/inc.nltemplate2.php";
?>
<center>
<form name="personalia" action="persoon_alia2.php" method="post">
<?php 
echo "<input name=\"voornaam\" type=\"hidden\" value=\"$voornaam\">";
echo "<input name=\"achternaam\" type=\"hidden\" value=\"$achternaam\">";
echo "<input name=\"gebdag\" type=\"hidden\" value=\"$gebdag\">";
echo "<input name=\"gebmaand\" type=\"hidden\" value=\"$gebmaand\">";
echo "<input name=\"gebjaar\" type=\"hidden\" value=\"$gebjaar\">";
echo "<input name=\"gender\" type=\"hidden\" value=\"$gender\">";
echo "<input name=\"partner\" type=\"hidden\" value=\"$partner\">";
echo "<input name=\"kids\" type=\"hidden\" value=\"$kids\">";
echo "<input name=\"inwonend\" type=\"hidden\" value=\"$inwonend\">";
?>
<table width="100%"  border="0">
<?php 
if ($feedback!= "")
{
	echo "<tr><td>&nbsp;</td><td colspan=\"2\"><div class=\"feedbacktxt\">".$feedback."</div></td></tr>";
}
echo $vraag02 ?>
<?php if ($partner == "1")
{
echo $vraag02 ;
}else{
echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type=\"submit\" name=\"submit\" value=\"verder gaan\"> Klik hier als je er aan toe bent om verder te gaan met een paar vragen over jouw alcohol gebruik</td></tr>";
} ?>
</table></form>
</center>
                    
<p>&nbsp;</p>
  <?php
include "layoutinc/inc.nltemplate3.php";
?>
