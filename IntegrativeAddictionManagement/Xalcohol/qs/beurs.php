<?php 
$naam = $HTTP_POST_VARS[naam];
$email = $HTTP_POST_VARS[email];
$submit  = $HTTP_POST_VARS[submit];
//$locatienum = $HTTP_POST_VARS[locatie];
$naam = stripslashes($naam);
$naam = strip_tags($naam);
$email = stripslashes($email);
$email = strip_tags($email);
//$locatienum = stripslashes($locatienum);
//$locatienum = strip_tags($locatienum);
//include "lokaties.php";
//$locatie = $lokaties[$locatienum];
//$locatemail= $lokatieemail[$locatienum];
if ($submit== "nu verzenden")
{
///
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Arbeidspersoonlijkheidstest van Quality Select</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="qs.css" rel="stylesheet" type="text/css">
</head>

<body>
<br>
<img src="qslogo.gif" alt="QS" align="right">

  
<h2>&nbsp;</h2>
<div align="center">
  <table width="800" style="thinline">
    <tr>
      <td>
<h2>&nbsp;</h2>
<h2>Arbeidspersoonlijkheidstest</h2>
  
<?php
if ($submit != "Volgende Stap")
{
	///echo "submit=".$submit;
	?>
	<p>&nbsp;</p>
	<p>Geachte <?php if ($naam==""){echo "Kandidaat";}else{echo $naam;}?>,
<p> Op de volgende pagina zie je een klein deel van de arbeidspersoonlijkheidstest 
  die <a href="http://www.qualityselect.nl">Quality Select</a> altijd gebruikt om te 
  zorgen voor een goede match tussen jou als werkzoekende en de werkplekken in onze 
  bestanden.<br>
  Wanneer jij jezelf bij ons aanmeldt, dan nemen wij op &eacute;&eacute;n van de 
  <a href="http://www.qualityselect.nl">Quality Select</a> kantoren jouw naam en email 
  adres op om jou onze online test toe te sturen: 
<form name="kennismaken" action="<?php $_SERVER['PHP_SELF']?>" method="post">
	  <table border="0" cellpadding="3" cellspacing="0">
	<tr>
	  <td colspan="2"><b>Uitnodiging arbeidspersoonlijkheidtest versturen naar:</b></td>
	</tr>
	<tr>
	<tr>
	  <td>Naam kandidaat:</td> 
	  <td>&nbsp; <input name="naam" type="text" size="35" value="<?php echo $naam; ?>"></td></tr>
	<tr>
	  <td>Emailadres  van de kandidaat:</td> 
	  <td>&nbsp; <input name="email" type="text" size="35" value="<?php echo $email; ?>"></td></tr>
	</table>
	</p>
	  
	

	
  <p>We gaan hier nu op deze beurs 
    <!--@@@@-->
    naar een verkorte versie met zevenentwintig vragen en niet de gebruikelijke test met negentig 
    vragen. Er hoeft nu niet gemaild te worden en we kunnen dus in &eacute;&eacute;n keer door naar de verkorte versie 
    van onze test.</p>
	  Klik op deze button voor de volgende stap: 
  <input name="submit" type="submit" value="Volgende Stap">
	  </form><p>&nbsp;</p>
	<?php
}else{
?>
<p>Geachte 
  <?php if ($naam==""){echo"Kandidaat";}else{echo $naam;}?>,<br>
</p>
<p><i>Deze</i> verkorte test bestaat uit 27 tweekeuze-items. Bij alle items 
  is het de bedoeling dat je steeds <i>die </i>uitspraak kiest, die volgens <i>jou</i> het 
  meest op je van toepassing is. Ook al zal zo'n keuze soms moeilijk zijn, 
  toch moet je bij alle 27 items een keuze maken. Je kunt geen items overslaan 
  en je kunt per item slechts &eacute;&eacute;n van de twee uitspraken kiezen. 
  Zelfs als beide opties voor jou erg passend zijn, je zult moeten kiezen welke het 
  <i>best </i>bij jou past.<br>
</p>
<p><i><b> Bijvoorbeeld als je moet kiezen uit de volgende stellingen:</b></i>
<table>
  <tr>
    <td>&nbsp; <input name="blah[]" type="radio" value="bbb" disabled></td>
    <td>Het kost me weinig moeite om iemand terecht te wijzen.</td>
  </tr>
 <tr>
    <td>&nbsp; <input name="blah[]" type="radio" value="aaa" disabled></td>
    <td>Belangrijke beslissingen kan ik het beste zelf nemen.</td>
  </tr>
</table>
<b><i>en als jij bijvoorbeeld vindt dat uitspraak 2 meer op jou van toepassing is dan 
uitspraak 1, dan klik je op de selectieknop voor uitspraak 2.<br>
</i></b><i> </i> 
<table>
  <tr>
    <td>&nbsp; <input name="blah[]" type="radio" value="bbb"></td>
    <td>Het kost me weinig moeite om iemand terecht te wijzen.</td>
  </tr>
 <tr>
    <td>&nbsp; <input name="blah[]" type="radio" value="aaa" checked></td>
    <td>Belangrijke beslissingen kan ik het beste zelf nemen.</td>
  </tr>
</table>  
<P>
op deze manier werk je alle 27 items af. Je zult ontdekken dat een aantal uitspraken meerdere 
  keren voorkomt. Dat is niet iets om je ongerust om te maken, zo is de opbouw van de test. Het gaat er telkens 
  om dat jij bij een item voor de uitspraak kiest waarvan jij vindt dat ze het meest 
  op jouzelf van toepassing is.<br>
  Bij deze test gaat het vooral om jouw eerste, spontane indruk. Werk snel door 
  deze test en denk niet te lang na, dat geeft de antwoorden die het best bij jou passen.</p>
<P> Wij wensen je veel succes<br>
  Quality Select Secretarieel</p>
<P><b>N</b>ota <b>B</b>ene: De resultaten worden pas verzonden als je op de knop 
  'nu verzenden' klikt!<br>
</p>
<form name="vragen" action="beursgrafiek.php" method="post">
<hr noshade width="50%" align="left"><table border="0" cellpadding="3" cellspacing="0">
<?php if ($naam != ""){echo "<tr><td>Jouw naam is:</td> <td>".$naam."<input type=\"hidden\" name=\"naam\" value=\"".$naam."\"></td></tr>";} ?>
 <?php if ($email != ""){echo "<tr><td>Het door jou opgegeven emailadres is:</td><td>".$email."<input type=\"hidden\" name=\"email\" value=\"".$email."\"></td></tr>";} ?>
<!--<tr> <td>Voor de afspraak op de vestiging te:</td><td><?php echo $locatie; ?></td></tr>
 <tr><td>met als emailadres:</td><td><?php echo $locatemail; ?></td></tr-->
</table> 
<p><h3>Arbeidspersoonlijkheidstest van <?php if ($naam==""){echo "Kandidaat";}else{echo $naam;}?></h3>
<table cellspacing="0" cellpadding="0">
  <tr>
      <td colspan=2><b>1</b> </td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[1]" type="radio" value="t" ></td>
    <td>Groepswerk stimuleert mijn prestaties.</td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[1]" type="radio" value="w"></td>
    <td>Ik zal nooit iemand benadelen.</td>
  </tr>
 <tr>
      <td colspan=2><b>2</b> </td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[2]" type="radio"   value="e" ></td>
    <td>Ik sta bekend als iemand die gemakkelijk contacten legt.</td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[2]" type="radio" value="d" ></td>
    <td>Ik vind het prettig om intensief aan een bepaalde taak te
      werken.</td>
  </tr>
 <tr>
      <td colspan=2><b>3</b> </td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[3]" type="radio" value="d" ></td>
	  <td>Het liefst werk ik in een ruk door.</td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[3]" type="radio" value="r"></td>
    <td>Regels zijn er om te worden nageleefd.</td>
  </tr>
 <tr>
      <td colspan=2><b>4</b> </td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[4]" type="radio" value="t" ></td>
    <td>Ik werk liever in een groep dan dat ik zelfstandig werk.</td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[4]" type="radio" value="d" ></td>
    <td>Het liefst werk ik in een ruk door.</td>
  </tr>
  <tr>
      <td colspan=2><b>5</b> </td>

  </tr>
  <tr>
    <td>&nbsp; <input name="vraag[5]" type="radio"   value="e" ></td>
    <td>Ik vind het leuk om met onbekenden een praatje te maken</b></td>
  </tr>
  <tr>
    <td>&nbsp; <input name="vraag[5]" type="radio" value="r"></td>
    <td>Voor mij is werken het belangrijkste in mijn leven.</td>
  </tr>
 <tr>
      <td colspan=2><b>6</b> </td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[6]" type="radio"   value="e" ></td>
    <td>Ik heb er absoluut geen moeite mee om over mijn slechte kanten
      te praten.</td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[6]" type="radio" value="z"></td>
    <td>Van de meeste dingen die mensen doen, vind ik dat ik het
      eigenlijk beter zou kunnen.</td>
  </tr>
 <tr>
      <td colspan=2><b>7</b> </td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[7]" type="radio" value="d" ></td>
    <td>Men vindt mij een harde werker.</td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[7]" type="radio" value="t" ></td>
    <td>Als ik in een team moet werken, is dat voor mij een stimulans
      om tot betere prestaties te komen.</td></tr>
  <tr>
      <td colspan=2><b>8</b> </td>
  </tr>
  <tr>
    <td>&nbsp; <input name="vraag[8]" type="radio" value="t" ></td>
    <td>Samen met anderen aan een bepaalde taak werken, ligt me wel.</td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[8]" type="radio" value="d" ></td>
    <td>Mensen die mij goed kennen, vinden me een doorzetter.</td></tr>
  <tr>
      <td colspan=2><b>9</b> </td>
  </tr>
  <tr>
    <td>&nbsp; <input name="vraag[9]" type="radio" value="a"></td>
    <td>Als je werkelijk iets wilt bereiken in het leven, zul je
      dat bijna altijd zelf moeten doen.</td>
  </tr>
  <tr>
    <td>&nbsp; <input name="vraag[9]" type="radio"   value="e" ></td>
    <td>Ik vind het leuk om met onbekenden een praatje te maken.</td>
  </tr>
  <tr>
      <td colspan=2><b>10</b> </td>
  </tr>
  <tr>
    <td>&nbsp; <input name="vraag[10]" type="radio" value="w"></td>
    <td>Tot nu toe is alles wat ik heb ondernomen van een leien dakje
      gegaan.</td>
  </tr>
  <tr>
    <td>&nbsp; <input name="vraag[10]" type="radio" value="d" ></td>
    <td>Het overkomt me zelden dat ik een taak niet op tijd af heb.</td>
  </tr>
 <tr>
      <td colspan=2><b>11</b> </td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[11]" type="radio" value="t" ></td>
    <td>Het liefst werk ik in teamverband.</td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[11]" type="radio"   value="e" ></td>
    <td>Ik ben eerder een gemakkelijk prater, dan iemand die dingen
      zoveel mogelijk voor zich houdt.</td>
  </tr>
 <tr>
      <td colspan=2><b>12</b> </td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[12]" type="radio" value="d" ></td>
    <td>Als de omstandigheden dat eisen, doe ik er weleens een schepje
      boven op.</td>
  </tr>
 <tr>
    <td>&nbsp; <input name="vraag[12]" type="radio" value="l"></td>
    <td>Ook al zijn mijn argumenten niet sterk, dan nog slaag ik
      er vaak in mijn zienswijze door te drukken.</td>
  </tr>
 <tr>
      <td colspan=2><b>13</b> </td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[13]" type="radio" value="l"></td>
    <td>Ik vind het leuk om aanwijzingen te geven en mensen te vertellen
      wat ze moeten doen.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[13]" type="radio" value="t" ></td>
    <td>Het liefst werk ik in teamverband.</td></tr>
 <tr>
      <td colspan=2><b>14</b> </td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[14]" type="radio"   value="e" ></td>
    <td>Ik heb er geen enkele moeite mee om een onbekende aan te
      schieten.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[14]" type="radio" value="d" ></td>
    <td>Men vind mij een harde werker.</td></tr>
 <tr>
      <td colspan=2><b>15</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[15]" type="radio" value="t" ></td>
    <td>Groepsopdrachten spreken me erg aan.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[15]" type="radio" value="s"></td>
    <td>Als anderen mij steunen in mijn opvatting, geeft me dat extra
      zekerheid.</td></tr>
 <tr>
      <td colspan=2><b>16</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[16]" type="radio"   value="e" ></td>
    <td>Ik vind het prettig mensen om me heen te hebben om tegen
      ze aan te kunnen praten.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[16]" type="radio" value="l"></td>
    <td>Ik vind het leuk om aanwijzingen te geven en mensen te vertellen
      wat ze moeten doen.</td></tr>
 <tr>
      <td colspan=2><b>17</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[17]" type="radio" value="d" ></td>
    <td>In mijn werk wil ik steeds een uitblinker zijn.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[17]" type="radio"   value="e" ></td>
    <td>Op feestjes ben ik de meeste tijd in druk gesprek gewikkeld.</td></tr>
 <tr>
      <td colspan=2><b>18</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[18]" type="radio" value="s"></td>
    <td>Ik neem zelden een zware beslissing zonder eerst het advies
      van anderen in te winnen.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[18]" type="radio" value="t" ></td>
    <td>Groepsopdrachten spreken me erg aan.</td></tr>
 <tr>
      <td colspan=2><b>19</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[19]" type="radio" value="t" ></td>
    <td>Het uitvoeren van een bepaalde opdracht doe ik het liefst
      samen met anderen.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[19]" type="radio" value="d" ></td>
    <td>Het overkomt me zelden dat ik een taak niet op tijd af heb.</td>
  </tr>
 <tr>
      <td colspan=2><b>20</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[20]" type="radio"   value="e" ></td>
    <td>Het gebeurt vrij regelmatig dat ik zomaar een praatje met
      deze of gene maak.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[20]" type="radio" value="t" ></td>
    <td>Groepswerk stimuleert mijn prestaties.</td></tr>
 <tr>
      <td colspan=2><b>21</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[21]" type="radio" value="d" ></td>
    <td>Het overkomt me maar zelden dat ik iets niet afmaak.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[21]" type="radio" value="w"></td>
    <td>Als ik al problemen heb met anderen, is dat niet mijn schuld.</td></tr>
 <tr>
      <td colspan=2><b>22</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[22]" type="radio"   value="e" ></td>
    <td>Op feestjes ben ik de meeste tijd in druk gesprek gewikkeld.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[22]" type="radio" value="d" ></td>
    <td>Mensen die mij goed kennen, vinden me een doorzetter.</td></tr>
 <tr>
      <td colspan=2><b>23</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[23]" type="radio"   value="e" ></td>
    <td>Op feestjes ben ik een graag geziene gast.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[23]" type="radio" value="t" ></td>
    <td>In een groep presteer ik beter dan wanneer ik in mijn eentje
      iets moet doen.</td></tr>
 <tr>
      <td colspan=2><b>24</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[24]" type="radio" value="d" ></td>
    <td>Wat ik vandaag nog kan doen, stel ik niet uit tot morgen.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[24]" type="radio" value="t" ></td>
    <td>Als ik in een team moet werken, is dat voor mij een stimulans
      om tot betere prestaties te komen.</td></tr>
 <tr>
      <td colspan=2><b>25</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[25]" type="radio" value="t" ></td>
    <td>Ik vind het prettig om met anderen samen te werken.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[25]" type="radio"   value="e" ></td>
    <td>Het gebeurt vrij regelmatig dat ik zomaar een praatje met
      deze of gene maak.</td></tr>
 <tr>
      <td colspan=2><b>26</b></td>
    </tr>
 <tr>
    <td>&nbsp; <input name="vraag[26]" type="radio"   value="e" ></td>
    <td>Als ik met iemand aan de praat raak, gaat het initiatief
      meestal van mij uit.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[26]" type="radio" value="t" ></td>
    <td>Ik vind het prettig om met anderen samen te werken.</td></tr>
 <tr>
      <td colspan=2><b>27</b></td>
    <tr>
<td>&nbsp; <input name="vraag[27]" type="radio" value="d" ></td>
    <td>Ik vind het prettig om intensief aan een bepaalde taak te
      werken.</td></tr>
 <tr>
    <td>&nbsp; <input name="vraag[27]" type="radio"   value="e" ></td>
    <td>Op feestjes ben ik een graag geziene gast.</td></tr>
 <tr><td colspan="2" align="center"><input name="submit" type="submit" value="nu berekenen"> &nbsp; &nbsp; &nbsp; &nbsp; <input name="reset" type="reset" value="reset formulier"></td></tr>
</table>
</form>
<?php
}
?>
<p> 
  <?php

/*
}else{
$test = array_count_values ($vraag);
echo"<p>";
$schaal = array();
$schaal[t] ="Teamwork";
$schaal[e] ="Extraversie";
$schaal[d] ="Doorzettingsvermogen";
echo "<!--br>Teamwork = ".$test[t];
echo "<br>Extraversie = ".$test[e];
echo "<br>Doorzettingsvermogen = ".$test[d];
echo "<br>Rigiditeit = ".$test[r];
echo "<br>Zelfgenoegzaamheid = ".$test[z];
echo "<br>Steun zoeken = ".$test[s];
echo "<br>Leiderschap = ".$test[l];
echo "<br>Onzekerheid = ".$test[o];
echo "<br>Autonomie = ".$test[a];
echo "<br>Sociale Wenselijkheid = ".$test[w];
  
$treepje="|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||";
////
$regel0 = "+      ".$schaal[t].": ".$test[t]."\n+".substr($treepje, 1, $test[t]*2);
$regel1 = "+      ".$schaal[e].": ".$test[e]."\n+".substr($treepje, 1, $test[e]*2);
$regel2 = "+      ".$schaal[d].": ".$test[d]."\n+".substr($treepje, 1, $test[d]*2);
/////

$naam2 = ereg_replace(" ", "%20", $naam); 

$mail_body = <<< EOMAILBODY

$naam heeft de volgende test ingevuld voor: $locatie;
+++++++++++++++++++++++++++++++++++++
$regel0
$regel1
$regel2
$regel3
$regel4
$regel5
$regel6
$regel7
$regel8
$regel9
+++++++++++++++++++++++++++++++++++++

of klik op de link hieronder voor een grafiek
http://www.helpdisk.nl/design/qs/grafiek.php?naam=$naam2&t=$test[t]&e=$test[e]&d=$test[d]&r=$test[r]&z=$test[z]&s=$test[s]&l=$test[l]&o=$test[o]&a=$test[a]&w=$test[w]

Vriendelijk groetend,
namens Quality Select Test-service

Design by H@ns

PS: waarden waren
$antwoorden			 
EOMAILBODY;
     mail($locatemail, 'Testgegevens', $mail_body, 'From: '.$email);
//echo $locatemail.'Testgegevens'.$mail_body.'From: '.$email;
//echo "<hr><p><a href=\"";
//echo "http://www.helpdisk.nl/design/qs/grafiek.php?naam=$naam2&t=$test[t]&e=$test[e]&d=$test[d]&r=$test[r]&z=$test[z]&s=$test[s]&l=$test[l]&o=$test[o]&a=$test[a]&w=$test[w]";
//echo "\">";
//echo "http://www.helpdisk.nl/design/qs/grafiek.php?naam=$naam2&t=$test[t]&e=$test[e]&d=$test[d]&r=$test[r]&z=$test[z]&s=$test[s]&l=$test[l]&o=$test[o]&a=$test[a]&w=$test[w]";
//echo "</a>";
///hier database
include 'dbconnect.php';
mysql_select_db('HELPDISK');
$datetime = strtotime("now");
$datum = date('Y-m-d H:i:s',$datetime);

$sql = "INSERT INTO qs (id, email, url, lokatie, datum) VALUES ('', '$email', 'BEURS=$naam2&t=$test[t]&e=$test[e]&d=$test[d]&r=$test[r]&z=$test[z]&s=$test[s]&l=$test[l]&o=$test[o]&a=$test[a]&w=$test[w]', '$locatie', '$datum')";
$select = mysql_query ($sql);
// or die('@@@1 Query: '.$sql.'<br>@@@<br>'.mysql_error());
//mysql_free_result($sql);
//echo $sql;
*/
?>
</td>
    </tr>
  </table>
</div>
<p>&nbsp;
<p>&nbsp; <p align="right"><a href="http://www.helpdisk.nl/design/index.php?x=QS" class="hwdesign">&nbsp;<i>design 
      by: H</i>@<i>ns</i>&nbsp;</a></p>

</body>
</html>

<!--
DROP TABLE IF EXISTS `qs`;
CREATE TABLE `qs` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(35) default NULL,
  `url` varchar(90) default NULL,
  `lokatie` varchar(20) default NULL,
  `datum` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Gegevens worden uitgevoerd voor tabel `qs`
-- 

INSERT INTO `qs` VALUES (1, 'design@helpdisk.nl', 'Hans%20R.J%20%20West&t=8&e=9&d=9&r=9&z=9&s=11&l=10&o=8&a=9&w=8', 'design by H@ns', '2006-09-17 20:29:45');
        

-->