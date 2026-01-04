<?php
include "gegevens_sma.php";
include "../assets/formulas.php";
session_start();
$persoon_id = $_SESSION['persoon_id'];
$strategie = $_SESSION['strategie'];
$strategieduur = $_SESSION['strategieduur'];
$evaldatum = $_SESSION['evaldatum'];
$totevaldatum = $_SESSION['totevaldatum'];
$nextstep = $_SESSION['nextstep'];

//Zorgen dat $_POST en $_GET niet meer vatbaar zijn voor SQL injection 
anti_injection($_POST); 
anti_injection($_GET);

$layoutnr="361";

$hiero1="trek-surfen";


include "layoutinc/inc.nltemplate0.php";
 ?>
<script language="JavaScript1.2">
<!--
var meting = new Array(), tijd = new Array(), dateNow, uren, minuten, secnds, teller, hoppa;
teller = 0;

//var DateValue
function intiat() {
	dateNow=new Date();
	secnds=dateNow.getSeconds();
	document.panel.teller.value=0;
	document.panel.hoppa.value="";
	//document.panel.starttijd.value=secnds;
}

function toevoegen()
{
	dateNow=new Date();
	uren=dateNow.getHours();
	minuten=dateNow.getMinutes();
	secnds=dateNow.getSeconds();
	if (minuten<10)
	{
		minuten="0"+minuten;
	}
	document.panel.tijd.value=uren+":"+minuten;
	document.panel.startsecs.value=secnds;
//	if(document.panel.teller.value < 1) document.panel.teller.value=0;
	///alert(eval(document.panel.teller));
	temp = eval(document.panel.teller.value)+1;
	document.panel.teller.value = temp;
///
	temp=document.panel.score.value;
	temp=document.panel.hoppa.value+document.panel.score.value;
	document.panel.hoppa.value = temp;
	tekenen()
}

function tekenen()
{
	text =  '<html>\n<head>\n<title>:: surf scherm ::</title>\n<link href="../assets/sma.css" rel="stylesheet" type="text/css">\n<BODY bgcolor=\"#CCCCFF\">\n<table class=\"notetitle\" cellspacing=\"0\" cellpadding=\"0\">';
	text += '<tr><td height="12"><b>&nbsp;surfen op het gevoel van trek...</b></td><td align="right"><a href=\"javascript:void(0);\" onclick=\"window.close()';
	text += "('note1')";
	text +=';\" class=\"notetitle\" >[&#8722;]</a></td></tr></table>';
text += "<table width=\"90%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td colspan=2><p>&nbsp;</p>De laatste waarde die je om "+document.panel.tijd.value+" u. opgaf was: <b>" + eval(eval(document.panel.score.value)+1)+"</b>...<p></td></tr>";
	tijd=document.panel.hoppa.value;
	teller=0;
	while (teller < document.panel.teller.value)
	{
		temp=(document.panel.hoppa.value)+(meting-1);
		text +="<tr><!--td width=\"40\">22:00</td--><td><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#EE0000\" width=\""+((eval(tijd[teller])+1)*10)+"%\"><tr><td>&nbsp;</td></tr></table></td></tr>";
		teller++;
	}
text += "<tr><td colspan=2><p><hr><p>...en hoe is dat gevoel van 'trek' zich nu aan het ontwikkelen terwijl je nu niet toegeeft aan dat gevoel, in de zin dat je drink-gedrag toestaat, maar dat je ernaar kijkt als &quot;een gevoel dat jij nu (even) hebt&quot;?</td></tr>";
text += "</table>\n<p><p></body>\n</html>\n";
windowPop(text);
//	alert (tijd[0]+"|"+tijd[1]+"|"+tijd[2]+"|"+tijd[3]+"|"+tijd[4]+"|"+tijd[5]+"|"+tijd[6]+"|"+tijd[7]+"|"+tijd[8]+"|"+tijd[9]+"|"+tijd[10]);
}

function nul()
{
//		intiat();
	alert("Als het nul is zullen we dan maar stoppen met bijhouden en gaan printen?");
}
function een()
{
//		intiat();
	document.panel.score.value=0;
	toevoegen();
}
function twee()
{
//		intiat();
	document.panel.score.value=1;
	toevoegen();
}
function drie()
{
//		intiat();
	document.panel.score.value=2;
	toevoegen();
}
function vier()
{
//		intiat();
	document.panel.score.value=3;
	toevoegen();
}
function vijf()
{
//		intiat();
	document.panel.score.value=4;
	toevoegen();
}
function zes()
{
//		intiat();
	document.panel.score.value=5;
	toevoegen();
}
function zeven()
{
//		intiat();
	document.panel.score.value=6;
	toevoegen();
}
function acht()
{
//		intiat();
	document.panel.score.value=7;
	toevoegen();
}
function negen()
{
//		intiat();
	document.panel.score.value=8;
	toevoegen();
}
function tien()
{
//		intiat();
	document.panel.score.value=9;
	toevoegen();
}

function elf()
{
	//document.panel.score.value=1;
	alert ("op een schaal van 1 tot 10 kan de waarde 11 natuurlijk niet...\nMaar dan waren blijkbaar de voorgaande waarden dus toch wat minder dan dat je op dat moment had bedacht...");
	tijd=document.panel.hoppa.value;
	document.panel.hoppa.value = "";
	teller=0;
	while (teller < document.panel.teller.value)
	{
		if (eval(tijd[teller])<1)
		{
			temp='0';
		}
		if (eval(tijd[teller])>0)
		{
		temp=eval(tijd[teller]-1);
		}
		tijd[teller] =temp;
//		alert (temp+"min"+eval(tijd[teller]-1));
		temp=document.panel.hoppa.value+temp;
		document.panel.hoppa.value = temp;
//		alert (temp+"x"+tijd[teller]);
		teller++;
	}
	document.panel.score.value=9;
	toevoegen();
}

function popupTest()
{
text =  '<html>\n<head>\n<title>surf - scherm</title>\n<link href="../assets/sma.css" rel="stylesheet" type="text/css">\n<BODY bgcolor="#CCCCFF">\n';
text += '<center>\n<p>&nbsp;<p> Als je dit test-scherm ziet dan is het goed!<br> (het sluit zo vanzelf - of klik hieronder) <form><p>';
//text += '<input type=button value="sluit window" ';
//text += 'onClick="if (document.layers) window.close();">';
text += '<input type=button value="sluit window" ';
text += 'onClick="window.close();">';
text += '\n</form>\n</center>';
text += "</center>\n</body>\n</html>\n";
windowProp(text);
// setTimeout('windowProp(text)', 3000); 		// delay 3 seconds before opening
}
function popupWin()
{
text =  '<html>\n<head>\n<title>test scherm</title>\n<link href=\"../assets/sma.css\" rel=\"stylesheet\" type=\"text/css\">\n<BODY bgcolor=\"#CCCCFF\">\n';
text += '<center>\n<p> Als je dit scherm ziet dan is het goed (het sluit zo vanzelf oif klik hieronder) <form><p>';
text += '<input type=button value="sluit window" ';
text += 'onClick="if (document.layers) window.close();" ';
text += '\n</form>\n</center>';
text += "</center>\n</body>\n</html>\n";
///windowProp(text);
setTimeout('windowProp(text)', 2000); 		// delay 3 seconds before opening
}

function windowProp(text) {
newWindow = window.open('',"testscherm",'width=300,height=150,left=100,top=100,scrollbars');
newWindow.document.write(text);
setTimeout('closeWin(newWindow)', 5000);	// delay 30 seconds before closing
}
function windowPop(text) {
newWindow = window.open('',"surfscherm",'width=400,height=500,left=350,top=100,scrollbars');
newWindow.document.write(text);
setTimeout('closeWin(newWindow)', 30000);	// delay 30 seconds before closing
}
function showPop() {
if (text != "")
{
newWindow = window.open('',"surfscherm",'width=400,height=500,left=350,top=100,scrollbars');
setTimeout('closeWin(newWindow)', 30000);	// delay 30 seconds before closing
}
}

function closeWin(newWindow) {
newWindow.close();				// close small window and depart
}

nope = "Deze functie is uitgeschakeld!";
bV  = parseInt(navigator.appVersion)
bNS = navigator.appName=="Netscape"
bIE = navigator.appName=="Microsoft Internet Explorer"

function rechtsklik(e) {
   if (bNS && e.which> 1){
      alert(nope);
      return false;
   } else if (bIE && (event.button>1)) {
     alert(nope);
     return false;
   }
}
document.onmousedown = rechtsklik;
if (document.layers) window.captureEvents(Event.MOUSEDOWN);
if (bNS && bV<5) window.onmousedown = rechtsklik;

//  End -->
</script>

<?php 
include "tools_aaa_inc.php";

include "layoutinc/inc.nltemplate1.php";
?>
<p><b>Een surfmentaliteit om met 'trek' om te gaan</b><br>
<div style="background: #CCCCFF" class="rechtsbordertje" ><img src="../pics/macsmiley.gif" width="16" height="14"> <b>Nota Bene:</b> voor 
	deze functie is het nodig om voor deze site (even) de popup vensters <i><b>toe 
	te staan</b></i> (vaak staat in de veiligheidsintsellingen de term &quot;block 
	'pop-up' vensters&quot;). Deze instelling moet 'uit' staan.<br>
  <img src="../pics/uitroeptekentje.gif" alt="nota bene" width="12" height="12"> 
  Als je zojuist <b>niet</b> een klein scherm hebt zien verschijnen dan staat 
  bij jou deze bescherming waarschijnlijk op 'aan' en dat blokkeert het tekenen 
  van de grafieken. </div>
  De manier waarop we ons voelen over onze eigen gevoelens, dat heeft <i>alles 
  </i>te maken met de manier waarop wij ernaar kijken, en meer nog wat we ermee 
  <i>doen</i>. Vaak kijken we erg op tegen een bepaald (primair) gevoel, we hikken 
  ertegenaan en we willen er niet aan dat we dat gevoel hebben. We vinden dat 
  we het niet zouden moeten voelen en we willen er niet echt rekening mee houden 
  dat er situaties zijn waarin dat gevoel ontstaat of we zouden dat gevoel willen 
  kunnen overslaan...<br>
Da's logisch in een cultuur waarin niet zoveel aandacht en tijd is voor het gevoelsleven 
(ja, de grote emoties worden gebruikt om onze aandacht vast tehouden op de TV 
maar ik heb het hier over het gewoon dagelijks emotionele leven).<br>
Wat is het gevolg daarvan? Duidelijk zal natuurlijk zijn dat wij ook geen rekening 
leren houden met de situaties in ons leven die dergelijke gevoelens veroorzaken. 
We verwachten bepaalde gevoelens niet te hoeven voelen en zijn verontwaardigd 
en teleurgesteld in onszelf of in anderen als we die gevoelens wel voelen. Zo'n 
gevoel komt als een klap binnen wanneer je het toch meemaakt.</p> 
<p><b>trek...</b><br>
  En dit geldt al zeker voor gevoelens als &quot;zin in mijn middel&quot;, als 
  &quot;trek in mijn middel&quot; en al zeker voor het gevoel van &quot;jank naar 
  mijn middel&quot;.Gevoelens die heel gewoon zijn bij de aandoening verslaving. 
  Maar het zijn gevoelens waar we niet over praten, waar we niet eens over na hebben 
  leren denken.<br>
  Ja, in de verslavingszorg oude stijl, ja: &quot;Oh, heb je trek? Nou dan heb 
  je zeker nog niet &quot;<i>echt</i> beslist&quot; dat je aan je verslaving wilt 
  werken! Ga maar eens naar huis om erover na te denken of je wel gemotiveerd 
  bent!&quot; 
  <!--  Note -->
  <a href="javascript:void(0);" id="note1_title" class="note" onclick="showNote('note1');"> ! </a> 
 
<span id="note1_body" class="notehidden"> 
<div class="notebody" align="left">
		<table class="notetitle" cellspacing="0" cellpadding="0"><tr>			
	  <td height="12">Nota Bene</td>
			<td align="right"><a href="javascript:void(0);" onclick="hideNote('note1');" class="notetitle" >[&#8722;]</a></td>
		</tr></table>
		Begrijp mij goed... dit zijn geen teksten die jaren geleden te horen waren in de verslavingszorg, dit is letterlijk zo gezegd tegen een klinisch opgenomen klant... in <?php $datetime = strtotime("now");
echo (date('Y', $datetime)-1);?>!!!<BR>
		Het zal nog steeds wel gezegd worden.
	</div>
	<noscript> *zet javascript AAN*</noscript>
	</span>
	<!-- / Note -->
  Het voelen van trek is voor veel mensen zo'n onbegrijpelijk iets dat zij er geen rekening mee houden dat het nou eenmaal een normaal gevoel is dat nou eenmaal af-en-toe ontstaat bij mensen die ooit een verslaving hebben ontwikkeld. Dat zegt alleen maar dat er dingen niet geweldig lopen in je leven, dat er veranderingn moeten worden doorgevoerd om van dat gevoel af te komen.
<p> <b>het ontkennen is helaas zinloos</b><BR>
  Maar het ontkennen van het gevoel van trek is weinig zinvol want voor wat 
  voor alle gevoel geldt, dat geldt ook voor &quot;het gevoel van trek&quot;... 
  gevoelens laten zich nou eenmaal slecht ontkennen.<br>
  Dus de kans is groot dat we die emoties hoger laten oplopen en dat zij ons overvallen, 
  dat we onhandiger met emoties en gevoelens omgaan wanneer we proberen om ons 
  tegen onze gevoelens te verzetten, als we gaan vinden dat die gevoelens van 
  onszelf niet bij onszelf passen, of anders gezegd; als we onze gevoelens gaan 
  ervaren als &quot;niet in harmonie met ons zelfbeeld&quot; (in de psychologie 
  wordt dit wel met egodistoon aangeduid).<br>
  Gevoelens die we w&egrave;l bij onszelf vinden passen, daar hebben we niet zo'n 
  last van. Daar gaan we mee om, daar praten we over en we doen de dingen die 
  nodig zijn om dat gevoel af te ronden en achter ons te laten. We begrijpen dat 
  het gevoel komt en we weten dat het gevoel gaat en we pproberen ons er niet 
  tegen te wapenen. We weten dat het onze eigen gevoelens zijn en dat ze misschien 
  wel vervelend of pijnlijk kunnen zijn maar dat het maar verstandiger is om er 
  rekening mee te houden zonder dat we ons er nou direct door laten bepalen. </p>
<p>Waar het hier om gaat is de manier waarop jij naar jouw eigen gevoelsleven 
  kijkt. Waar het hier om gaat is hoe jij tegen jouw eigen trek aan kijkt.<br>
  Is jouw 'trek' een gevoel dat je niet wilt hebben? Dan zal je waarschijnlijk 
  meemaken dat het is alsof er een golf aankomt van dat gevoel die jou uit jouw 
  spoor duwt. Het is alsof een paaltje dat star rechtop in de zee probeert te 
  staan iedere keer een klap krijgt van de golf die ertegenaan slaat. In de ogen 
  van zo'n paaltje is iedere volgende golf een risico, een gevaar. En de kans 
  is aanzienlijk dat je, wanneer je met de bril van zo'n paaltje kijkt naar golven, 
  secundair de emotie angst ontstaat ontwikkeld, de angst om omver geduwd te worden. 
  Ook al is hegt maar een klein golfje, ik zal er mee bezig zijn. Golven moeten 
  worden gebroken of ik zal me ertegen moeten wapenen en minstens zal ik mij schrap moeten zetten...
<p align="right"> <i><b>Klinkt bekend?</b></i> 
<p><b>gevoelssurfen</b><br>
  Maar als het over golven gaat dan moeten we misschien eens kijken naar de specialisten 
  op het gbied van golven. Wat kunnen we hier leren van surfers?<br>
  Zij blijven niet strak stil staan maar zijn juist mobiel, speels bijna. Zij 
  proberen niet om de kracht van de golf te weerstaan maar proberen er overheen 
  te glijden op het laagste punt, proberen soms juist de kracht van de golf te 
  gebruiken om &egrave;cht te gaan surfen.
<p>Als het ons nou zou lukken om 'die golven' wat meer te herkennen als een golf 
  die <i>bij onszelf </i>hoort... Als mijn gevoel van trek een gevoel zou zijn 
  dat nou eenmaal van mijzelf is en niet buiten mij bestaat... Als we het zou 
  kunnen <i>voelen</i> dat er een aanloop en een begin, dat er een top, en een 
  teruggang is... d&agrave;n zouden we misschien kunnen ervaren dat je zelfs zou 
  kunnen surfen op de golf van d&igrave;t gevoel. Dan is de trek minder &quot;iets 
  dat je uit het lood slaat&quot; en soms misschien (want niet op alle golven 
  kan je surfen) zou het zelfs een golf kunnen blijken te zijn waar je de energie 
  van kunt gebruiken om ergens te komen.<br>
  Als we namelijk een surfmentaliteit kunnen ontwikkelen ten opzichte van 'trek' 
  dan proberen we niets te veranderen aan de golf, we proberen hem zo te &quot;pakken&quot; 
  dat we er goed uitkomen. We passen de startpositie aan, we letten erop dat we 
  niet te ver afdrijven van het punt waar we wezen willen en proberen om zo te 
  sturen dat we niet door de golf verzwolgen worden... <div class="rechtsbordertje">		
		<p><center>
 		<table border=0 cellpadding=0 cellspacing=1 class="tabelfineline">
		 <tr><td colspan="3"><h4>Borg Scale voor<br>
		  zin in-trek-jank</h4></td></tr>
		 <tr> 
	 <td>
	  <p align=center style='text-align:center'><b><i>num.</i></b></p>
	 </td>
	 <td> 
		
	  <p><b><i>woorden</i></b></p>
	 </td>
	</tr>
	<tr> 
	 <td>&nbsp; </td>
	 <td> 
		
	  <p><b>minimum</b></p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>0</p>
	 </td>
	 <td> 
		
	  <p>helemaal niets</p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		
	  <p align=center style='text-align:center'>1</p>
	 </td>
	 <td> 
		
	  <p>heel weinig (net merkbaar)</p>
	 </td>
	</tr>
	 <td> 
		<p align=center style='text-align:center'>2</p>
	 </td>
	 <td> 
		
	  <p>weinig (licht)</p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>3</p>
	 </td>
	 <td> 
		
	  <p>matig</p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>4</p>
	 </td>
	 <td>&nbsp; </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>5</p>
	 </td>
	 <td> 
		
	  <p>sterk (zwaar)</p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>6</p>
	 </td>
	 <td>&nbsp; </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>7</p>
	 </td>
	 <td> 
		
	  <p>erg sterk/zwaar</p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>8</p>
	 </td>
	 <td>&nbsp; </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>9</p>
	 </td>
	 
	<td>(bijna maximaal) </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>10</p>
	 </td>
	 
	<td> 
	  <p>extreem sterk / zwaar(maximaal)</p>
	 </td>
	</tr>
	<tr> 
	 <td>&nbsp; </td>
	 <td> 
		
	  <p><b>maximum</b></p>
	 </td>
	</tr>
 </table>
 </center></p>
</div>
<p><b>een eerste stap</b><br>
  Een eerste stap is het leren kennen van de golven. Er niet aan toe geven er 
  niet naar handelen maar kijken of je kunt voelen dat het een gevoel is met een 
  begin, een top en een het uitklinken ervan. Het is een gevoel dat voorbij gaat 
  en we kunnen ons erdoor laten leven, we kunnen ertegen vechten of we kunnen 
  die golven leren kennen.<br>
  Als we dat willen doen dan is het vaak handig om gebruik te maken van de zogenaamde 
  'Borg-schaal'. Dat is een schaal die je kunt gebruiken om de intensiteit van 
  ervaringen en gevoelens aan te geven. Het kan gebruikt worden om de ervaren 
  trainingsintensiteit aan te geven. Het wordt gebruikt om de ervaren ernst van 
  astma aan te geven. Waarom zou jij het niet gaan gebruiken om de ernst van jouw 
  trekgevoel te leren kennen?
<p><b>treksurfen</b><br>
  Waar het om draait is dat je niet gebruikt maar, terwijl je ook andere dingen 
  doet dan drinken, bijhoudt hoe de trek verloopt door op de buttons van &eacute;&eacute;n 
  tot tien aan te geven hoe sterk het gevoel is.<br>
  Telkens zal het grafiekje een seconde of 20 in beeld zijn om daarna weer naar 
  de achtergrond te verdwijnen. Dan kan je opnieuw klikken als je daar weer aan 
  toe bent.
<p><b>P.S.</b><br>
  Nog even voor alle duidelijkheid: voor deze tool moet je 'javascript' in jouw 
  browser wel 'aan' hebben staan en moet je even (tijdelijk) de popup vensters 
  w&egrave;l toe staan. 
<p>&nbsp;</P>
<!--
@@@@
<b>leesvoer</b><br>
<P>zie:<a href="http://www.helpdisk.nl/x.php?hieroo=000vers.php&daaroo=trkmomnt.php" target="_blank" class="menubutton"> 
  www.HelpDisk.nl (1000)</a></P>
<P>zie:<a href="http://www.helpdisk.nl/x.php?x=10580" target="_blank" class="menubutton"> 
  www.HelpDisk.nl (route) </a></P>
-->

<?php include "layoutinc/inc.nltemplate2.php";
?>
<form name="panel">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr><td><table width="80%" border="0" cellspacing="0" cellpadding="1">
  <tr>
			<td bgcolor="#FFFFFF" align="center" colspan="12"> buttons om te scoren van 1 t/m 10 </td></tr>
<tr>
<td bgcolor="#229922" align="center"><a title="trek voelt als 0" href="javascript: void(0);" onclick="nul();"  style="text-decoration: none; color: #000000; "><b>[0]</b></a></td>
<td bgcolor="#229922" align="center"><a title="trek voelt als 1" href="javascript: void(0);" onclick="een();"  style="text-decoration: none; color: #000000; "><b>[1]</b></a></td>
<td bgcolor="#229922" align="center"><a title="trek voelt als 2" href="javascript: void(0);" onclick="twee();"  style="text-decoration: none; color: #000000; "><b>[2]</b></a></td>
<td bgcolor="#229922" align="center"><a title="trek voelt als 3" href="javascript: void(0);" onclick="drie();"  style="text-decoration: none; color: #000000; "><b>[3]</b></a></td>
<td bgcolor="#FF7733" align="center"><a title="trek voelt als 4" href="javascript: void(0);" onclick="vier();"  style="text-decoration: none; color: #000000; "><b>[4]</b></a></td>
<td bgcolor="#FF7733" align="center"><a title="trek voelt als 5" href="javascript: void(0);" onclick="vijf();"  style="text-decoration: none; color: #000000; "><b>[5]</b></a></td>
<td bgcolor="#FF7733" align="center"><a title="trek voelt als 6" href="javascript: void(0);" onclick="zes();"  style="text-decoration: none; color: #000000; "><b>[6]</b></a></td>
<td bgcolor="#FF7733" align="center"><a title="trek voelt als 7" href="javascript: void(0);" onclick="zeven();"  style="text-decoration: none; color: #000000; "><b>[7]</b></a></td>
<td bgcolor="#FF3333" align="center"><a title="trek voelt als 8" href="javascript: void(0);" onclick="acht();"  style="text-decoration: none; color: #000000; "><b>[8]</b></a></td>
<td bgcolor="#FF3333" align="center"><a title="trek voelt als 9" href="javascript: void(0);" onclick="negen();"  style="text-decoration: none; color: #000000; "><b>[9]</b></a></td>
<td bgcolor="#FF3333" align="center"><a title="trek voelt als 10" href="javascript: void(0);" onclick="tien();"  style="text-decoration: none; color: #000000; "><b>[10]</b></a></td>
<td bgcolor="#FF3333" align="center"><a title="trek is 11 op een schaal tot 10" href="javascript: void(0);" id="11" onclick="elf();"  style="text-decoration: none; color: #000000; "><b>[11]</b></a></td>
  </tr>
</table>
</td>
	  <td align="right" rowspan="2"> <p>
		<h4>Borg Scale voor<br>
		  zin in-trek-jank</h4>
		<p></p>
 		<table border=0 cellpadding=0 cellspacing=1 class="tabelfineline">
		  <tr> 
	 <td>
	  <p align=center style='text-align:center'><b><i>num.</i></b></p>
	 </td>
	 <td> 
		
	  <p><b><i>woorden</i></b></p>
	 </td>
	</tr>
	<tr> 
	 <td>&nbsp; </td>
	 <td> 
		
	  <p><b>minimum</b></p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>0</p>
	 </td>
	 <td> 
		
	  <p>helemaal niets</p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		
	  <p align=center style='text-align:center'>1</p>
	 </td>
	 <td> 
		
	  <p>heel weinig (net merkbaar)</p>
	 </td>
	</tr>
	 <td> 
		<p align=center style='text-align:center'>2</p>
	 </td>
	 <td> 
		
	  <p>weinig (licht)</p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>3</p>
	 </td>
	 <td> 
		
	  <p>matig</p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>4</p>
	 </td>
	 <td>&nbsp; </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>5</p>
	 </td>
	 <td> 
		
	  <p>sterk (zwaar)</p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>6</p>
	 </td>
	 <td>&nbsp; </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>7</p>
	 </td>
	 <td> 
		
	  <p>erg sterk/zwaar</p>
	 </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>8</p>
	 </td>
	 <td>&nbsp; </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>9</p>
	 </td>
	 
	<td>(bijna maximaal) </td>
	</tr>
	<tr> 
	 <td> 
		<p align=center style='text-align:center'>10</p>
	 </td>
	 
	<td> 
	  <p>extreem sterk / zwaar(maximaal)</p>
	 </td>
	</tr>
	<tr> 
	 <td>&nbsp; </td>
	 <td> 
		
	  <p><b>maximum</b></p>
	 </td>
	</tr>
 </table>
 </td></tr>	<tr>  <td align="center" valign="top"> 
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p><!--a href="javascript:void(0);" onclick="showPop();" class="notetitle" > <img src="../pics/vraagtekentje.gif"> </a> (alleen even kijken)</p-->
		<p>&nbsp; </p>
		<table width="90%"  border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td>Hoe verandert het trek-gevoel als je er alleen maar benieuwd naar probeert te zijn??? Zonder dat je jouw gedrag door dat gevoel laat bepalen!</td>
  </tr>
</table>
</td></tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
  <input name="score" type="hidden" size="3">
  <input name="tijd" type="hidden" size="6">
  <input name="startsecs" type="hidden" size="6">
  <input name="laatstesecs" type="hidden" size="6">
  <input name="teller" type="hidden" size="3"><br>
   <input name="hoppa" type="hidden" size="250">
  <!--///if de hoppa te vol wordt dan moet ik afkappen.... of vooraan weghalen?-->
</form>


<!--in een ander scherm de tabel laten tekenen door javascript
dat tabelscherm verschuiven ten opzichte van de huidige scherm zodat de knoppen zichtbaar blijven. (knoppen links plaatsen) scherm naar rechts laten gaan lengte mag groeien, print mogelijkheid van grafiek inbouwen. Moglijk moet kleuring gevuld worden met pixel om te zien op papier?-->

<p>&nbsp;</p>
<script language="JavaScript1.2">
<!--
intiat();
popupTest();
//-->
</script> 

            <p>&nbsp;</p>
<?php include "layoutinc/inc.nltemplate3.php";?>
