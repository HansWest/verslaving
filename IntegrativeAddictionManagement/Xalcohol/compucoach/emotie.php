<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../assets/sma.css" rel="stylesheet" type="text/css">
</head>

<body>
<p>hier is de tekst</p>
<?php 
include '../assets/dbconnect.php';
$user = $_COOKIE['user_name'];


$result = mysql_query ("SELECT * FROM personalia WHERE persoon_id = '1'");
$result = mysql_query ("SELECT * FROM personalia WHERE user_name = '$user'");

//$result = mysql_query ("SELECT * FROM personalia WHERE user_name = '$user'");
///$result = mysql_query ("SELECT * FROM personalia WHERE persoon_id = '$persoon_id'");
$count = mysql_num_rows($result);

$personals = mysql_fetch_row($result);
//$row = mysql_fetch_row($result);

$_SESSION['persoon_id'] = $personals[0];
$_SESSION['user_name'] = $personals[1];
$_SESSION['emailadres'] = $personals[2];

echo "&gt;". $_COOKIE['user_name']."&lt; ";
echo "&gt;".$_SESSION['emailadres']."&lt; ";
?>
<p>en hier stopt t </p>
<p><a href="http://www.helpdisk.nl/" target="_blank">helpdisk.nl</a></p>
<p>&nbsp;</p>
<p><b>Inleiding</b><br>
Als mental-coach en therapeut heb ik in de loop van mijn carri&egrave;re veel vragen 
  gekregen over het onderwerp &quot;emotie&quot;. Voor ons allemaal een lastig 
  onderwerp waar we eigenlijk nog niet zo veel vanaf weten en waar we eigenlijk 
  ook niet zo veel handleidingen voor hebben gekregen.<br>
  Reden voor mij om me bezig te houden met een handleidinkje dat een tipje van 
  de sluier rond 'emotie-management' probeert op te lichten.<br>
  Wanneer je nadenken wilt over de emoties die jou bezig houden dan doe je er 
  verstandig aan om rekening te houden met de vier belangrijkste aspecten van 
  'emotie'.</p>
<p>Emoties hebben:
<ol>
  <li>een lading of heftigheid (lichamelijk zichtbaar/ vaak voelbaar)</li>
  <li>een richting</li>
  <li>een naam</li>
  <li>een neiging tot bepaald gedrag (in de literatuur van o.a. Frijda wel &quot;actietendens&quot; 
	genoemd)</li>
</ol>
  
<p>Een emotie is niet alleen iets dat je waarneemt, het is ook iets dat &quot;er 
  uit&quot; wil. Een emotie vraagt om gedrag dat expressie geeft aan dat gevoel. 
  Soms kan je een emotie goed herkennen aan de neiging tot bepaald gedrag. In 
  de literatuur van over emoties (ik noem hier o.a. Nico Frijda's boek) wordt 
  dit ook wel &quot;actietendens&quot; genoemd. De emotie geeft middels dit gedrag 
  een signaal of boodschap (aan anderen en/of aan mijn denkwereld). De herkomst 
  van het woord doet dat ook een beetje vermoeden. Het woord &quot;emotie&quot; 
  komt van &quot;e-movere&quot; wat je makkelijk kan vertalen met &quot;eruit 
  bewegen&quot;. Want daar zit dus gelijk de kern van onze emoties. Het is iets 
  dat er uit wil, dat naar 'de ander' wil van de groep. Het is een aanzet tot 
  dialoog, een begin van iets dat je samen doet met iemand anders. <span class="rechtsbordertje"><img src="../pics/macsmiley.gif" border="0"> De 
  angst in de ogen en de opengesperde neusgaten van de ene zebra zijn voldoende 
  voor de volgende zebra om in dezelfde richting weg te gaan rennen. Die hoeft 
  niet te wachten tot ie z&egrave;lf heeft gezien dat het om een leeuw gaat. Liever 
  staan we straks samen uit te puffen van het rennen.</span><br>
  Een emotie kunnen we ook herkennen bij een ander.<br>
  Goeie acteurs kunnen dat soms zo prachtig neerzetten. Hij speelt &quot;iemand 
  die woedend is maar die doet alsof ie niet boos is&quot;... niet makkelijk om 
  te doen alsof, als je acteur bent. Maar als je ernaar kijkt dan proef je de 
  lading gewoon. Je ziet dat er iets is zonder dat iemand laat zien dat het er 
  is... of tenminste. Iemand laat de dingen zien die iemand niet tegen zou kunnen 
  houden als ie het meemaakte. Iemand glimlacht vriendlijk maar ademt te snel 
  en te heftig. De glimlach is te strak of ie blijft net te lang hangen of breekt 
  te plotseling af, of de ogen doen niet mee, de schouders zijn net iets te strak 
  of te rechtop of de gelaatskleur net even te rood etc. etc. Je zou waarschijnlijk 
  niet eens weten waar je het aan zag maar het was helemaal duidelijk toen je 
  keek.<br>
  Een emotie is een signaal <i>aan </i>de ander en dat vangen we ook met ons emotionele 
  brein op <i>van </i>de ander. En emoties hebben een <b>richting</b> en emoties 
  hebben een <b>lading</b>.</p>
<p><b>de lading van emoties</b><br>
  Een emotie heeft een zekere heftigheid, een zekere 'lading' die je ook lichamelijk 
  kan voelen en die je terugziet in de manier van bewegen van de ander. Het is 
  ook de lading die we herkennen bij de ander. &quot;ik zie dat je boos bent maar 
  ik weet niet waarom je boos bent. of op wie je boos bent...&quot; Ja misschien 
  als we iemand naar een derde persoon hadden zien kijken. N&egrave;t te fel of 
  te lang niet met de ogen geknipperd. Dan hadden we geweten wat de richting was 
  van de boosheid. maar de lading die hadden we daarvoor al door.<br>
  De 'lading' van de emoties is de heftigheid waarmee we die emotie voelen. Ik 
  kan een beetje verdrietig zijn of ik kan verschrikkelijk verdriet hebben. Ik 
  kan mij een beetje alleen voelen of ik kan wel in de muur willen kruipen van 
  eenzaamheid. Ik kan mij een beetje schamen over de dingen die ik gedaan heb 
  of ik kan niet meer nadenken en probeer op te lossen, in de gront te zakken 
  of anderszins te verdwijnen. Ik stop zelfs met denken en durf de ander al zeker 
  niet meer aan te kijken omdat ik probeer om er zoveel mogelijk &quot;niet te 
  zijn&quot;.</p>
<p><b>Emoties hebben een richting</b><br>
  Hier maken we nog wel eens foutje doordat we de lading van onze emotie een verkeerde 
  richting geven. Klassiek voorbeeld dat v&eacute;&eacute;l gebruikt is in diverse 
  grapjes: &quot;Baas geeft een man op zijn donder op het werk... man schreeuwt 
  tegen zijn vrouw als hij thuis komt... vrouw geeft haar kind een snauw als ie 
  thuis komt na het spelen... kind geeft de hond een schop (misschien bijt de 
  boze hond wel een toevallige voorbijganger op straat... en dan is het maar te 
  hopen dat 't niet jouw baas is want dan weet je dat je morgen w&eacute;&eacute;r 
  een snauw krijgt!)&quot;<br>
  In dit grapje zie je dat we de richting van de lading kunnen verbuigen in de 
  tijd en/of naar een ander. Ik zou graag een dubbeltje krijgen voor iedere relatie-ruzie 
  die eigenlijk te maken heeft met de boosheid op ouders. Ik zou niet alleen z&egrave;lf 
  niet meer hoeven te werken... de <i>kinderen</i> van mijn <i>vrienden </i>zouden 
  niet eens meer hoeven te werken in dit leven <img src="../pics/macsmiley.gif" alt="smile" width="16" height="14" border="0" align="texttop">.<br>
  De boosheid op ouders, het verdriet om ouders, de angst voor ouders... vaak 
  krijgen die alsnog, jaren later, een richting waarin de lading er uit komt.</p>
<p><b>Emoties hebben en naam en een neiging tot gedrag</b><br>
  En als we het dan toch over verschuivingen hebben, we kunnen op de lading van 
  een emotie natuurlijk ook het verkeerde stikkertje plakken met een andere naam. We kunnen proberen 
  om van de lading van de ene emotie af te komen door hem een ander naampje te geven en, via het gedrag dat bij het verkeerde naampje hoort, te ontladen.<br>
  Op dit moment is het waarschijnlijk wel even handig om even te kijken welke 
  emoties er zoal kunnen zijn. Want er zijn natuurlijk enorm veel emoties maar 
  volgens een aantal mensen kan je bij emoties toch ook wel een paar basis-emoties 
  herkennen. Voor de duidelijkheid. Wanneer je niet weet wat je voelt dan kan 
  het helpen om eens te kijken naar de 5 basisemoties want de dingen die je voelt 
  zijn eigenlijk bijna altijd onder te brengen in &eacute;&eacute;n, of een combinatie 
  van deze 5 B's. 
<P><CENTER><TABLE BORDER=2 CELLPADDING=8 CELLSPACING=0 class="SmallLightTable80">
	  <TR>
	  <TD><b>B</b>enieuwd:
<TD>van enige nieuwsgierigheid en spel tot grote interesse
<TR>
	  <TD><b>B</b>ang:
<TD>van een beetje schrikachtig tot grote paniek
<TR>
	  <TD><b>B</b>oos:
<TD>van lichte irritatie tot laaiende woede
<TR>
	  <TD><b>B</b>edroefd: 
	  <TD>van een beetje verdrietig tot groot en pijnlijk leed
<TR>
	  <TD><b>B</b>elust/<b>B</b>egerig: 
	  <TD>van lichte tintel-opwinding tot &quot;rete-geil&quot; </TABLE></CENTER>
</p>
<p>Elders schrijf ik daar meer over maar dit overzichtje geeft een beetje zicht 
  op de belangrijkste soorten, de belangrijkste 'namen' of 'labels' die we kunnen 
  plakken op de emoties die we voelen.</p>
<p>Eigenlijk kunnen we iedere emotie proberen om te leiden van de ene emotie op 
  de andere. Maar de meest bekende is toch wel de wisselwerking tussen <b>B</b>oosheid 
  en <b>B</b>edroefd. De stalkende man die niet in staat is om toe te geven hoe 
  verdrietig het voor hem is dat 'zijn ' (?) vrouw niet meer van hem houdt, die 
  gaat wanhopig proberen om haar liefde terug te winnen door haar te gaan vervolgen 
  en pesten... Nee, niet zo'n goeie strategie, nee. maar wel een voorbeeld van 
  iemand die probeert minder verdriet te voelen door boos te doen.<br>
  Of wat denk je van de &quot;altijd lieve vrouw&quot;? &Egrave;cht vrouwelijk 
  en noooooit boos, nee. Ook als je op haar tenen gaat staan dan wordt zij maximaal 
  verdrietig. Je kan haar troosten tot je een ons weegt en haar verdriet wordt 
  niet minder want eigenlijk is zij laaiend. maar dat mag er niet uit. Dat is 
  niet vrouwelijk dus zij is verdrietig tot je er gek van wordt. De richting kan 
  zelfs nog wel dezelfde blijven maar in een poging om aan de taboe-emotie te 
  ontsnappen proberen we om de lading om te leiden naar een emotie met een (meer) 
  favoriet labeltje.</p>
<p><b>Taboe-emotie en favo-emotie</b><br>
  Hier doe ik een stelling die ik in de loop der jaren in mijn therapie&euml;n 
  vaak heb menen te mogen ontdekken: iedereen heeft zijn eigen favoriete emoties, 
  die door opvoeding of aard het &quot;lekkerst liggen&quot; en er het makkelijkst 
  uitkomen. En iedereen heeft door diverse redenen taboe-emoties. dat kan zijn 
  omdat ze zo licht ontvlambaar waren, het kan zin dat ze taboe zijn omdat de 
  ouders er niet mee overweg konden of ze niet hebben geleerd hoe je die emotie 
  kon begrijpen en hoe je ermee om moest gaan. Maar ik denk dat de meeste mensen 
  hun favoriet(en) hebben en hun taboe(s).<span class="rechtsbordertje"><b>Wat 
  is jouw &quot;taboe-emotie&quot;?...<br>
  &nbsp; &nbsp; &nbsp;en op welk spoor wordt ie omgeleid?</b></span><br>
  Dat kan handig zijn om even bij stil te staan wat deze zijn voor jou. Het is 
  mij vaak gebleken dat mensen hun taboe-emotie proberen om te stickeren tot favo-emotie 
  (en dus uiteindelijk blijven zitten met een hoop van die taboe-emotie).<br>
  Want je kan zeggen wat je wilt. Het lijkt er toch op dat de emoties waar we 
  niks <i>mee</i> doen, dat die lang blijven hangen.</p>
<p><b>Iets doen AAN of iets doen MET</b><br>
  Waarmee we komen aan de vraag of we iets kunnen doen aan onze emoties. Kunnen 
  we ze wegpoetsen? Wegdenken, dan? Ik denk dat de DEL-toets alleen op een computer 
  zit en niet in ons brein.<br>
  Kan ik dan spontaan extase voelen omdat ik dat graag zou willen?..<br>
  Natuurlijk kunnen we iets doen <i><b>voor </b></i>onszelf zodat bepaalde gevoelens 
  makkelijker ontstaan... Zeker kunnen we iets doen <b><i>met </i></b>onze emoties 
  en daardoor veranderen ze ook in het gevoel dat we er zelf bij hebben. Maar 
  we kunnen er niks <b><i>aan</i></b> doen. Als we bijvoorbeeld proberen om boosheid 
  maar niet te voelen en in &eacute;&eacute;n keer door te stappen naar vergeving 
  dan klinkt dat vaak prachtig maar vaak zie je na verloop van tijd toch het vergif 
  tussen de naadjes van de doos van vergiffenis uit komen. Het wil toch niet zo 
  lukken.<br>
  Als we in staat zijn om onze woede uit te spreken en te kanaliseren, het even 
  een andere richting te geven als ik sta te schoppen en te slaan maar wel in 
  de richting van degeen die mijn boosheid verdient vertel hoe kwaad ik ben geworden 
  en waarom en ik spreek op dat moment uit dat ik nooit zal vergeten maar mijn 
  best zal doen om te vergeven. Dan heb ik al meer kans dat het mij lukt.<br>
  Kunnen we gevoel uit zetten? Ik vraag het mij sterk af. We kunnen proberen om 
  niet te horen wat ons gevoel ons zegt. We kunnen proberen om er niet op te reageren 
  en afleren om het te herkennen. We kunnen proberen om het chemisch te verdoven. 
  Maar krijgen we het weg? <span class="rechtsbordertje">Tijd heelt niet alle 
  wonden, het draait er om wat je met die tijd doet</span>.<br>
  Ik heb ooit eens een klant horen zeggen: &quot;ik kon vijf jaar drinken om geen 
  last te hebben van de rouw om de dood van mijn vrouw. Maar toen ik stopte en 
  weer nuchter was, was ik op het punt van 5 jaar terug. met het nadeel dat ik 
  er 5 jaar problemen <i>bij </i>had en vooral met het nadeel dat ik op het punt 
  van rouwen stond terwijl al de mensen die ook van haar hielden inmiddels waren 
  uitgerouwd...&quot; </p>
<p><!--Emoties en de wet van de communicerende vaten.--></p>
<p><b>Om welk gevoel gaat het hier?</b><br>Veel mensen hebben last van hun emoties omdat het allemaal te veel wordt, omdat 
  het allemaal aan elkaar klontert en groot wordt en zo groot voelt dat je er 
  niks meer mee kan doen. Wanneer we &eacute;&eacute;n gevoel aanduiden met twee 
  namen of vooral wanneer we twee gevoelens aan elkaar plakken dan wordthet leven 
  in &eacute;&eacute;n keer exponentieel ingewikkelder.<br><b><i>Voorbeeldje (gemis is niet hetzelfde als verlangen):</i></b><br>Iedereen loopt rond met een gat in zijn ziel. Toegegeven, de &eacute;&eacute;n 
  heeft een dijk van een gat en de volgende heeft maar een klein gaatje maar iedereen 
  heeft dingen <i>niet</i> meegemaakt in zijn/haar jeugd die je graag <i>w&egrave;l</i> 
  had willen meemaken...'t is jammer, 't is pijnlijk maar dat is wat het is. Het 
  is een gemis...<br>
  Veel mensen voelen geen &quot;gemis&quot;... Zij voelen de emotie &quot;Gemis&amp;Verlangen&quot;... 
  een soort gekoppeld gevoel van deze twee samen. Dat dus ook samen een soort 
  dubbele lading krijgt wanneer ik in een bepaalde richting denk die dat gevoel 
  (of mogelijk maar &eacute;&eacute;n van de twee) uitlokt. Duidelijker voorbeeld, 
  nog? <br>
  Ik heb een aantal dingen niet gekregen van mijn vader. Daar was hij niet toe 
  in staat en dat heb ik wel duidelijk gemist. Dat is een leegte in mijn hart 
  of in mijn ziel waar ik mee zal moeten leren leven en <i>als </i>er al iemand 
  in staat zou kunnen zijn om die leegte te vullen dan ben ik dat <i>zelf</i>. 
  Maar als ik ga hopen, ga zitten wensen of verwachten dat ik dat gat alsnog ingevuld 
  ga krijgen in mijn leven, d&agrave;n voel ik ook het gevoel van verlangen. En 
  als ik deze twee niet uit elkaar houd, dan voel ik een verlangen dat net zo 
  groot is als het gemis.<br>
  Als ik mijzelf de discipline gun om erbij stil te staan dat ik nou eenmaal een 
  aantal dingen niet heb gehad in mijn verleden (zonder daarbij dan gelijk in 
  shuld-denken te gaan vervallen) en dat dat <i>mijn </i>gat in m'n ziel is, waar 
  <i>ik </i>de verantwoordelijkheid voor draag en waar <i>ik </i>mee zal moeten 
  leren leven. Hij is al dood en kan mij, zelfs bij zijn leven toch al niet meer 
  geven wat hij mij in mijn jeugd niet gegeven heeft (ook al heeft hij daar wel 
  pogingen toe gedaan). Als ik bij dit soort overwegingen stil sta dan is ineens 
  de lading van het gevoel een stuk minder. Zeker bestaat het gemis waar ik soms 
  om kan janken. Maar er bestaat ook de zelfzorg en de zorg voor anderen die mij 
  een gevoel van eigenwaarde geeft. En de verwachting dat het nog allemaal goed 
  komt is een illusie, een hoop uit mijn kindertijd waar ik naar kan glimlachen 
  maar die ik niet al te serieus moet nemen.<br>
  Als ik &quot;gemis&quot; en &quot;verlangen&quot; uit elkaar pluis, dan blijf 
  ik een stuk gelukkiger, dan heb ik minder de emotionele behoefte om dingen te 
  doen waar ik achteraf toch maar weer spijt van krijg. Dan heb ik minder de neiging 
  om onhandige pogingen te ondernemen om het ingevuld te krijgen en heb ik minder 
  de neiging om mijn gevoelswereld te verdoven om iets niet te voelen. Het is 
  <i>mijn </i>gat en ik zorg zelf voor de afgrenzing ervan.</p>
<p><b>De 'regels' van het emotie-management</b><br>
Ik krijg vaak de vraag "hoe moet ik dan met mijn gevoel om gaan?" en daar kan ik natuurlijk niks algemeens over zeggen want dat verschilt van persoon tot persoon en van situatie tot soituatue en van gevoel tot gevoel. Maar er zijn wel een aantal 'regels' waar je rekening mee moet leren houden bij de omgang 
  met emoties als je ze een beetje in de hand wil houden op de lange termijn.
<UL>
  <LI><B>Regel 1</B> ­ Ook al is de &eacute;&eacute;n emotioneler en ontvlambaarder 
	dan de ander. In een mensenleven zijn de basis emoties er <i>allemaal</i> 
	(soms zelfs meerdere tegelijk naast elkaar waarbij de lading dan bij elkaar 
	optelt) 
  <LI><B>Regel 2</B> ­ Iedereen heeft z'n favoriete, en z'n taboe emoties (maar 
	regel 1 geldt) 
  <LI><B>Regel 3</B> ­ Emoties hebben altijd een lading en een richting en zij 
	hebben hun eigen gedrag of actietendens (de neiging om iets te gaan doen vanuit 
	die emotie). 
  <LI><B>Regel 4</B> ­ Wanneer de lading van een emotie hoog genoeg is opgelopen 
	staat de activiteit van het emotionele brein in de weg van het vermogen om 
	nog zinvol na te denken op neo-cortex niveau (vaak het moment dat we dingen 
	beginnen te doen waarvan we achteraf zeggen: &quot;hoe haalde ik het in m'n 
	kop om...&quot; 
  <LI><B>Regel 5</B> ­ De manier om iets AAN je emotie te doen is om er iets MEE 
	te doen. Als je iets MET een emotie doet, dan doe je er ook iets AAN omdat 
	de emotie erdoor verandert. Als je alleen maar probeert iets <i>aan </i>een 
	emotie te doen, in de zin dat je 'm weg probeert te werken -bijvoorbeeld door 
	te drinken-, dan doe je er dus niks <i>mee </i>en bijgevolg verandert ie weinig 
	in de loop der tijd. 
  <li><b>Regel 6a</b> ­ Ik hoef mij niet door mijn emoties te laten regeren wanneer 
	ik beslis dat ik er iets mee wil doen. Ik hoef er niet achteraan te rennen, 
	ik kan uitstellen en afreageren en er op een ander moment een verstandige 
	plaats voor maken in mijn leven om de lading te ontladen (maar dan moet ik 
	er wel voor gezorgd hebben dat de lading niet <i>te</i> hoog is opgelopen 
	want regel 4 gaat voor) 
  <LI><B>Regel 6b</B> ­ Je kan de energie van de &eacute;ne emotie proberen om 
	te leiden via het spoor van de ander. Maar dan probeer je dus iets &aacute;&aacute;n 
	de eigenlijke emotie te doen door het om te leiden via het gedrag van een 
	andere. Anders gezegd: Je probeert iets AAN een emotie te doen door iets MET 
	een <i>andere</i> emotie te doen (dat werkt niet want regel 4a geldt). 
  <LI><B>Regel 7</B> ­ Als ik woorden kan geven aan de dingen die ik voel dan 
	kan dit de band met iemand anders verdiepen, de samenwerking verduidelijken. 
	De prijs is dat iemand mij dus ook meer zal kunnen 'raken'. Dus dit moet ik 
	wel bewaren voor de mensen die het waard zijn en die ik vertrouw. En tevoren 
	moet je natuulijk wel inschatten of iemand wel zo veel verdieping <i>wenst 
	</i>in de relatie die je samen hebt. 
</UL>
<P><b>Epiloog</b><br>
  Ik hoop dat je een beetje een vruchtbaar overzichtje hebt gekregen van het emotiemanagament 
  volgens West. <img src="../pics/macsmiley.gif" alt="smile" width="16" height="14" border="0" align="texttop"><br>
  Speel er eens mee, probeer eens uit. Wees eens nieuwsgierig en doe iets nieuws 
  en kijk eens of er niet veel levensgeluk zou kunnen zitten in het onderzoeken 
  van jouw taboes en angsten.</P>
<P>Per slot van rekening kan je alleen iets <i>anders </i>verwachten als je de 
  dingen <i>anders </i>aanpakt.</P>
</body>
</html>
