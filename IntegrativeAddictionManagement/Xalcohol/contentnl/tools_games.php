<?php
include "gegevens_sma.php";
include "../assets/formulas.php";
session_start();
$persoon_id = $_SESSION['persoon_id'];
$zoekpersoon = $persoon_id;

$strategie = $_SESSION['strategie'];
$strategieduur = $_SESSION['strategieduur'];
$evaldatum = $_SESSION['evaldatum'];
$totevaldatum = $_SESSION['totevaldatum'];
$nextstep = $_SESSION['nextstep'];

//Zorgen dat $_POST en $_GET niet meer vatbaar zijn voor SQL injection 
anti_injection($_POST); 
anti_injection($_GET);

$layoutnr="341";
$layoutnr="361";

$hiero1="tools"; 
include "layoutinc/inc.nltemplate0.php";
include "tools_aaa_inc.php";
 include "layoutinc/inc.nltemplate1.php";
				   ?>
            <p><img src="../pics/macsmiley.gif" border="0" /> <b>Games people 
              play...</b><br />
              Het lijkt onzinnig om spelltetjes te gaan zitten spelen op je computer 
              maar dat is het niet...<br>
              Verslavingen tackelen dat heeft vaak meer te maken met het veranderen 
              van je instelling, van de zo genoemde &quot;intentionaliteit&quot; 
              -van je 'gerichtheid'-, eerder dan met het veranderen van wat oppervlakkige 
              gedachten. Daarom werken pep-talks niet. Daarom zijn 'goede voornemens' 
              onvoldoende. <br>
              We weten allemaal dat we argumenten kunnen verzinnen. Maar het gaat 
              erom dat we dieper in ons brein gaan inzien dat alcohol misschien 
              aan de ene kant ontspannend of bevrijdend kan werken, aan de andere 
              kant is het een verslavend middel dat, als de bijbehorende aandoening 
              -alcoholisme- je in de grip begint te krijgen, een leven behoorlijk 
              kan versteren. Een aandoening die zelf z'n eigen gedachten wel vormt 
              in je brein dus van de 'goeie' gedachten hoef je het niet zo te 
              hebben.<br>
              Maar als het je lukt om je op een dieper niveau in te zien dat alcohol, 
              misschien lekker, ook een risico is... Als je jezelf kunt richten 
              op de kwaliteitsverbetering in je leven door het herwinnen van contr&ocirc;le en het stellen van prioriteiten, dat zijn de dingen die uitmaken 
              bij het tackelen van 'verslaving'... <i><b>en daar kunnen spelletjes 
              w&egrave;l bij helpen!</b></i><br />
              Niet alleen maar doordat een spelletje je zou kunnen helpen om jou 
              op andere gedachten te brengen als je trek hebt. Nee, ook bij het 
              doen van de juiste spelletjes wordt het makkelijker om je echt te 
              richten op de doelen die jij in je leven belangrijk wilt maken. 
              Het kan je helpen om je scherper te focussen op de veranderingen 
              die jij in jouw leven wilt aanbrengen.<br>
			  Hobby is belangrijk, genieten is belangrijk. Spelen is belangrijk. 
              Vandaar dat we hier een aantal spelletjes gaan presenteren die je 
              kunt spelen.<span class='rechtsbordertje'><img src='../pics/macsmiley.gif' border='0'> 
              opnieuw leren spelen en opnieuw leren werken...</span></p>
            <p>&nbsp;</p>
            <p>&nbsp;</P>
 <?php include "layoutinc/inc.nltemplate2.php"; ?>
            <p><img src="../pics/macsmiley.gif" border="0" /> Gepresenteerde spelen 
              zijn </p>
            
		<p><a href="../games/typeles.htm" target="_blank" class="menubutton">type 
		  les V 0,1</a> <i>als je dan toch een beetje wilt leren typen dan kan 
		  je dat maar beter leren met woorden die de intentie van jouw ontwenning 
		  ondersteunen...</i>
		<p>
		  <SCRIPT LANGUAGE="JavaScript">
<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->
<!-- Begin
if ((navigator.appName == "Microsoft Internet Explorer") && (parseInt(navigator.appVersion) >= 4)) {
var url=self.location;
if ()
var url="http://www.StoOokMetDrinken.nl/";
var title="StopOokMetDrinken.nl";
document.write('<A HREF="javascript:window.ext');
document.write('ernal.AddFavorite(url,title);" ');
document.write('onMouseOver=" window.status=');
document.write("'Voeg StopOokMetDrinken.nl toe aan jouw favorieten!'; return true ");
document.write('"onMouseOut=" window.status=');
document.write("' '; return true ");
document.write('">Voeg StopOokMetDrinken.nl toe aan jouw favorieten!</a>');
}
else {
var msg = "Vergeet ons niet om van StopOokMetDrinken.nl een bookmark te maken!";
if(navigator.appName == "Netscape") msg += "  (CTRL-D)";
document.write(msg);
}

// End -->
</script>
		  <?php
include "layoutinc/inc.nltemplate3.php";
?>
	  