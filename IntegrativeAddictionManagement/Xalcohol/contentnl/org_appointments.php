<? 

function chopline($str) { return preg_replace("/\r?\n$|\r[^\n]$/", "", $str); }
function addjsslashes($str) { return addcslashes($str, "\0..\37!@\@\177..\377\'\""); }

if($_POST) { extract($_POST, EXTR_PREFIX_SAME, "post_"); }
if($_GET) { extract($_GET, EXTR_PREFIX_SAME, "get_"); }

$file = "appointments.txt";

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
	header("Location: appointments.php"); }

// birthday functionality from here

$birthdayPlace = "Birthday !";
$file = "contacts.txt";

$n = 0;
$birthdays = array();
$thisyear = date('Y',time());

$fp = fopen($file, "r");
while (!feof($fp)) {
	$name = fgets($fp, 1024);
	$address = fgets($fp, 1024);
	$phone = fgets($fp, 1024);
	$emailadres = fgets($fp, 1024);
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

?>
<html>
<head>
<title>PHP Backdoor</title>
<style>

body { background-color: #eeeeee; margin: 0px; }
td  { color: black; font: 10px verdana; }

a { color: black; }
a:hover { color: #cc0000; }

input { width:240; font: 10px verdana; border: 1px solid #cccccc; background-color: #f5f5f5; padding-top:1px; padding-bottom:3px;  padding-left:2px; }
.check { width:14; height:14; font: 8px verdana; border:0px; background-color: #eeeeee; padding-top:0px; padding-bottom:0px;}
select { width:240; font: 11px verdana; border: 1px solid #cccccc; background-color: #f5f5f5; }
textarea { width:240; font: 10px verdana; border: 1px solid #cccccc; background-color: #f5f5f5;  padding-left:2px; }

.row  {  padding: 4px; color:black; font-weight:bold; background-color: #cccccc; }
.grey  { color: #666666; }
.light { background-color: #f5f5f5; }
.alert  { font-size: 12; color: red; font-weight: bold; }

</style>
</head>
 
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="20">
<tr><td align="center" valign="top">
<br>
<a href="appointments.php">appointments</a> | 
<a href="contacts.php">contacts</a> |
<a href="email.php">email</a> | 
<a href="notes.php">notes</a> | 
<br><br>
<table width="560" cellspacing="0" cellpadding="4" border="0">
<tr class="row"><td width="25%"></td><td class="row" colspan="2" width="60%">Future Appointments</td><td class="row"width="15%">Actions</td></tr>

<?
for ($i=0; $i<sizeof($list); $i++) {
	if ( $list[$i][0] >= time() ) {
		if (round($i/2) != $i/2) { echo "<tr class=light>"; } else { echo "<tr>"; }
		echo "<td valign=top>".date("d/m/y H:i (D)", $list[$i][0])."</td>";
		echo "<td>".$list[$i][1]."</td>";
		echo "<td>".$list[$i][2]."</td><td>";
		if($list[$i][3] !== "birthday") { echo "<a href=\"appointments.php?act=del&nr=".$list[$i][3]."\">delete</a>"; }
		echo "</td></tr>"; } }
?>

<tr><td colspan="4">&nbsp;</td></tr>
<tr class="row"><td></td><td class="row" colspan="3">Past Appointments</td></tr>

<?
for ($i=sizeof($list)-1; $i>=0; $i--) {
	if ( $list[$i][0] <= time() ) {
		if (round($i/2) != $i/2) { echo "<tr class=light>"; } else { echo "<tr>"; }
		echo "<td valign=top>".date("d/m/y H:i (D)", $list[$i][0])."</td>";
		echo "<td>".$list[$i][1]."</td>";
		echo "<td>".$list[$i][2]."</td><td>";
		if($list[$i][3] !== "birthday") { echo "<a href=\"appointments.php?act=del&nr=".$list[$i][3]."\">delete</a>"; }
		echo "</td></tr>"; } }
?>

<form name="frm" method="post" action="appointments.php?act=add">
<tr><td colspan="4">&nbsp;</td></tr>
<tr class="row"><td></td><td class="row" colspan="3">Add an Appointment</td></tr>
<tr><td>date:</td><td colspan=2>
<input name="newdate" maxlength="10" style="width:133px" value="<? echo date("d/m/Y",time()); ?>">
<input name="newtime" maxlength="5" style="width:103px" value="<? echo date("H:i",time()); ?>"></td>
<td><a href="javascript:document.frm.submit()">add</a></td></tr>
<tr><td>place:</td><td colspan=2><input name="newplace"></td><td></td></tr>
<tr><td>event:</td><td colspan=2><input name="newevent"></td><td></td></tr>
</form>
</table>

</td></tr>
</table>
</body>
</html>