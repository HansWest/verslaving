<? 

function chopline($str) { return preg_replace("/\r?\n$|\r[^\n]$/", "", $str); }
function addjsslashes($str) { return addcslashes($str, "\0..\37!@\@\177..\377\'\""); }

if($_POST) { extract($_POST, EXTR_PREFIX_SAME, "post_"); }
if($_GET) { extract($_GET, EXTR_PREFIX_SAME, "get_"); }


if($act == "del")
{
///
}
	
if($act == "add")
{
///
}

if($act) {
	$fp = fopen($file, "w");
	for ($i=0; $i<sizeof($list); $i++) {
  		fputs($fp, $list[$i][0]."\n");
  		fputs($fp, addjsslashes($list[$i][1])."\n");
  		fputs($fp, addjsslashes($list[$i][2])."\n");
	}
	fclose($fp);
	header("Location: afspraken.php"); }

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


?>

<script language="javascript">
  function switchform(n) {
	switch (n) {
	<? for ($i = 0; $i < sizeof($list); $i++) { ?>
		case <? echo $i ?>:
			document.frm.nr.value = '<? echo $i ?>';
			document.frm.newdate.value = '<? echo addjsslashes("31/12/2005") ?>';
			document.frm.newtime.value = '<? echo addjsslashes("00:00") ?>';
			document.frm.newevent.value = '<? echo addjsslashes($list[$i][2]) ?>';
			document.frm.newplace.value = '<? echo addjsslashes($list[$i][1]) ?>';
			break;
		<? } ?>
		}
		document.frm.newname.focus(); }
	
    function add()
    {
        document.frm.action = "afspraken.php?act=add";
		document.frm.submit();
    }
    
    function edit()
    {
        document.frm.action = "afspraken.php?act=edit";
        if(document.frm.nr.value == "-1") {
			alert('Nothing to change ! \n Wanna add ?'); 
		} else {
        	document.frm.submit();
		}
    }
</script>


<p>&nbsp;</p><table width="560" cellspacing="0" cellpadding="4" border="0">
<tr class="row"><td width="25%"></td>
    <td class="row" colspan="2" width="60%">toekomst</td>
    <td class="row"width="15%"></td>
  </tr>

<?
for ($i=0; $i<sizeof($list); $i++) {
	if ( $list[$i][0] >= time() ) {
		if (round($i/2) != $i/2) { echo "<tr class=light>"; } else { echo "<tr>"; }
		echo "<td valign=top>".date("d/m/y H:i (D)", $list[$i][0])."</td>";
		echo "<td>".$list[$i][1]."</td>";
		echo "<td>".$list[$i][2]."</td><td>";
echo "<a href=javascript:switchform($i)>details</a>";
//		if($list[$i][3] !== "birthday") { echo "<a href=\"afspraken.php?act=del&nr=".$list[$i][3]."\">delete</a>"; }
if ($_COOKIE[$cookienaam] == "1") {if($list[$i][3] !== "birthday") { echo " | <a href=\"afspraken.php?act=del&nr=".$list[$i][3]."\">delete</a>"; }}
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
if ($_COOKIE[$cookienaam] == "1") {if($list[$i][3] !== "birthday") { echo " | <a href=\"afspraken.php?act=del&nr=".$list[$i][3]."\">delete</a>"; }}
		echo "</td></tr>"; } }
?>

<form name="frm" method="post" action="afspraken.php?act=add">
<tr><td colspan="4">&nbsp;</td></tr>
<tr class="row"><td></td>
      <td class="row" colspan="3">afspraak toevoegen</td>
    </tr>
<input type="hidden" name="nr" value="-1">
<tr><td>datum:</td><td colspan=2>
<input name="newdate" maxlength="10" style="width:133px" value="<? echo date("d/m/Y",time()); ?>">
<input name="newtime" maxlength="5" style="width:103px" value="<? echo date("H:i",time()); ?>"></td>
      <td><a href="javascript:document.frm.submit()">voeg toe</a></td>
    </tr>
<tr><td>wat:</td><td colspan=2><input name="newevent"></td><td></td></tr>
<tr><td>waar:</td><td colspan=2><input name="newplace"></td><td></td></tr>
</form>
</table>

<? include("footer.php"); ?>