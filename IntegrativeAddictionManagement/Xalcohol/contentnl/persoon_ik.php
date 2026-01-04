<?php
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

// ik begrijp niet waarom deze (nogmaals) gedeclareerd worden op deze manier
//$zoekpersoon = $_SESSION['persoon_id'];
//$gender = $_SESSION['gender'];
//$voornaam = $_SESSION['voornaam'];

$layoutnr="450";

include "layoutinc/inc.nltemplate0.php";
include "persoon_aaa_inc.php";
	
	
	

if ($submit != "")
{
	$fout = "";
	if ($voornaam == "")
	{
		$fout .= "wil je wel je voornaam aangeven, alsjeblieft?<br>";
	}
	//if ($achternaam == "")
	//{
	//	$fout .= "wil je wel je achternaam aangeven, alsjeblieft?<br>";
	//}
	if ($gebdag == "" or $gebdag =="dd")
	{
		$gebdag = "01";
	}
	if ($gebmaand == "" or $gebmaand =="mm")
	{
		$gebmaand = "01";
	}
	if ($gebjaar == "" or $gebjaar =="jjjj")
	{
		$fout .= "wil je wel je geboortejaar aangeven, alsjeblieft?<br>";
	}
	if ($gender == "")
	{
		$fout .= "wil je wel jouw geslacht aangeven, alsjeblieft?<br>";
	}
	if ($partner == "")
	{
		$fout .= "wil je wel aangeven of je een min-of-meer vaste relatie hebt, alsjeblieft? (N.B. als dat momenteel onduidelijk is, dan graag invullen naar welke kant het overhelt. Je kunt het altijd nog veranderen...)<br>";
	}
	if ($kids == "")
	{
		$fout .= "wil je wel aangeven hoeveel kinderen je hebt, alsjeblieft? (N.B. bij nul kids dus ook graag een 0 invullen)<br>";
	}
	if ($inwonend == "")
	{
		$fout .= "wil je ook aangeven hoeveel kinderen je bij jou in huis hebt wonen, alsjeblieft? (N.B. bij nul kids dus ook graag een 0 invullen)<br>";
	}

	
	if ($fout == "")
	{
		// @@@@  misschien alleen terug naar menu?  @@@ echo "<table width=\"100%\" heigth=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td valign=\"bottom\">&nbsp;</td><td valign=\"top\" align=\"right\"><a href=\"index.php\" target=\"_self\" class=\"menubutton\">menu</a></td></tr></table>";
		echo "<p>&nbsp;</p><p>fijn dat ik niks hoefde te missen in jouw antwoorden...";
		///Naar database wegschrijven
		////@@@@ 
		include '../assets/dbconnect.php';
		///TABLE personalia
		$zoekpersoon = $_SESSION['persoon_id'];
		$query = "SELECT * 
                  FROM personalia
                  WHERE persoon_id = '$zoekpersoon'";
        $result = mysql_query($query);
        if (!$result || mysql_num_rows($result) < 1)
		{
			$fout = "@@@@READ ".$errormain;
			mysql_free_result($result);
        } else {
          	$query = "UPDATE personalia
                    SET voornaam = '$voornaam',
                    achternaam = '$achternaam',
                    gebdat = '$gebjaar-$gebmaand-$gebdag',
					gender = '$gender'
					WHERE persoon_id = $zoekpersoon";
			
			$result = mysql_query($query) or die('@@@ Query: '.$query.'<br><br>'.mysql_error());
          	if (!$result || mysql_affected_rows() < 1)
		  	{
			///	$fout = "WRITE ".$errordatabase;
      		}else{
				$_SESSION['voornaam'] = $voornaam;
				$_SESSION['achternaam'] = $achternaam;
				$_SESSION['gebdat'] = $gebjaar-$gebmaand-$gebdag;
				$_SESSION['gender'] = $gender;
			}
			//mysql_free_result($result);
		}
		///@@@@  mysql_free_result($result);
		//////
		///@@@  echo "X".$fout."X".$zoekpersoon."<p>'$zoekpersoon', '$partner', '$kids', '$kidsinwonend', '$woon_sit', '$opleidingniv', '$werk_situatie', '$arbeidsproblem', '$werkstudie', '$huishouden', '$opvoedingzorg'";
		//@@@ $fout = "";
		///
		
		// TABLE maatschaplktabel
		$query = "SELECT * 
               FROM maatschaplktabel
               WHERE persoon_id = '$zoekpersoon'";
   		$result = mysql_query($query);
 ///  		$result = mysql_query($query) or die('@@@ Query: '.$query.'<br>'.mysql_error());
    	if (!$result || mysql_num_rows($result) < 1)
		{
			$query = "INSERT INTO maatschaplktabel (persoon_id, partner_id, kids, kidsinwonend, woon_sit, opleidingniv, werk_situatie, arbeidsproblem, werkstudie, huishouden, opvoedingzorg)
				VALUES('$zoekpersoon', NULL, '$kids', '$kidsinwonend', '$woon_sit', '$opleidingniv', '$werk_situatie', '$arbeidsproblem', '$werkstudie', '$huishouden', '$opvoedingzorg')";
		} else {
			//    $query = "UPDATE maatschaplktabel  SET partner_id = '$partner_id',  kids = '$kids',   kidsinwonend = '$inwonend', WHERE persoon_id = '$zoekpersoon'";
       		$query = "UPDATE maatschaplktabel
                SET kids = '$kids',
         		partner_id = '$partner',
        		kidsinwonend = '$inwonend'
				WHERE persoon_id = '$zoekpersoon'";
		}
//echo $query;
       		$result = mysql_query($query) or die('<P>@@@ foute Query: '.$query.'<br><br>'.mysql_error());
 //	  		if (!$result || mysql_affected_rows() < 1)
  //     		{
//				$fout = $errordatabase;
//			}
//		 mysql_free_result($result);
	
		///@@@
		//echo "xxxX".$fout."Xxxxx";
		///
		//$result = mysql_query($query);
		//if (!$result)
		//{
		//	$fout = $errormain;
		//}else{
		//	if (mysql_num_rows($result) > 0)
		//	{
		//		$row = mysql_fetch_assoc($result);
		//		extract($row);
		//	}
	}
}

if ($submit == "")
{
	//@@@@
	include '../assets/dbconnect.php';
	$query = "SELECT * FROM maatschaplktabel
	WHERE persoon_id = '$zoekpersoon'";
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

	$query = "SELECT * FROM personalia
	WHERE persoon_id = '$zoekpersoon'";
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
	$layoutnr="290";
	include "layoutinc/inc.nltemplate1.php";
	echo "<img src=\"../pics/macsmiley.gif\" border=\"0\"> <b>Beste Lezer</b>";
	if ($voornaam != '')
	{
		echo " (".$voornaam.", toch?)";
	}
	echo "Ik heb graag dat je hieronder een aantal gegevens van jou aangeeft om met je 
  samen te werken in het komend traject.</p>";
	if ($fout)
	{
		 echo "<p class='errortxt'><b>Ik heb nog niet jouw ".$fout."ontvangen... Doe je dat even?</b></p><p>&nbsp;</p>";
	}
	echo "<p>Als het goed is dan zullen we nog wel het e.e.a. mailen met elkaar dus ik denk dat het 
  handig is als je jouw echte voornaam of roepnaam aangeeft. Aan een verslaving 
  werken is namelijk nogal persoonlijk... <i>maak</i> het ook tot een persoonlijk 
  iets voor jezelf.<br>";
  	echo "Daarom kan je ook beter geen 'nick' opgeven. Je kunt je misschien voorstellen 
  dat een 'nickname' vaak staat voor een <i>deel</i> van de persoonlijkheid. En 
  dat zoiets de antwoorden be&iuml;nvloedt.<BR>";
  	echo "Als ik bijvoorbeeld een vraag zou stellen als: &quot;Hoe heb je geslapen vannacht, 
  Jaap?&quot; dan krijg ik vast een ander antwoord als &quot;Hoe heb je geslapen 
  vannacht, Dark-Prince";
  if ($gender == "0") {echo "ss";}  
   echo "-Of-The-Night?&quot; <i><img src=\"../pics/macwink.gif\" width=\"16\" height=\"14\" align=\"texttop\"></i>*grinnik*</p>";
	echo "<p>Dus hieronder voornaam, geslacht en minstens je geboortejaar graag een beetje 
  naar waarheid (en niet zo zeer naar wenselijkheid) invullen, AUB? <img src=\"../pics/macsmiley.gif\" border=\"0\" align=\"texttop\">";
  	echo "<br><i>(mocht jouw privacy belangrijk zijn of als je echt terecht bang zou zijn voor herkenning, dan k&agrave;n je bijvoorbeeld een jaartje smokkelen en/of het veld van de achternaam leeg laten...)</i></p><p>Vriendelijke groet,<br>Hans R. J. West.</P>";
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
		$vraag02 = "<tr><td><img src=\"../pics/mensje.gif\" alt=\"mens\"  width=\"10\" height=\"12\"  border=\"0\"></td><td>voornaam: <font color=\"#800040\">*</font></td><td><input name=\"voornaam\" type=\"text\" value=\"".$voornaam."\" size=\"20\" maxlength=\"20\"></td></tr>";
		$vraag02 .= "<tr><td>&nbsp;</td><td>achternaam:</td><td><input name=\"achternaam\" type=\"text\" value=\"".$achternaam."\" size=\"30\" maxlength=\"30\"></td></tr>";
///@@@		$vraag02 .= "<tr><td>&nbsp;</td><td>SMS-nummer:</td><td><input name=\"smsfoon\" type=\"text\" value=\"".$smsfoon."\" size=\"15\" maxlength=\"15\"><i>(SMS-telefoon voor de SMS-service van SMA)</i></td></tr>";

  if (isSet($gebdat))
  {
  	$gebdatum = strtotime($gebdat);
	$gebjaar = substr($gebdat,0,4);
	$gebmaand = date('m', $gebdatum);
	$gebmaand = substr($gebdat,5,2);
	$gebdag = date('d', $gebdatum);
	$gebdag = substr($gebdat,8,2);
	
	$vraag02 .= "<!--tr><td>&nbsp;</td><td>@@@gebdat".$gebdat.":@@@gebdatum:".$gebdatum."@".$gebdag."@".$gebmaand."@@".date('Y', $gebdatum)."<br>@@".date('Y', $gebdat)."@@jjjj:".$gebjaar."</td></tr>";
  	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">geboortedatum:<font color=\"#800040\">*</font></td><td>dag:<input name=\"gebdag\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"".date('d', $gebdat)."\"> maand: <input name=\"gebmaand\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"".date('m', $gebdat)."\" > jaar: <input name=\"gebjaar\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"".$gebjaar."\"></td></tr-->";
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">geboortedatum:<font color=\"#800040\">*</font></td><td><input name=\"gebdag\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"".$gebdag."\" onFocus=\"if(this.value=='dd')this.value='\".$gebdag.\"';\"> (dag) / <input name=\"gebmaand\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"".$gebmaand."\" onFocus=\"if(this.value=='mm')this.value='\".$gebmaand.\"';\"> (maand) / <input name=\"gebjaar\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"".$gebjaar."\"> (jaar)</td></tr>";
	}else{
	$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">geboortedatum: <font color=\"#800040\">*</font></td><td><input name=\"gebdag\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"dd\" onFocus=\"if(this.value=='dd')this.value='\".$gebdag.\"';\"> (dag) / <input name=\"gebmaand\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"mm\" onFocus=\"if(this.value=='mm')this.value='\".$gebmaand.\"';\"> (maand) / <input name=\"gebjaar\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"jjjj\" onFocus=\"if(this.value=='jjjj')this.value='\".$gebjaar.\"';\"> (jaar)</td></tr>";
	}
  if (isSet($gender))
{
  		$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">geslacht: <font color=\"#800040\">*</font></td><td><input type=\"radio\" name=\"gender\" value=\"0\"";
  		if ($gender == "0") { $vraag02 .= "checked";}
		$vraag02 .= "> ik ben van het vrouwelijk geslacht<br>";
		$vraag02 .= "<input type=\"radio\" name=\"gender\" value=\"1\"";
  		if ($gender == "1") { $vraag02 .= "checked";}
		$vraag02 .= "> ik ben van het mannelijk geslacht</td></tr>\n";
}else{
		$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">geslacht: <font color=\"#800040\">*</font></td>\n<td><input type=\"radio\" name=\"gender\" value=\"0\"> ik ben van het vrouwelijk geslacht<br>\n";
		$vraag02 .= "<input type=\"radio\" name=\"gender\" value=\"1\"> ik ben van het mannelijk geslacht</td></tr>\n";
}
if (isSet($partner_id))
{
		if ($partner_id < 1) {$partner_id=1;}
		$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">partner:</td><td><input type=\"radio\" name=\"partner\" value=\"0\" ";
  		if ($partner_id == "") { $vraag02 .= "checked";}
		$vraag02 .= "> ik ben alleenstaand en alleen gaand<br><input type=\"radio\" name=\"partner\" value=\"$partner_id\" ";
  		if ($partner_id > 1) { $vraag02 .= "checked";}
		$vraag02 .= ">\n";
}else{
		$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">partner:</td><td><input type=\"radio\" name=\"partner\" value=\"0\"> ik ben alleenstaand en alleen gaand<br><input type=\"radio\" name=\"partner\" value=\"1\">\n";
}
		$vraag02 .= "ik heb een (redelijk) vaste relatie\n<!--  Note1 -->
  <a href=\"javascript:void(0);\" id=\"note1_title\" class=\"note\" onclick=\"showNote('note1');\">?</a> <span id=\"note1_body\" class=\"notehidden\"><br>";
		$vraag02 .= "<div class=\"notebody\" align=\"left\"><table class=\"notetitle\" cellspacing=\"0\" cellpadding=\"0\"><tr><td height=\"12\">Toelichting : VASTE partner</td>";
		$vraag02 .= "<td align=\"right\"><a href=\"javascript:void(0);\" onclick=\"hideNote('note1');\" class=\"notetitle\" >[&#8722;]</a></td></tr></table>\n";
  		$vraag02 .= "<p>Dit bedoel ik niet flauw maar het komt nogal eens voor dat rond een verslaving
		   de relatie onder druk is komen te staan en dat mensen mij antwoorden op deze vraag dat zij niet zeker weten hoe vast hun relatie nog is...</p></div></span>";
		$vraag02 .= "<p><span class=\"notehidden\"></span></p><span class=\"notehidden\"><noscript></noscript></span><!-- / Note -->\n";
		$vraag02 .= "</td></tr>\n";
		$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">kinderen:</td><td>hoeveel kinderen heb je <input name=\"kids\" type=\"text\" size=\"2\" maxlength=\"2\" value=\"$kids\">\n<font color=\"#800040\">*</font><br>&nbsp;&nbsp;- waarvan bij jou inwonend <input name=\"inwonend\" type=\"text\" size=\"2\" maxlength=\"2\" value=\"$kidsinwonend\"> <font color=\"#800040\">*</font></td></tr>";
		$vraag02 .= "<tr><td><img src=\"../pics/mensje.gif\" alt=\"mens\"  width=\"10\" height=\"12\"  border=\"0\"></td><td>&nbsp;</td><td><input type=\"submit\" name=\"submit\" value=\"".$submittxt."\"> &nbsp; &nbsp; <input type=\"reset\" name=\"reset\" value=\"".$resettxt."\"></td></tr>";

	if ($submit != "")
	{
	///
		echo "Beste ".$voornaam.",<br>";
		echo "Als ik het goed begrijp ben je een "; 
		if ($gender == 1)
		{
			echo "man";
		}else{
			echo"vrouw";
		}
		echo ", geboren in het jaar ".$gebjaar." - nu ongeveer ".(date('Y') - $gebjaar)." jaar oud";
		if ($gebjaar < (date('Y') - 100) )
		{
			echo "... (waardoor ik je wel een beetje uhhhh 'op leeftijd' vind... heb je wel <i>vier</i> cijfers ingevuld in het geboortejaar?)";
		}
		echo ".<br>Momenteel heb je "; 
		if ($partner == 0) {
			echo "g";
		}
		echo "een (vaste) relatie en je hebt ";
		if ($kids == 0)
		{
			echo "g&eacute;&eacute;n kinderen";
		}else{
		if ($kids == 1)
		{
			echo "&eacute;&eacute;n kind";
		}else{
			echo "$kids kinderen";
		}
		echo "(waarvan $inwonend inwonend).";} 
		echo "<P> Klopt het voorgaande niet, klik dan hier om even terug te gaan en de gegevens te verbeteren, want zo vaak zal je niet op 
		deze pagina terecht komen.<br>";
		echo "<p>&nbsp;</p><p>&nbsp;</p><center><form><table border=\"0\"><tr><td rowspan=\"3\"><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\">&nbsp; &nbsp; <td><INPUT TYPE=\"button\" VALUE=\" terug \" onClick=\"history.go(-1)\"> (klik hier om e.e.a. alsnog in te vullen)</tr>";
		echo "<tr><td><INPUT TYPE=\"button\" VALUE=\" terug naar menu \" onClick=\"document.location.href='persoon_aaa_menu.php';\"> (klik hier voor het huidige sub-menu)</td></tr>"; 
		if ($partner>0)
		{
			echo "<tr><td><INPUT TYPE=\"button\" VALUE=\" ga verder met partner info\" onClick=\"document.location.href='persoon_partner.php';\"> (klik hier om de volgende vragen te beantwoorden)</td></tr></table></form></center>"; 
		}else{
///@@@ eerst naar huisarts als die af is 
			echo "<tr><td><INPUT TYPE=\"button\" VALUE=\" ga verder met start van gebruik\" onClick=\"document.location.href='versl_gesch1.php';\"> (klik hier om de volgende vragen te beantwoorden)</td></tr></table></form></center>"; 
		}
		$vraag02 = "";
		$submit = "";	
		}
	}
//// @@@@echo $fout."AAAAArghhh".$vraag202."AAAAArghhh".$submit;
/////

include "layoutinc/inc.nltemplate2.php";
?>
<form name="personalia" action="<?php $_SERVER['PHP_SELF']?>" method="post">
<table width="100%"  border="0">
<?php 
if ($feedback!= "")
{
	echo "<tr><td>&nbsp;</td><td colspan=\"2\"><div class=\"feedbacktxt\"><b>".$feedback."</b></div></td></tr>";
}
echo $vraag02;

 ?>
<!--tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="submit" value="<?php echo $submittxt ?>"> &nbsp; &nbsp; <input type="reset" name="reset" value="<?php echo $resettxt ?>"></td></tr-->
</table></form>
</center>
                    
<p>&nbsp;</p>
 <?php
include "layoutinc/inc.nltemplate3.php";
?>
