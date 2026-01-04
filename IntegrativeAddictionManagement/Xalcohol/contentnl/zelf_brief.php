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
$hiero1="mijn brief"; 

//@@@@ is dit wel nodig???
anti_injection($HTTP_GET_VARS); 
anti_injection($HTTP_POST_VARS); 
extract($HTTP_GET_VARS);
extract($HTTP_POST_VARS);
///@@@


if ($submit != $submittxt)
{
$layoutnr="195";
include "layoutinc/inc.nltemplate0.php";
?>
<SCRIPT LANGUAGE="JavaScript">
function textCounter(field,cntfield,maxlimit) {
if (field.value.length > maxlimit) // if too long...trim it!
field.value = field.value.substring(0, maxlimit);
// otherwise, update 'characters left' counter
else
cntfield.value = maxlimit - field.value.length;
}
//  End -->
</script><?php
include "zelf_aaa_inc.php";				  
include "layoutinc/inc.nltemplate1.php";
?>
<P><b><img src="../pics/macsmiley.gif" width="16" height="14"> 
  brief aan jouw zelf</b><br>

<P>Ik zou je <i>echt</i> van harte gunnen dat ik een therapie kon aanbieden waardoor 
  je nou echt nooit meer 'trek' hebt of twijfels zou hebben over gebruik. Maar 
  als mij dat zou lukken dan moet ik misschien wel gaan solliciteren om les te 
  gaan geven op Zwijnstein aan jongetjes als Harry Potter...<BR>
  Maar toverstafjes bestaan niet en het is gewoon niet waarschijnlijk dat jij 
  in eens geheel van jouw verslaving &agrave;f bent nadat je eens besloten hebt 
  dat je wenst te stoppen. Ik hoop je op deze pagina's bij te staan in het leren 
  om er m&eacute;&eacute; te leren leven (dus niet er alleen maar iets &agrave;&agrave;n 
  te doen).<br>
  Daarvoor heb je soms motivaties nodig om aan de slag te blijven... 
<P>Vandaar dat ik je hier wil vragen om een brief te sturen aan jezelf, naar degeen 
  die jij bent als je twijfelt.<br>
  W&agrave;t wil jij zeggen tegen de persoon jij jijzelf zult zijn op de momenten 
  dat jij &quot;barst van de trek&quot;... Wat wil jij teruglezen <i>dan </i> (als 
  je er dus tijdig genoeg bij bent zodat je nog de aandacht kunt opbrengen om te lezen) <span class='rechtsbordertje'><img src='../pics/macsmiley.gif' border='0'> 
  Beste <?php echo $voornaam; ?>,<BR>
  Met mijn nuchtere mindset schrijf ik je want ik weet dat je soms bestaat. Ik 
  weet nu dingen zeker maar ik weet ook dat ik soms kan twijfelen. Daarom probeer 
  ik mijzelf &amp; jouzelf te herinneren dat...</span> 
  <?php
include "layoutinc/inc.nltemplate2.php";
?>
<p>&nbsp;</p>
Schrijf hier jouw brief aan jezelf</b> ( maximaal 250 tekens )&nbsp; 
<form name="zelf" action="<?php $_SERVER['PHP_SELF']?>" method="post">
<table border="0"><tr><td><textarea name="brief" wrap="physical" cols="42" rows="6"
onKeyDown="textCounter(document.zelf.brief,document.zelf.remLen1,250)"
onKeyUp="textCounter(document.zelf.brief,document.zelf.remLen1,250)"></textarea></td>
	  <td>nog 
		<input readonly type="text" name="remLen1" size="4" maxlength="3" value="250"> 
      tekens beschikbaar<P>&nbsp;</P>
	  <P>&nbsp;</P>
	  te verzenden over <select name="dagen">
  <option value="0">kiezen!</option>
  <option value="1">een</option>
  <option value="2">twee</option>
  <option value="3">drie</option>
  <option value="4">vier</option>
  <option value="5">vijf</option>
  <option value="6">zes</option>
  <option value="7">zeven</option>
  <option value="8">acht</option>
  <option value="9">negen</option>
  <option value="10">tien</option>
  <option value="11">elf</option>
  <option value="12">twaalf</option>
  <option value="13">dertien</option>
  <option value="14">veertien</option>
</select> dagen
</td></tr>
<tr><td align="right"><?php echo "<input type=\"submit\" name=\"submit\" value=\"".$submittxt."\">"; ?> &nbsp;</td><td>&nbsp; <?php echo "<input type=\"reset\" name=\"reset\" value=\"".$resettxt."\">"; ?></td></tr>
</table></form>

  <?php
include "layoutinc/inc.nltemplate3.php";


}else{
verzenden brief
}
?>
