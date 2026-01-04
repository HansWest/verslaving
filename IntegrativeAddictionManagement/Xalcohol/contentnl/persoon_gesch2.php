<?php
session_start();
$persoon_id = $_SESSION['persoon_id'];
$zoekpersoon = $persoon_id;
$gender = $_SESSION['gender'];
$voornaam = $_SESSION['voornaam'];
$achternaam = $_SESSION['achternaam'];
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
if ($submit == " ga verder ")
{
	$zoeknummer=zoeknummer();
$emailadres = $_SESSION['emailadres'];
//	echo $persoon_id.$emailadres."info@helpdisk.nl".$sendtext."patronen".laterdagen(7);
//@@@!!!
$sendtext="Je voerde een week geleden de start van jouw mogelijke verslavingsverhaal in".$voornaam."\n- - -\n" . $sendtext."\n- - -\n" . "Is dat misschien eens iets om over na te denken in dat kader?";
verzendmail($persoon_id,$emailadres,"info@helpdisk.nl",$sendtext,"SMA start patronen",laterdagen(7),$zoeknummer);

	header("Location: persoon_aaa_menu.php");
}
$hiero1="alcohol geschiedenis";

$layoutnr="490";

include "layoutinc/inc.nltemplate0.php";
include "persoon_aaa_inc.php";
	
if ($submit != "")
{
	$fout = "";
	if ($eersteleeft == "")
	{
		$fout .= "wil je aangeven op welke leeftijd jij met alcoholgebruik in aanmerking bent gekomen, alsjeblieft?<br>";
	}
	if ($eersteleeft > 80)
	{
		$fout .= "wil je aangeven op welke leeftijd (levensjaar! niet kalenderjaar) jij met alcoholgebruik in aanmerking bent gekomen, alsjeblieft?<br>";
	}
	if ($bevieleerste == "")
	{
		$fout .= "wil je wel aangeven hoe het eerste gebruik beviel, alsjeblieft?<br>";
	}
	if ($aanloop =="")
	{
		$fout .= "wil je wel aangeven hoe het gebruik zich ontwikkelde, alsjeblieft?<br>";
	}
	if ($eerstekader == "")
	{
		$fout .= "wil je wel aangeven waarom je de eerste keer dronk, alsjeblieft?<br>";
	}
	if ($aanloop == "")
	{
		$fout .= "wil je wel aangeven hoe het verloop in je leven is geweest, alsjeblieft?<br>";
	}
	if ($toegeefjaar == "")
	{
		$fout .= "wil je wel aangeven in welk kalenderjaar er twijfel onstond over de manier waarop je met alcohol omgaat alsjeblieft?<br>";
	}
	if ($stoppogingen == "")
	{
		$fout .= "wil je wel aangeven of jij je ooit met een stoppoging hebt bezig gehouden, alsjeblieft?<br>";
	}
	if ($gemiddeldeweek == "")
	{
		$fout .= "wil je wel aangeven hoeveel eenheden je (gemiddeld genomen!) per week(!) tot je neemt, alsjeblieft?<br>";
	}
	if ($omgevingzorg == "")
	{
		$fout .= "wil je wel aangeven of er mensen in jouw omgeving zijn die zich zorgen maken over jouw manier van drinken, alsjeblieft?<br>";
	}
	if ($fout == "")
	{
		echo "fijn dat ik niks hoefde te missen in jouw antwoorden...<p>";
		//if ($submit=="bewaar gegevens")
		//{
		///@@@@   Naar database wegschrijven
		include '../assets/dbconnect.php';
		$query = "SELECT * 
			FROM gebruikgeschtabel
			WHERE persoon_id = '$zoekpersoon'";
		$result = mysql_query($query);
		if (!$result)
		{
			$fout = $errormain;
		}else{
			if (mysql_num_rows($result) < 1)
			{
				$feedback = "<br>info is toegevoegd ";
				$query = "INSERT INTO gebruikgeschtabel VALUES ('$zoekpersoon', '$eersteleeft', '$bevieleerste', '$eerstekader', '$aanloop', '$toegeefjaar', '$verlooppatroon', '$gemiddeldeweek', '$omgevingzorg', '$stoppogingen')";
				///@@@ echo "nieuw".$query;
				$result = mysql_query($query);
				if (!$result || mysql_affected_rows() < 1)
				{
					$fout = $errordatabase;
				}
				//@@@echo "<br>xxX". $fout."Xxx nieuw toegevoegd. rows is affected rows".mysql_affected_rows();
				//if (fout=="")
				//{
				//  header("Location: login.php");
				//}
			}else{
				//	$query = "SELECT * 
				//			FROM gebruikgeschtabel
				//			WHERE persoon_id = '$zoekpersoon'";
				//	$result = mysql_query($query);			
			
				//@@@ echo "<br>xxX". $fout."Xxx gezocht. rows is ".mysql_num_rows($result) ;
				if (fout=="" || mysql_num_rows($result) > 0 )
				{
					$query = "UPDATE gebruikgeschtabel
					SET eersteleeft = '$eersteleeft',
						bevieleerste = '$bevieleerste',
						eerstekader = '$eerstekader',
						aanloop = '$aanloop',
						toegeefjaar = '$toegeefjaar',
						verlooppatroon = '$verlooppatroon',
						gemiddeldeweek = '$gemiddeldeweek',
						omgevingzorg = '$omgevingzorg',
						stoppogingen = '$stoppogingen'
					WHERE persoon_id = '$zoekpersoon' LIMIT 1";
					$result = mysql_query($query);
					if (!$result)
					{
				echo "up".mysql_affected_rows();
				echo $query;
						$fout = $errordatabase;
					}
					//if ($fout=="")
					//{
					// 	header("Location: login.php");
					//}
				}
			}
		}
	}
}

if ($submit == "")
{
	if ($layout == "")
	{
		$layoutnr="210";
	}
	include "layoutinc/inc.nltemplate1.php";
	echo "<p><b><img src=\"../pics/macsmiley.gif\" border=\"0\"> de aanvang van het alcoholverhaal in jouw leven, ".$voornaam."</b><br>
  Het zal duidelijk zijn dat ik in het kader van deze site ook nog graag wat gegevens 
  heb over de manier waarop jij met alcohol omgegaan bent in jouw leven. We gaan 
  daar in de toekomst nog meer in uitzoeken met elkaar. Maar er zijn in ieder geval al een paar 
  dingen die ik je graag direct wil vragen.</p>";
}else{
	include "layoutinc/inc.nltemplate1.php";
}

if ($fout != "")
{
	echo "<center><table border=0 width=100%>";
	echo "<tr><td><img src=\"../pics/macmandwn.gif\" alt=\"oeps\" width=\"23\" height=\"28\" border=\"0\"></td><td><b>Ik ondekte een foutje in de invoer:</b></td></tr>";
	echo "<tr><td>&nbsp;</td><td class='errortxt'><b>".$fout."</b></td></tr>";
	echo "<tr><td><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\"</td><td><form><INPUT TYPE=\"button\" VALUE=\" terug \" onClick=\"history.go(-1)\"></form></td></tr>";
	echo "</table></center>";  
}else{
	 echo '<!--@@@@@@@@@@@@@@' . $zoekpersoon . '<br>'; 
	include '../assets/dbconnect.php';
	$query = "SELECT * 
			FROM gebruikgeschtabel
			WHERE persoon_id = '$zoekpersoon'";
	$result = mysql_query($query);
	if (!$result)
	{
		$fout = $errormain;
	}else{
	$aRow = mysql_fetch_row($result);
	 echo '0:' . $aRow[0] . '<br>'; 
	 echo '1:' . $aRow[1] . '<br>'; 
	 echo '2:' . $aRow[2] . '<br>'; 
	 echo '3:' . $aRow[3] . '<br>'; 
	 echo '4:' . $aRow[4] . '<br>'; 
	 echo '5:' . $aRow[5] . '<br>'; 
	 echo '6:' . $aRow[6] . '<br>'; 
	 echo '7:' . $aRow[7] . '<br>'; 
	 echo '8:' . $aRow[8] . '<br>'; 
	 echo '9:' . $aRow[9] . '<br>'; 
	 echo '10:' . $aRow[10] . '<br>'; 
	 echo '11:' . $aRow[11] . '<br>'; 
	 echo '12:' . $aRow[12] . '<br>'; 
	 echo '13:' . $aRow[13] . '<br>'; 
	 echo '14:' . $aRow[14] . '-->'; 
	}
		$vraag02 = "<tr><td valign=\"top\"><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\"><br>
<b>toen</b></td><td >het begin:</td><td><i><b><i>Hoe oud</i></b></i> was jij (ongeveer) toen je voor het eerst alcohol dronk? <input name=\"eersteleeft\" type=\"text\" size=\"3\" maxlength=\"2\" value=\"";
		if ($aRow[1]=="")
		{
			$vraag02 .= "jj";
		}else{
			$vraag02 .= $aRow[1];
		}
		$vraag02 .= "\" onFocus=\"if(this.value=='jj')this.value='';\"><font color=\"#800040\">* geef een leeftijd in jaren</font>";
		$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">1ste keer:</td><td><i><b>Hoe beviel</b></i> deze eerste kennismaking?: <font color=\"#800040\">*</font><br><SELECT NAME=\"bevieleerste\"><option value=\"\">maak hier een keuze</option><option value=\"1\"";
		if ($aRow[2]==1)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">beviel niet echt</option><option value=\"2\"";
		if ($aRow[2]==2)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">was wel aardig</option><option value=\"3\"";
		if ($aRow[2]==3)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">voelde gelijk geweldig</option></SELECT></td></tr>";
		$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">&nbsp;</td><td><i>Was dit in het <b>kader</b> van : <font color=\"#800040\">*</font><br><SELECT NAME=\"eerstekader\"><option value=\"\">maak hier een keuze</option><option value=\"1\"";
		if ($aRow[3]==1)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">experiment / uitproberen hoe dat is</option><option value=\"2\"";
		if ($aRow[3]==2)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">met een bepaald doel voor ogen</option><option value=\"3\"";
		if ($aRow[3]==3)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">ik herinner mij dat niet echt meer</option><option value=\"4\"";
		if ($aRow[3]==4)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">ik voelde mij gedwongen</option></SELECT></td></tr>";
		$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">verloop:</td><td>Er even van uitgaande dat jij nu jouw gebruik wel wat 'veel' vindt, hoe is dat <b><i>verloop</i></b> geweest: ben je gestaag meer gaan drinken of is dat 'meer' ineens gekomen?<br><SELECT NAME=\"aanloop\"><option value=\"\">maak hier een keuze</option><option value=\"3\"";
		if ($aRow[4]==3)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">vanaf eerste moment meer gedronken dan gemiddeld</option><option value=\"2\"";
		if ($aRow[4]==2)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">ik ben gaandeweg steeds meer gaan drinken</option><option value=\"1\"";
		if ($aRow[4]==1)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">het was later dat ik 'teveel' ben gaan drinken</option></SELECT></td></tr>";
		$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">contr&ocirc;le verlies:</td><td>Wat was het jaar waarin jij <i><b>aan jezelf begon toe te geven</b></i> dat er mischien toch wel een probleem(pje) was met het controleren van de alcoholinname? <input name=\"toegeefjaar\" type=\"text\" size=\"5\" maxlength=\"4\" value=\"";
		if ($aRow[5]!="")
		{
			$vraag02 .= $aRow[5];
		}else{
			$vraag02 .= "jjjj";
		}
		$vraag02 .= "\" onFocus=\"if(this.value=='jjjj')this.value='';\"><font color=\"#800040\">* geef een jaartal aan</font>";
		//$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">patronen:</td><td><i>Herken jij je meer in het patroon: <font color=\"#800040\">*</font><br><SELECT NAME=\"verlooppatroon\"><option value=\"1\">experiment / uitproberen hoe dat is</option><option value=\"2\">met een bepaald doel voor ogen</option><option value=\"3\">ik herinner mij dat niet echt meer</option></SELECT></td></tr>";
		$vraag02 .= "<tr><td valign=\"top\"><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\"><br>
<b>en nu</b></td><td valign=\"top\">aantallen:</td><td>Hoeveel <b>eenheden</b> drink je nu <b>gemiddeld per week</b>? <input name=\"gemiddeldeweek\" type=\"text\" size=\"3\" maxlength=\"3\" value=\"".$aRow[7]."\"><font color=\"#800040\">*</font> (neem <i>echt</i> even de tijd om te rekenen alsjeblieft)</font>";
		$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">omgeving:</td><td>Maakt jouw <i><b>omgeving</b></i> zich wel eens zorgen over jouw alcohol inname: <font color=\"#800040\">*</font><br><SELECT NAME=\"omgevingzorg\"><option value=\"0\"";
		if ($aRow[8]==0)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">nee, niemand</option><option value=\"1\"";
		if ($aRow[8]==1)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">een enkeling</option><option value=\"2\"";
		if ($aRow[8]==2)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">dat heb ik wel vaker gehoord</option></SELECT></td></tr>";
		$vraag02 .= "<tr><td>&nbsp;</td><td valign=\"top\">pogingen:</td><td>Heb je ooit eerder serieuze <i><b>stoppogingen</b></i> ondernomen? <font color=\"#800040\">*</font><br><SELECT NAME=\"stoppogingen\"><option value=\"0\"";
		if ($aRow[9]==0)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">nee, nooit</option><option value=\"1\"";
		if ($aRow[9]==1)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">wel eens</option><option value=\"2\"";
		if ($aRow[9]==2)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">een paar serieuze</option><option value=\"3\"";
		if ($aRow[9]==3)
		{
			$vraag02 .= " selected";
		}
		$vraag02 .=">vaak</option></SELECT></td></tr>";
		$vraag02 .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		$vraag02 .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type=\"submit\" name=\"submit\" value=\"".$submittxt."\"> &nbsp; &nbsp; <input type=\"reset\" name=\"reset\" value=\"".$resettxt."\"></td></tr>";
	if ($submit != "")
	{
		///
		$temptext = "Beste $voornaam,";
		echo "<img src=\"../pics/macsmiley.gif\" border=\"0\"> <b>".$temptext. "</b><br>";
		$sendtext = $temptext. "\n";
		$temptext = "Je dronk op de leeftijd van zo'n $eersteleeft jaar oud jouw eerste alcoholische versnaperingen ";
		$sendtext .= $temptext;
		echo $temptext;
		if ($eerstekader==1)
		{
			$temptext = "om eens uit te proberen hoe dat is. ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($eerstekader==2)
		{
			$temptext = "om gericht een doel te bereiken middels drank.";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($eerstekader==3)
		{
			$temptext = "maar daar weet je niet zo veel meer van.";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($eerstekader==4)
		{
			$temptext = "omdat jij je daartoe gedwongen voelde ( <img src=\"../pics/macsmiley.gif\" border=\"0\"> door wie en waarom eigenlijk?).";
			$sendtext .= $temptext;
			echo $temptext;
		}
		$temptext = "En dat ";
		$sendtext .= "\n".$temptext;
		echo "<br>".$temptext;
		if ($bevieleerste==1)
		{
			$temptext = "beviel niet echt. Maar ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($bevieleerste==2)
		{
			$temptext = "was wel aardig. Dus ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($bevieleerste==3)
		{
			$temptext = "voelde gelijk geweldig... Dus ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($aanloop==1)
		{
			$temptext = "het was later dat je 'teveel' ben gaan drinken. ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($aanloop==2)
		{
			$temptext = "je bent gaandeweg meer gaan drinken.";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($aanloop==3)
		{
			$temptext = "je bent vanaf eerste moment meer gaan drinken dan gemiddeld. ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		$temptext = "In $toegeefjaar moest je toch aan jijzelf toegeven dat er";
		$sendtext .= "\n".$temptext;
		echo "<br>".$temptext;
		
		if ($stoppogingen ==0)
		{
			$temptext = " mogelijk wel een probleem is om alcoholgebruik gezond te houden. ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($stoppogingen ==1)
		{
			$temptext = " waarschijnlijk wel een probleem bestaat om alcohol te controleren. ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($stoppogingen ==2)
		{
			$temptext = " gewoon wel een probleem bestaat om alcohol te controleren. ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($stoppogingen ==3)
		{
			$temptext = " gewoon wel een duidelijk probleem bestaat om alcohol te controleren. ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		$temptext = "Inmiddels drink je zo'n $gemiddeldeweek drankjes per week ";
		$sendtext .= "\n".$temptext;
		echo "<br>". $temptext;
		
		if ($gender == 1) { $healthmax = 23; }else{$healthmax = 21; }
		if ($gemiddeldeweek > $healthmax )
		{
			$temptext = " (waarbij ik even moet melden dat je ".($gemiddeldeweek - $healthmax )." eenheden boven de grens zit waarop wetenschappelijk is vastgesteld dat hersenschade begint te ontstaan... juist in het deel van de hersenen dat je nodig hebt om rekening te kunnen houden met verslavingen in de middenhersenen en hersenstam...) ";
			$sendtext .= $temptext;
			echo $temptext;
		}else{
			$temptext = " (biologisch gezien zit je onder de grens ".($healthmax )." waarboven wetenschappelijk is vastgesteld dat hersenschade begint te ontstaan... er kan natuurlijk wel degelijk sprake zijn van andere -medisch- biologische, en/of vooral psychologische redenen om gebruik te willen controleren...) ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($omgevingzorg == 0)
		{
			$temptext = "Maar niemand maakt zich (nog) zorgen over jouw alcohol gebruik voor zover je weet. ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($omgevingzorg == 1)
		{
			$temptext = "Een enkeling maakt zich dan ook zorgen over jouw alcohol gebruik (voor zover je weet). ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($omgevingzorg == 2)
		{
			$temptext = "Er zijn meerdere mensen die zorgen voelen over de manier waarop jij met alcohol omgaat. ";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($stoppogingen == 0)
		{
			$temptext = "Je hebt nog nooit een serieuze poging gedaan om alcoholinname een beetje te ontwennen. ";
			$sendtext .= "\n".$temptext;
			echo "<br>".$temptext ;
		}
		if ($stoppogingen == 1)
		{
			$temptext = "Je hebt wel eens wat pogingen gedaan om jouw alcoholinname een beetje te ontwennen. ";
			$sendtext .= "\n".$temptext;
			echo "<br>".$temptext ;
		}
		if ($stoppogingen == 2)
		{
			$temptext = "Je hebt blijkbaar nog wel een probleem(pje?) ondanks dat je toch een paar serieuze pogingen hebt gedaan om jouw alcoholinname te ontwennen. (";
			$sendtext .= "\n".$temptext;
			echo "<br>".$temptext." <img src=\"../pics/macsmiley.gif\" border=\"0\"> ";
			$temptext = "natuurlijk gaan we verder. maar is een poging via internet wel voldoende?)";
			$sendtext .= $temptext;
			echo $temptext;
		}
		if ($stoppogingen == 3)
		{
			$temptext = "Je hebt blijkbaar nog wel een probleem ondanks dat je toch naar eigen zeggen vaak serieuze pogingen hebt gedaan om jouw alcoholinname te ontwennen. (";
			$sendtext .= "\n".$temptext;
			echo "<br>".$temptext." <img src=\"../pics/macsmiley.gif\" border=\"0\"> ";
			$temptext = "natuurlijk gaan we verder. maar is een poging via internet wel voldoende? moet je dat niet gaan aanvullen met real-life coaching?)";
			$sendtext .= $temptext;
			echo $temptext;
		}
		
		echo "<br><p><i> (ook hier: klopt het voorgaande niet, ga dan even terug, want zo vaak zal je niet op deze pagina terecht komen)</i><br>";
		echo "<p>&nbsp;</p><p>&nbsp;</p><center><table border=\"0\"><tr><td rowspan=\"2\"><img src=\"../pics/mensje.gif\" alt=\"mens invoer\"  width=\"10\" height=\"12\"  border=\"0\">&nbsp; &nbsp; <td><INPUT TYPE=\"button\" VALUE=\" terug \" onClick=\"history.go(-1)\"> (klik hier om e.e.a. alsnog in te vullen)</tr><tr><td><form name=\"personalia\" action=\"".$_SERVER['PHP_SELF']."\" method=\"post\"><INPUT name=\"sendtext\" TYPE=\"hidden\" id=\"sendtext\" VALUE=\"".$sendtext."\"><INPUT name=\"submit\" TYPE=\"submit\" VALUE=\" ga verder \"> (klik hier om volgende vragen te beantwoorden)</form><!--@@@INPUT TYPE=\"button\" VALUE=\" ga verder \" onClick=\"document.location.href='persoon_aaa_menu.php';\"--> </td></tr></table></center>"; 
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
