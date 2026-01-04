<?php
include "gegevens_sma.php";
include "../assets/formulas.php";
session_start();
$persoon_id = $_SESSION['persoon_id'];
$voornaam = $_SESSION['voornaam'];

$strategie = $_SESSION['strategie'];
$strategieduur = $_SESSION['strategieduur'];
$evaldatum = $_SESSION['evaldatum'];
$totevaldatum = $_SESSION['totevaldatum'];
$nextstep = $_SESSION['nextstep'];


//Zorgen dat $_POST en $_GET niet meer vatbaar zijn voor SQL injection 
anti_injection($_POST); 
anti_injection($_GET);
///

$datum = date('Y-m-d', strtotime($jjjjmmdd));
$jaar= date('Y', strtotime($datum));
$maand= date('m', strtotime($datum));
$dag= date('d', strtotime($datum));
///
$layoutnr="361";

$hiero1="submenu"; 

include "layoutinc/inc.nltemplate0.php"; 
include "persoon_aaa_inc.php";
include "layoutinc/inc.nltemplate1.php";
?>
            
<br />
<p><img src="../pics/macsmiley.gif" border="0" /> <b>personalia van <?php echo $voornaam; ?></b><br>
  Een (mogelijke) verslaving is een persoonlijk probleem dus ik heb graag het
    e.e.a. aan personalia.
<p>Als je er iets tussen ziet dat je niet aan staat, of dat je niet wilt beantwoorden,
  laat het links liggen en kom er later op terug of sla het gewoon helemaal over
  omdat <i>jij </i>het
   gewoon  niet nodig hebt om die vraag te beantwoorden. Ieder ontwenningstraject
 is persoonlijk en niet alles geldt voor iedereen.<br>
  Het kan echter wel zijn dat er vragen tussen zitten waar ik antwoord op moet
  hebben om <i>door</i> te kunnen. Dus mocht ik iets zeggen wat je werkelijk
  absolute onzin zou vinden dan vraag ik je te mailen. Misschien is er in het
  programmeren iets misgegaan of mogelijk kan ik uitleggen waar de schoen wringt.</P>
            <?php
 include "layoutinc/inc.nltemplate2.php";
 ?>
<table border="0" width="100%"><tr><td  valign="top">
 <img src="../pics/macsmiley.gif" border="0" /> <?php echo( "Beste ".$voornaam.", welkom bij:");?>
 <p>hier wil graag vragen naar wat persoonlijke gegevens:
<ul>
<li><a href="persoon_ik.php" target="_self" class="menubutton">gegevens</a> - algemene persoonsgegevens</li>
<li><a href="persoon_partner.php" target="_self" class="menubutton">partner</a> - info, eventueel, over uw relatie</li>
<li><a href="versl_gesch1.php" target="_self" class="menubutton">de start</a> - het begin van uw drankgebruik</li>
</ul></p>
	  <p align="right">&nbsp;</p>
 </td><td valign="top" align="right">
	<h3><?php echo($prognaamkort);?>&nbsp; &nbsp; &nbsp;<?php echo($prognaamlang);?></h3>
	  <p>ook wel: SMD (Stop Met Drinken)</p>
      <p><i>Deze site is een ondersteuning voor de mensen die<br>
        een (beginnende) verslaving ontwennen.</i></p>
	  <b> onderdeel van Compu-Coach / HelpDisk.nl</b>
	<br><i>voor computer aided self-coaching</i></p>
</td></tr></table>
</p>
<?php
include "layoutinc/inc.nltemplate3.php";
?>           
