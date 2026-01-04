<?php

session_start();
$persoon_id = $_SESSION['persoon_id'];
$zoekpersoon = $persoon_id;

$gender = $_SESSION['gender'];
$voornaam = $_SESSION['voornaam'];

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
$hiero1="partner gegevens";

$layoutnr="425";

include "layoutinc/inc.nltemplate0.php";
include "persoon_aaa_inc.php";
	
if ($submit != "")
{
	$fout = "";
	$pemailadres = trim($pemailadres); 
	if($pemailadres != "")
	{
		$pemailadres=strtolower($pemailadres);
		if(!ereg("^([._a-z0-9-]+[._a-z0-9-]*)@(([a-z0-9-]+\.)*([a-z0-9-]+)(\.[a-z]{2,3})?)$", $pemailadres))
		{
			$fout = "<br>uhhh ik lees <img src=\"../pics/envelopje.jpg\" alt=\"enveloppe\" width=\"17\" height=\"13\" border=\"0\"> [".$pemailadres."], dit lijkt geen bestaand emailadres te zijn. Misschien wil je dat verbeteren?";
		}
	}
	if ($opdehoogte == "1" && $pemailadres == "")
	{
		$fout = "<br>Sorry! Maar als je <i>wel </i>wilt dat ik contact opneem met je partner en je geeft g&eacute;&eacute;n emailadres aan, dan geef je tegenstrijdige signalen <img src=\"../pics/macsmiley.gif\" alt=\"*glimlach*\">. Misschien wil je dat verbeteren?";
	}
	if ($partner =="1" && $pvoornaam == "" && $pachternaam == "")
	{
		echo "<br>jammer dat je deze site niet genoeg vertrouwt om de naam van je partner aan te geven <img src=\"../pics/macsmiley.gif\" alt=\"*glimlach*\">. Het was voldoende geweest om het kruisje niet(!) te zetten bij de vraag of je wilde dat jouw partner op de hoogte wordt gebracht...";
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
		//echo "<table width=\"100%\" heigth=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td valign=\"bottom\">&nbsp;</td><td valign=\"top\" align=\"right\"><a href=\"index.php\" target=\"_self\" class=\"menubutton\">menu</a></td></tr></table>";
		echo "<p><i>fijn dat ik niks hoefde te missen in jouw antwoorden...</i></p>";
		///   Naar database wegschrijven
		//@@@@
		include '../assets/dbconnect.php';
		$query = "SELECT * 
		FROM steunnetwerk
		WHERE persoon_id = '$zoekpersoon'
		AND relatietot = '1'";
		$result = mysql_query($query);
		if (!$result)
		{
			$fout = $errormain;
		}else{
			$pusernaam = $pvoornaam.$zoekpersoon;
			$feedback = "<br>voornaam wordt: ". $pvoornaam."<BR>achternaam wordt: ".$pachternaam."<br>partner-<b>usernaam wordt: ". $pusernaam ;
			$feedback .= "</b><br>emailadres is: ". $pemailadres."<br>de geboortedatum is: ".$pgebdat."<br>de toon van de relatie is: ";
			if ($relatietoon == 1) { $feedback .= "lieve ".$pvoornaam ; }
			if ($relatietoon == 2) { $feedback .= "beste ".$pvoornaam ; }
			if ($relatietoon == 3) { $feedback .= "geachte ".$pachternaam ; }
			if (mysql_num_rows($result) < 1)
			{
				//@@
				echo "foutje 2".mysql_num_rows($result);
				$feedback = "<br>info is toegevoegd ".$feedback;
		
				$query = "INSERT INTO steunnetwerk 
		VALUES(NULL, '$zoekpersoon', '$pusernaam', '$pemailadres', '$pvoornaam', '$pachternaam', 'passwoord', '', '', 0, '$datetime', '$pgebdat','$pgender','$relatietoon', 1,'','','$opdehoogte','0')";
				$result = mysql_query($query);
				if (!$result || mysql_affected_rows() < 1)
				{
					$fout = $errordatabase;
				}
				//@@@ echo "<br>xxX". $fout."@@@ nieuw toegevoegd. rows is affected rows".mysql_affected_rows();
			}else{
				if (fout=="" || mysql_num_rows($result) > 0 )
				{
					$feedback = "<br>info is veranderd in ".$feedback;
					$query = "UPDATE steunnetwerk
					SET net_emailadres = '$pemailadres',
					net_voornaam = '$pvoornaam',
					net_achternaam = '$pachternaam',
					net_gender = '$pgender',
					net_user_name = '$pusernaam',
					net_gebdat = '$pgebdat',
					relatietoon = '$relatietoon',
					opdehoogte = '$opdehoogte'
					WHERE persoon_id = '$zoekpersoon'
					AND relatietot = '1'";
					$result = mysql_query($query);
					if (!$result || mysql_affected_rows() < 1)
					{
					///@@@	$fout = $errordatabase;
					///@@@ik snap niet waarom ik hier de error krijg maar het lijkt allemaal goed te gaan
					
				/// echo "<br>xxX@@@@ $query". $fout."Xxx update probleem. rows is affected rows".mysql_affected_rows();
					}
				}
				//mysql_free_result($result);
			}
	///@@@ ````nog kijken wst ik naar psrtnerds verstuur		verzendmail($naaradres,$vanadres,$verzendtekst,$verzendtitel,laterdagen(7),$zoeknummer);//$zoeknummer=zoeknummer();

		}
	}
}

if ($submit == "")
{
///   Naar database wegschrijven
		//@@@@
		include '../assets/dbconnect.php';
	$query = "SELECT * 
	FROM steunnetwerk
	WHERE persoon_id = '$zoekpersoon'
	AND relatietot = '1'";
	$result = mysql_query($query);
	if (!$result)
	{
		$fout = $errormain;
	}else{
		if (mysql_num_rows($result) > 0)
		{
			$row = mysql_fetch_assoc($result);
			extract($row);
		}
	}
	$layoutnr="260";
	include "layoutinc/inc.nltemplate1.php";
	echo "<img src=\"../pics/macsmiley.gif\" border=\"0\"> <b>over jouw partner, ".$voornaam."</b><BR>";
	echo "Als je dit invult geef je ermee aan dat je een partner hebt. Daar zal ik dan in de toekomst nog wel 
	  eens aan refereren.<BR>Daarom zij er een paar dingen die ik over hem/haar wil weten. 
	  Daarbij zal ik ook vragen om emailadres. Dat kun je gerust leeg laten maar het 
	  zal duidelijk zijn dat ik dan mensen niet op de hoogte kan brengen.<br>
	  Dit kan altijd achteraf worden ingevuld als je daar anders over mocht denken 
	  in de toekomst.</p>";
	echo "<p>Zelf denk ik meestal dat je als partners het verst komt als iedereen op een eerlijke manier 
	  met zichzelf en met de ander omgaat. Maar wil je dat liever niet, bijvoorbeeld 
	  uit angst dat jouw partner er achter komt dat jij serieus aan het werk bent 
	  met een lastig automatisme dat je bij jezelf ontdekt hebt?.. da's ook OK <img src=\"../pics/macwink.gif\" border=\"0\" align=\"texttop\">";
	echo "<br><i>(even zonder dollen: ik kan mij best voorstellen dat er echt hele goede redenen zijn om niets te willen zeggen tegen je partner. Hoewel ik er meestal wel vanuit ga dat je samen het verste komt als je eerlijk en open kunt zijn naar elkaar... maar jij zal er vast over hebben nagedacht voor je aankruist of je dit project al-dan-niet samen wilt werken met jouw partner)</i></p>";
}else{
	include "layoutinc/inc.nltemplate1.php";
}
?>
<?php
if ($fout != "")
{
	echo "<center><form><table border=0 width=100%>";
	echo "<tr><td><img src=\"../pics/macmandwn.gif\" alt=\"oeps\" width=\"23\" height=\"28\" border=\"0\"></td><td><b>Ik ondekte een foutje in de invoer:</b></td></tr>";
	echo "<tr><td>&nbsp;</td><td class='errortxt'><b>".$fout."</b></td></tr>";
	echo "<tr><td><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\"</td><td><INPUT TYPE=\"button\" VALUE=\" terug \" onClick=\"history.go(-1)\"></td></tr>";
	echo "</table></form></center>";  
}else{
	$vraag02 = "<tr><td>&nbsp;</td><td>&nbsp;</td><td><b>partner gegevens</b></td></tr>";
	$vraag02 .= "<tr><td><img src=\"../pics/mensje.gif\" alt=\"mens\"  width=\"10\" height=\"12\"  border=\"0\"></td><td>voornaam:</td><td><input name=\"pvoornaam\" type=\"text\" size=\"20\" maxlength=\"20\" value=\"".$net_voornaam."\"></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td>achternaam:</td><td><input name=\"pachternaam\" type=\"text\" size=\"30\" maxlength=\"30\" value=\"".$net_achternaam."\"></td></tr>";
  if (isSet($net_gebdat))
  {
  	$gebdatum = strtotime($net_gebdat);
  	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">geboortedatum:</td><td>dag:<input name=\"pgebdag\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"".date('d', $gebdatum)."\"> maand: <input name=\"pgebmaand\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"".date('m', $gebdatum)."\" > jaar: <input name=\"pgebjaar\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"".date('Y', 	$gebdatum)."\"></td></tr>";
	}else{
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">geboortedatum:</td><td>dag:<input name=\"pgebdag\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"dd\" onFocus=\"if(this.value=='dd')this.value='\".$gebdag.\"';\"> maand: <input name=\"pgebmaand\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"mm\" onFocus=\"if(this.value=='mm')this.value='\".$gebmaand.\"';\"> jaar: <input name=\"pgebjaar\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"jjjj\" onFocus=\"if(this.value=='jjjj')this.value='\".$gebjaar.\"';\"></td></tr>";
	}
///$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">geboortedatum:</td><td>dag:<input name=\"pgebdag\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"dd\" onFocus=\"if(this.value=='dd')this.value='\".$gebdag.\"';\"> maand: <input name=\"pgebmaand\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"mm\" onFocus=\"if(this.value=='mm')this.value='\".$gebmaand.\"';\"> jaar: <input name=\"pgebjaar\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"jjjj\" onFocus=\"if(this.value=='jjjj')this.value='\".$gebjaar.\"';\"></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">geslacht:</td><td><input type=\"radio\" name=\"pgender\" value=\"0\" ";
	if ($pgender == 0)
	{
		$vraag02 .= "checked";
	}
	$vraag02 .=	"> mijn partner is van het vrouwelijk geslacht<br><input type=\"radio\" name=\"pgender\" value=\"1\"";
	if ($pgender == 1)
	{
		$vraag02 .= "checked";
	}
	$vraag02 .= "> mijn partner is van het mannelijk geslacht</td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td>toon:</td><td>Wat is de toon waarin jullie met elkaar spreken?: <SELECT NAME=\"relatietoon\"><option value=\"1\">lieve ...</option><option value=\"2\">beste ...</option><option value=\"3\">geachte ...</option></td></tr>";
	$vraag02 .= "<tr><td><img src=\"pics/mensjes.gif\" alt=\"anderen\" width=\"16\" height=\"16\" border=\"0\"></td><td>samenwerking:</td><td><input type=\"checkbox\" name=\"opdehoogte\" value=\"1\">
mijn partner mag op de hoogte worden gesteld van dit traject <font color=\"#800040\">*<br>&nbsp; &nbsp; &nbsp; (N.B. privacy wetgeving)</font></td></tr>";
	$vraag02 .= "<tr><td><img src=\"../pics/envelopje.jpg\" alt=\"enveloppe\" width=\"17\" height=\"13\" border=\"0\"></td><td>email:</td><td><input name=\"pemailadres\" type=\"text\" size=\"35\" maxlength=\"35\" value=\"".$net_emailadres."\"></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td colspan=\"2\"><font color=\"#800040\"><img src=\"../pics/uitroeptekentje.gif\" alt=\"klemtoon\" boder=0><i>* 
als je samenwerking wenst met jouw partner dan is het aanvinken hier verplicht in verband met de wet op de privacy en persoonsgegevens. anders mogen wij geen berichten uitzenden naar derden.</i></font></td></tr>";
	$vraag02 .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type=\"submit\" name=\"submit\" value=\"".$submittxt."\"> &nbsp; &nbsp; <input type=\"reset\" name=\"reset\" value=\"".$resettxt."\"></td></tr>";
	
	if ($submit != "")
	{
		///
		$temptext = "Beste $voornaam,";
		echo "<img src=\"../pics/macsmiley.gif\" border=\"0\"> <b>".$temptext. "</b><br>";
		$sendtext = $temptext. "\n";
		$temptext = "Momenteel heb je een (vaste) relatie met $pvoornaam $pachternaam, geboren $pgebdag/$pgebmaand/$pgebjaar - een ";
		$sendtext .= $temptext;		
		if ($pgender == "")
		{
			echo "...(uhhh... is je partner <i>echt </i>geslachtsloos?)";
		}
		if ($pgender==1)
		{
			$temptext .= "man";
		}
		if ($pgender==0)
		{
			$temptext .= "vrouw";
		}
		$temptext .= ", nu ongeveer ".(date('Y') - $pgebjaar)." jaar oud.";
		$sendtext .= $temptext;
		echo $temptext;

		if ($pgebjaar < (date('Y') - 100) ) {
			echo "... (waardoor ik je partner wel een beetje uhhhh 'op leeftijd' vind... heb je wel <i>vier</i> cijfers ingevuld in het geboortejaar?)";
		}
		
		$sendtext .= "\n";
		echo "<br><img src=\"../pics/macsmiley.gif\" border=\"0\"> ";
		if ($opdehoogte==1)
		{
			$temptext = "Je hebt aangegeven dat je ";
			if ($pgender==1)
			{
				$temptext .= "hem";
			}else{
				$temptext .= "haar";
			}
			$temptext .= "op de hoogte wilt stellen van dit traject. ";
			if ($pemailadres =="")
			{
				$temptext .= "Maar je hebt daarvoor nog geen email adres aangegeven... ?!";
			}else{
				$temptext .= "En je hebt het emailadres $pemailadres opgegeven om ";
				if ($pgender==1)
				{
					$temptext .= "hem";
				}else{
					$temptext .= "haar";
				}
				$temptext .= " op de hoogte te houden.";
			}
		}else{	
			$temptext = "Je hebt aangegeven dat je ";
			if ($pgender==1)
			{
				$temptext .= "hem";
			}else{
				$temptext .= "haar";
			}
			$temptext .= " NIET op de hoogte wilt stellen van dit traject. Dus dat je (wat jouw partner betreft) deze poging liever alleen onderneemt. ";
			if ($pemailadres !="")
			{
				$temptext .= "Toch heb je wel een email adres aangegeven ?!<br>";
			}
		}
		$sendtext .= $temptext;
		echo $temptext;
					if ($pemailadres =="")
			{
				echo "(zou het kunnen zijn dat het verstandig zou zijn om er nog eens over te denken of het <i>toch</i> prettig zou wezen om  ";
				if ($pgender==1)
				{
					echo "hem";
				}else{
					echo "haar";
				}
				echo " op de hoogte te houden? maar daar kan je hier later natuurlijk ook nog op terugkomen...)";
			}

		echo "<br><p><i> (ook hier: klopt het voorgaande niet, ga dan even terug, want zo vaak zal je niet op deze pagina terecht komen)</i><br>";
		echo "<p>&nbsp;</p><p>&nbsp;</p><center><form><table border=\"0\"><tr><td rowspan=\"3\"><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\">&nbsp; &nbsp; <td><INPUT TYPE=\"button\" VALUE=\" terug \" onClick=\"history.go(-1)\"> (klik hier om e.e.a. alsnog in te vullen)</tr>";
		echo "<tr><td><INPUT TYPE=\"button\" VALUE=\" terug naar menu \" onClick=\"document.location.href='persoon_aaa_menu.php';\"> (klik hier voor het huidige sub-menu)</td></tr>"; 
		echo "<tr><td><INPUT TYPE=\"button\" VALUE=\" ga verder \" onClick=\"document.location.href='versl_gesch1.php';\"> (klik hier om volgende vragen te beantwoorden)</td></tr></table></form></center>"; 
		$vraag02 = "";
		$submit = "";	
	}
}

include "layoutinc/inc.nltemplate2.php";
?>
<form name="personalia" action="<?php $_SERVER['PHP_SELF']?>" method="post">
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
