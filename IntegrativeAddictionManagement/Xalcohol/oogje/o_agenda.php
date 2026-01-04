<? 

function chopline($str) { return preg_replace("/\r?\n$|\r[^\n]$/", "", $str); }
function addjsslashes($str) { return addcslashes($str, "\0..\37!@\@\177..\377\'\""); }

if($_POST) { extract($_POST, EXTR_PREFIX_SAME, "post_"); }
if($_GET) { extract($_GET, EXTR_PREFIX_SAME, "get_"); }

$file = "appointments.txt.php";

$n = 0;
$list = array();

$fp = fopen($file, "r");
while (!feof($fp)) {
	$time = fgets($fp, 1024);
	$place = fgets($fp, 1024);
	$event = fgets($fp, 1024);
	if ($time && $event) {
		$list[$n][0]= chopline($time);
		$list[$n][1]= stripcslashes(chopline($place));
		$list[$n][2]= stripcslashes(chopline($event));
		$list[$n][3]= $n;
		$n++;
	}
}
fclose($fp);

if($act == "del") {
	array_splice($list, $nr, 1); }
	
if($act == "add") {
	$s = sizeof($list);
	$da = split("/",stripcslashes($newdate));
	//$newtime = $newtime.":00";
	$ta = split(":",stripcslashes($newtime));
	$list[$s][0] = mktime($ta[0],$ta[1],0,$da[1],$da[0],$da[2]);
	$list[$s][1] = stripcslashes($newplace);
	$list[$s][2] = stripcslashes($newevent);
	$list[$s][3] = $s; }

if($act) {
	$fp = fopen($file, "w");
	for ($i=0; $i<sizeof($list); $i++) {
  		fputs($fp, $list[$i][0]."\n");
  		fputs($fp, addjsslashes($list[$i][1])."\n");
  		fputs($fp, addjsslashes($list[$i][2])."\n");
	}
	fclose($fp);
	header("Location: todo.php"); }

// birthday functionality from here

$birthdayPlace = "Birthday !";
$file = "contacts.txt.php";

$n = 0;
$birthdays = array();
$thisyear = date('Y',time());

$fp = fopen($file, "r");
while (!feof($fp)) {
	$name = fgets($fp, 1024);
	$address = fgets($fp, 1024);
	$phone = fgets($fp, 1024);
	$email = fgets($fp, 1024);
	$birthday = fgets($fp, 1024);
	$cat = fgets($fp, 1024);
	if ($name && $cat) {
		$birthdays[$n] = split("/",$birthday);
		
		// these lines are for correcting the +1 jump between december - januari 
		if (date('m',time()) >= 11 && $birthdays[$n][1] < 02) { $thisyear = date('Y',time())+1; } 
		else { $thisyear = date('Y',time()); }
		
		$birthdays[$n][0] = mktime(0,0,0,$birthdays[$n][1],$birthdays[$n][0],$thisyear);
		$birthdays[$n][1] = $birthdayPlace;
		$birthdays[$n][2] = $name." turns ".($thisyear-$birthdays[$n][2]);
		$birthdays[$n][3] = "birthday";
		$n++; } }
fclose($fp);


for($i=0; $i<sizeof($birthdays); $i++) {
	if ($birthdays[$i][0] < time()+2600000 && $birthdays[$i][0] > time()-900000) {
		array_push($list, $birthdays[$i]); } }

array_multisort($list);

include("header.php"); 

?>

<table width="100%" border="1"  cellpadding="0" cellspacing="0"  style="@@@"><tr>
    <td align="center"><a target="_self">Idee&euml;n</a></td>
    <td align="center"><a target="_self">Plannen</a></td>
    <td align="center"><a target="_self">To Do's</a></td>
    <td align="center"><a target="_self">Agenda</a></td>
</tr></table> </p>
<table width="560" cellspacing="0" cellpadding="4" border="0">
<tr class="row"><td width="25%"></td>
    <td class="row" colspan="2" width="60%">toekomst</td>
    <td class="row"width="15%">acties</td>
  </tr>

<?
for ($i=0; $i<sizeof($list); $i++) {
	if ( $list[$i][0] >= time() ) {
		if (round($i/2) != $i/2) { echo "<tr class=light>"; } else { echo "<tr>"; }
		echo "<td valign=top>".date("d/m/y H:i (D)", $list[$i][0])."</td>";
		echo "<td>".$list[$i][1]."</td>";
		echo "<td>".$list[$i][2]."</td><td>";
//		if($list[$i][3] !== "birthday") { echo "<a href=\"todo.php?act=del&nr=".$list[$i][3]."\">delete</a>"; }
		echo "</td></tr>"; } }
?>

<tr><td colspan="4">&nbsp;</td></tr>
<tr class="row"><td></td>
    <td class="row" colspan="3">verleden</td>
  </tr>

<?
for ($i=sizeof($list)-1; $i>=0; $i--) {
	if ( $list[$i][0] <= time() ) {
		if (round($i/2) != $i/2) { echo "<tr class=light>"; } else { echo "<tr>"; }
		echo "<td valign=top>".date("d/m/y H:i (D)", $list[$i][0])."</td>";
		echo "<td>".$list[$i][1]."</td>";
		echo "<td>".$list[$i][2]."</td><td>";
//		if($list[$i][3] !== "birthday") { echo "<a href=\"todo.php?act=del&nr=".$list[$i][3]."\">delete</a>"; }
		echo "</td></tr>"; } }
?>

<form name="frm" method="post" action="todo.php?act=add">
<tr><td colspan="4">&nbsp;</td></tr>
<tr class="row"><td></td>
      <td class="row" colspan="3">to do toevoegen</td>
    </tr>
<tr><td>datum:</td><td colspan=2><input name="newdate" type="hidden" value="31/12/3000">
<!--input name="newdate" maxlength="10" style="width:133px" value="<? echo date("d/m/Y",time()); ?>">
<input name="newtime" maxlength="5" style="width:103px" value="<? echo date("H:i",time()); ?>"--></td>
<td></td></tr>
<tr><td>wat:</td><td colspan=2><input name="newevent"></td><td><a href="javascript:document.frm.submit()">voeg toe</a></td></tr>
<tr><td>prioriteit:</td><td colspan=2><input name="newdate" type="hidden" value="31/12/2020">
<!--input name="newtime" maxlength="1" style="width:103px" value="<? echo date("H:i",time()); ?>">-->
       <select name="newtime" ><option value="00:01" >hoogst</option><option value="00:02" >hoger</option><option value="00:03" selected>middel</option><option value="00:04" >lager</option><option value="00:05" >laagst</option></select>
       <BR> (1 hoogst - 5 laagst)</td>
<td></td></tr>
<tr><td>waar:</td><td colspan=2><input name="newplace"></td><td></td></tr>
</form>Button name [reality check] Tip=case(urgent =5 vandaaq CheckAantalTakenVandaag
</table>

<? include("footer.php"); ?>