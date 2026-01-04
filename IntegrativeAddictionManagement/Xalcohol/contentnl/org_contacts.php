<? 

function chopline($str) { return preg_replace("/\r?\n$|\r[^\n]$/", "", $str); }
function addjsslashes($str) { return addcslashes($str, "\0..\37!@\@\177..\377\'\""); }

if($_POST) { extract($_POST, EXTR_PREFIX_SAME, "post_"); }
if($_GET) { extract($_GET, EXTR_PREFIX_SAME, "get_"); } 

$file = "contacts.txt";

$n = 0;
$list = array();

$fp = fopen($file, "r");
while (!feof($fp)) {
	$name = fgets($fp, 1024);
	$address = fgets($fp, 1024);
	$phone = fgets($fp, 1024);
	$emailadres = fgets($fp, 1024);
	$birthday = fgets($fp, 1024);
	$cat = fgets($fp, 1024);
	if ($name && $cat) {
		$list[$n][0]= stripcslashes(chopline($name));
		$list[$n][1]= stripcslashes(chopline($address));
		$list[$n][2]= stripcslashes(chopline($phone));
		$list[$n][3]= stripcslashes(chopline($emailadres));
		$list[$n][4]= stripcslashes(chopline($birthday));
		$list[$n][5]= stripcslashes(chopline($cat));
		$n++; } }
fclose($fp);

if($act == "del") {
	array_splice($list, $nr, 1); }
	
if($act == "add") {
	$s = sizeof($list);
	$list[$s][0]= stripcslashes($newname);
	$list[$s][1]= stripcslashes($newaddress);
	$list[$s][2]= stripcslashes($newphone);
	$list[$s][3]= stripcslashes($newemail);
	$list[$s][4]= stripcslashes($newbirthday);
	if ($newcat == "") { $list[$s][5] = stripcslashes($selcat); } 
	else { $list[$s][5]= stripcslashes($newcat); } }
	
if($act == "edit") {
	$list[$nr][0] = stripcslashes($newname);
	$list[$nr][1] = stripcslashes($newaddress);
	$list[$nr][2] = stripcslashes($newphone);
	$list[$nr][3] = stripcslashes($newemail);
	$list[$nr][4]= stripcslashes($newbirthday);
	if ($newcat == "") { $list[$nr][5] = stripcslashes($selcat); } 
	else { $list[$nr][5]= stripcslashes($newcat); } }
	
$catlist = array();
$catlist[0] = $list[0][5];

for($i=0; $i<sizeof($list); $i++) {
	$found = true;
	for($j=0; $j<sizeof($catlist); $j++) {
		if ($list[$i][5] == $catlist[$j]) {
			$found = false; } }
	if( $found == true) { 
		$catlist[sizeof($catlist)] = $list[$i][5]; } }
		
array_multisort($list);
sort($catlist);

if($act) {
	$fp = fopen($file, "w");
	for ($i=0; $i<sizeof($list); $i++) {
  		fputs($fp, addjsslashes($list[$i][0])."\n");
  		fputs($fp, addjsslashes($list[$i][1])."\n");
  		fputs($fp, addjsslashes($list[$i][2])."\n");
  		fputs($fp, addjsslashes($list[$i][3])."\n");
  		fputs($fp, addjsslashes($list[$i][4])."\n");
  		fputs($fp, addjsslashes($list[$i][5])."\n"); 
	}
	fclose($fp);
	header("Location: contacts.php"); }

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
<script language="javascript">
function switchform(n) {
	switch (n) {
	<? for ($i = 0; $i < sizeof($list); $i++) { ?>
		case <? echo $i ?>:
			document.frm.nr.value = '<? echo $i ?>';
			document.frm.newname.value = '<? echo addjsslashes($list[$i][0]) ?>';
			document.frm.newaddress.value = '<? echo addjsslashes($list[$i][1]) ?>';
			document.frm.newphone.value = '<? echo addjsslashes($list[$i][2]) ?>';
			document.frm.newemail.value = '<? echo addjsslashes($list[$i][3]) ?>';
			document.frm.newbirthday.value = '<? echo addjsslashes($list[$i][4]) ?>';
			document.frm.newcat.value = '<? echo addjsslashes($list[$i][5]) ?>';
			break;
		<? } ?>
		}
		document.frm.newname.focus(); }
	
function add() {
	document.frm.action = "contacts.php?act=add";
	document.frm.submit(); }
    
function edit() {
	document.frm.action = "contacts.php?act=edit";
	if(document.frm.nr.value == "-1") {
		alert('Nothing to change ! \n Wanna add ?'); 
	} else {
		document.frm.submit(); } }
</script>

<table width="560" cellspacing="0" cellpadding="4" border="0">

<form name="emlfrm" method="post" action="email.php?act=compose">
<?
for ($j=0; $j<sizeof($catlist); $j++) {
	echo "<tr class=row><td width=\"20%\"></td><td class=row width=\"35%\">".$catlist[$j]." Contacts</td><td class=row width=15%>";
	if($j ==0) { echo "emailadres"; }
	echo "</td><td class=row width=\"30%\">";
	if($j ==0) { echo "Actions"; }
	echo "</td></tr>";
	$n=0;
	for ($i=0; $i<sizeof($list); $i++) {
		if($list[$i][5] == $catlist[$j]) {
			$n++;
			if (round($n/2) == $n/2) { echo "<tr class=light>"; } else { echo "<tr>"; }
			echo "<td></td>";
			echo "<td>".$list[$i][0]."</td><td>";
			if ($list[$i][3] != "") { echo "&nbsp;<input type=\"checkbox\" class=check name='num[]' value=\"".$list[$i][3]."\">"; }
			echo "</td><td><a href=javascript:switchform($i)>details</a> | ";
			echo "<a href=\"contacts.php?act=del&nr=".$i."\">delete</a>";
			if ($list[$i][3] != "") { echo " | <a href=email.php?act=compose&to=".$list[$i][3].">email</a>"; }
			echo "</td></tr>"; } } 
	echo "<tr><td colspan=4>&nbsp;</td></tr>"; }
?>
<tr class=light><td colspan=3>&nbsp;</td><td><a href=javascript:document.emlfrm.submit()>email all checked</a></td></tr>
<tr><td colspan=4>&nbsp;</td></tr>
</form>

<form name="frm" method="post">
<input type="hidden" name="nr" value="-1">
<tr class="row"><td></td><td class="row" colspan="3">Add a Contact</td></tr>
<tr><td>name:</td><td colspan=2><input type="text" name="newname"></td>
<td><a href="javascript:add()">add</a> | <a href="javascript:edit()">change</a> | <a href="javascript:document.frm.reset()">clear</a></td></tr>
<tr><td>address:<br>&nbsp;</td><td colspan="3"><textarea rows="2" name="newaddress"></textarea></td></tr>
<tr><td>phone:</td><td colspan="3"><input type="text" name="newphone"></td></tr>
<tr><td>email:</td><td colspan="3"><input type="text" name="newemail"></td></tr>
<tr><td>birthday:</td><td colspan="3"><input type="text" style="width:80" name="newbirthday"> &nbsp; dd/mm/yyyy</td></tr>
<tr><td>category:</td><td colspan="3"><select name="selcat">

<? 
for ($i=0; $i<sizeof($catlist); $i++) {
	echo"<option>".$catlist[$i]."</option>";
}
?>

</select></td></tr>
<tr><td></td><td colspan="3"><input type="text" name="newcat"></td></tr>
</form>
</table>
</td></tr>
</table>
</body>
</html>