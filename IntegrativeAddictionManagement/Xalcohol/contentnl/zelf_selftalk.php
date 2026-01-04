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
$hiero1="selftalk"; 
$layoutnr="425";

//@@@@ is dit wel nodig???
anti_injection($HTTP_GET_VARS); 
anti_injection($HTTP_POST_VARS); 
extract($HTTP_GET_VARS);
extract($HTTP_POST_VARS);
///@@@


include "layoutinc/inc.nltemplate0.php";
include "zelf_aaa_inc.php";				  
include "layoutinc/inc.nltemplate1.php";
?>
<!--- Hier start de koptekst  --->
<b> <img src="../pics/uitroeptekentje.gif" alt="Nota Bene" width="12" height="12"> 
Let een beetje op de manier waarop je tegen jezelf praat...</b>
<p>Een ontwenningsperiode is vaak een periode waarin je jezelf ook een beetje 
  op een nieuwe manier leert kennen. Je komt soms gevoelens tegen die je niet 
  van jezelf verwacht had. Let er dan goed op hoe je tegen jezelf praat en hoe 
  je tegenover anderen praat over de dingen die je voelt (doordat je stopte met 
  verslaafd drinken). Want de manier waarop je er tegenover jezelf over <i>praat</i>, 
  dat bepaalt ook weer de manier waarop je het <i>ervaart</i>.</p>
<p>Als je tegen jezelf zegt dat het &quot;ver-schrik-ke-lijk&quot; is... dan is 
  de kans dat je het ook zo gaat ervaren ook groot geworden... en daarmee de kans 
  op uitglijers en zelfs terugval waarschijnlijk vertienvoudigd.</p>
<p>Dat is ook de reden waarom je jezelf niet al te veel moet aan trekken van de 
  idee&euml;n van andere verslaafden (of zij dat nou aan zichzelf toegeven of 
  niet). Want zelfs als zij jou met goed bedoelde interesse opbellen omdat het 
  toch &quot;zo ont-zet-tend knap is&quot; dat je nog st&eacute;&eacute;ds niet 
  rookt, dan zeggen ze tussen de regels dat het toch wel af-grij-se-lijk moet 
  zijn... <i>Zelfs </i>als die groep mensen jou met goed bedoelde interesse opbelt 
  om je te vertellen dat het toch &quot;zo ont-zet-tend knap is&quot; dat je nog 
  st&eacute;&eacute;ds niet drinkt, dan zeggen ze daarmee natuurlijk wel even 
  tussen de regels &quot;dat het toch wel af-grij-se-lijk moet zijn&quot;... <i>Natuurlijk 
  </i>is het lastig en je moet echt je kop erbij houden.<br>
  Maar als je er nou even &egrave;cht bij stil gaat staan... is het dan <i>werkelijk 
  </i>zo afgrijselijk? Is het bijvoorbeeld vergelijkbaar met het onverdoofd uittrekken 
  van jouw nagels?<br>
  Begrijp mij goed ik zeg niet dat het niet <i>vervelend </i>is, misschien zelfs 
  bij tijd en wijle echt h&eacute;&eacute;l vervelend. Ik zeg niet dat het niet 
  vermoeiend is of dat het niet lastig is, en wennen aan de veranderingen... Maar 
  is het werkelijk <b><i>afgrijselijk?</i></b> </p>
<p><b>self-talk</b><br>
  In de therapie/coachingwerled zij er een hele hoop termen voor. Ik gebruik vaak 
  de term 'interne dialoog' of de term 'self-talk'. Waar het om gaat is dat iedereen 
  met zichzelf praat en dat we dat niet altijd op een handige manier doen. </p>
<p class="bordertje"><b><img src="../pics/macsmiley.gif" width="16" height="14"> 
  self-talk oefening:</b> ga er echt even voor zitten. Neem er een kopje thee 
  of koffie bij en bedenk je eens op welke toon je nou vaak tegen jezelf spreekt...</p>
<p>Dat kunnen aardige dingen zijn, dat kunnen strenge of onaardige dingen zijn.<br />
  Vaak hoor ik bij mensen met een verslaving dat zij zichzelf echt enorm op hun 
  kop kunnen geven, regelrecht uitschelden, soms: &quot;Hoe k&agrave;n je nou 
  ook zo stom zijn stomme *piep*&quot;, &quot;Je moet ook niet altijd ...&quot; 
  of &quot;Je moet ook v&eacute;&eacute;l meer ...&quot; &amp; &quot;Wat ben je 
  toch ook een idioot om ... etc. etc.&quot;<br>
  Begrijpelijk hoor, want de gevoelens kunnen ook hoog oplopen als je weer gedaan 
  blijkt te hebben wat je achter je wilde laten.<br />
  Maar heeft het zin?</p>
<p>In de therapie-/coachingwereld zijn hier een hele hoop termen voor. Ik gebruik 
  vaak de term 'interne dialoog' of de term 'self-talk'. Waar het om gaat is dat 
  iedereen met zichzelf praat en dat we dat niet altijd op een handige manier 
  doen. Laten we er dus even voor zorgen dat we een manier van 'self-talk' zoeken 
  die je ook stimuleert en motiveert om door te gaan als het weer eens wat traag 
  gaat of vervelend is.</p>
<p class="bordertje"><img src="../pics/macsmiley.gif" width="16" height="14"> Heb je er ñcht even de tijd voor genomen?<br>
  Schrijf dan eens <b>drie zinnetjes</b> op die wel eens &quot;wat <i><b>minder 
  </b></i>zouden kunnen&quot; en <b>drie zinnetjes </b>die je wel eens <i><b>wat 
  vaker tegen jezelf zou mogen zeggen</b> (let daarbij ook op 'de toon' en bedenk je hoe je het uit zou spreken tegen jezelf).</i></p>
<p></p>
<p><b><img src="../pics/uitroeptekentje.gif" alt="Nota Bene" width="12" height="12">
  Zoek voor jezelf een taal die je stimuleert, en gun jezelf dat je niet tegen 
  jezelf praat met woorden die je ontmoedigen of ondermijnen.</b> </p>
<?php

if($mce==""){
print ("<p><INPUT TYPE=\"button\" VALUE=\"  terug naar vorige pagina  \" onClick=\"history.go(-1)\"></p><p>&nbsp;</p>");
}
?>
<!--- Hier eindigt  de koptekst  --->
<?php
include "layoutinc/inc.nltemplate2.php";
?>
<!--- Hier starten de vragen  --->
<p>en hier dus gaan kijken naar een database die je zelf de mail stuurt (of een 
  kaartje stuurt) dat je helpt herinneren wat je voor jezelf had gestelt... Dat 
  principe kan op meerdere plekken worden gebruikt zonder dat je dan lang dingen 
  in de datbase hoeft te bewaren 
  <?php

if($mce==""){
print ("<p><img src='../pics/macsmiley.gif' border='0'> <b>Denk eens na over de woorden die je wel eens wat vaker, en over de woorden die je beter wat minder kunt gebruiken...</b>");
	print ("<form METHOD=\"POST\" action=\"?mce=verstuur\">\n");
	print ("<table align=\"center\" border=\"0\" padding=\"0\">");
	print ("<tr><td align=\"left\" valign=\"top\"><img src='../pics/mensje.gif' alt='mens invoer' width='10' height='12' border='0'> naam:</td>"); 
	///hidden
	   print ("<input type='hidden' name='to' value='$hiddento'>"); 
	
	print ("<td><select name=\"mv\"><option value=''>M/V</option><option value='mevrouw'>mevrouw</option><option value='de heer'>meneer</option></select>");
	print (" &nbsp; <input type=\"text\" name=\"name\"></td></tr>"); 
	print ("<tr><td align=\"left\" valign=\"top\"> <img src='../pics/mensje.gif' alt='mens invoer' width='10' height='12' border='0'> e-mail adres:</td>"); 
	 print ("<td><input type=\"text\" name=\"emailadres\" size=\"40\"></td></tr>"); 
	print ("<tr><td align=\"left\" valign=\"top\"><label><img src='../pics/mensje.gif' alt='mens invoer' width='10' height='12' border='0'> uit provincie:<td><select name=\"provincie\"><option value=''>Keuze A.U.B.</option><option value='NoordHolland'>Noord Holland</option><option value='Utrecht'>Utrecht</option><option value='ZuidHolland'>Zuid Holland</option><option value='Brabant'>Brabant</option><option value='Zeeland'>Zeeland</option><option value='Limburg'>Limburg</option><option value='Gelderland'>Gelderland</option><option value='Drenthe'>Drenthe</option><option value='Overijsel'>Overijsel NL</option><option value='Groningen'>Groningen NL</option><option value='Friesland'>Friesland (NL)</option><option value='Belgie'>Belgi&euml; BE</option></select></label></td></tr>");	
	print ("<tr><td align=\"left\" valign=\"top\"><img src='../pics/mensje.gif' alt='mens invoer' width='10' height='12' border='0'> bericht:</td>"); 
	print ("<td><textarea cols=\"40\" rows=\"5\" name=\"message\"></textarea></td></tr>"); 
	print ("<tr><td>"); 
	print ("</td>"); 
	print ("<td><p align=\"right\"><font size=\"1\">Nota Bene: ALLE velden moeten worden ingevuld...<BR>anders kan namelijk het bericht niet worden verzonden.</font></p>"); 
	print ("<input type=\"submit\" value=\"$submittxt\"> \n"); 
	print ("<input type=\"reset\" value=\"$resettxt\">\n"); 
	print ("</td></tr></table>"); 
	print ("</form>\n"); 
} 
if($mce=="verstuur"){
  ///  print (extract($HTTP_GET_VARS)); ////
  ///  print (extract($HTTP_POST_VARS)); //////
  ///  print (">>$mce-$to - $mv - $name<<"); /////
    $to = trim($_POST["to"]); 
    $mv = trim($_POST["mv"]); 
    $name = trim($_POST["name"]); 
    $provincie = trim($_POST["provincie"]); 
    $emailadres = trim($_POST["emailadres"]); 
    $emailadres=strtolower($emailadres);
$message = trim($_POST["message"]); 
    if (($name == "") OR ($emailadres == "") OR ($provincie == "") OR ($message == "")) { 
        print ("<center><h3>"); 
        print ("<img src='../pics/macmandwn.gif' alt='mislukt' width='23' height='28'><font color=\"red\">Een van de velden is leeg gelaten. Wil je alle velden invullen? (ook de provincie)</font><br><br>"); 
        print ("<a href=\"javascript:history.back()\";></h3>&lt;= naar vorige pagina &lt;=</A><br></center>"); 
       $mce="";
	    
    }elseif(ereg("^([._a-z0-9-]+[._a-z0-9-]*)@(([a-z0-9-]+\.)*([a-z0-9-]+)(\.[a-z]{2,3})?)$", $emailadres)) { 
        $recipient = $to; 
        $subject = $the_subject; 
        $additional_headers = ("From: $emailadres\n"); 
////
////include 'dbconnectfb.php';
///mysql_select_db('HELPDISK');
//$sql = "INSERT INTO verzamel (id, name, url, category) VALUES ('', '$name', '$emailadres', 'alcohol')";
////$sql = "INSERT INTO url (id, mv, name, eadres, adres, stad, provincie, category) VALUES ('', '$mv', '$name', '$emailadres', '', '', '$provincie', 'FuzzyFr')";
///$result = mysql_query ($sql);

////
//$body = "Hallo,<br><br>Uw kennis $name ($emailadres) leek het een aardig idee als je naar onze website $site_name zou kijken. De boodschap ie daarbij gegeven werd is:<br>" . $message . "<br> Dank u,<br>namens het management"; 
$body = "Hallo,\r\n$mv $name ($emailadres) uit $provincie heeft op $site_name een boodschap verstuurd. De boodschap die daarbij opgegeven werd is:\r\n" . $message ; 
$clbody = "Hallo,<BR>$mv $name ($emailadres) uit $provincie heeft op $site_name een boodschap verstuurd. De boodschap die daarbij opgegeven werd is:<BR><font color=\"red\">" . $message . "</font><BR> Dank je voor het verzenden van deze boodschap"; 
        if(mail($recipient, $subject, $body, $additional_headers)) { 
            print ("<img src='../pics/macmanup.gif' alt='geslaagd'> Het $site_name script mailde succesvol naar $to:<br><i>$clbody</i>.<p>"); 
        }else{ 
            print ("<img src='../pics/macmandwn.gif' alt='mislukt' width='23' height='28'><font color=\"red\">Oeps! er lijkt een storing te zijn opgetreden... kun je mij daarvan op de hoogte stellen A.U.B.?</font><p>"); 
            $mce="";
 } 
    }else{ 
        print ("<center><h3>"); 
        print ("<img src='../pics/macmandwn.gif' alt='mislukt' width='23' height='28'><font color=\"red\">$emailadres... Dit lijkt geen re&euml;el e-mailadres te zijn.<br>Wil je dit nog even nakijken?</font><br><br>"); 
     print ("<a href=\"javascript:history.back()\";></h3>&lt;= naar vorige pagina &lt;=</A></div><br></center>"); 
     } 

}
?>
</p>
<p>Sta er ook even bij stil of dit nog gevolgen heeft voor jouw stategie, misschien?</p>
<p>&nbsp;</p>            
   </div></td>
<!--- Hier stoppen de vragen  ---><?php
include "layoutinc/inc.nltemplate3.php";
?>
