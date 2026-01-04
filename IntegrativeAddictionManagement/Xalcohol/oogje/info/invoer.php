
<?php
include 'headr.php';
include 'dbconnect.php';

//open up database
mysql_select_db('OOGJE');

$cat = $_GET['cat'];

print ('<P><table border=0><tr><td>Categorie:<td>');
print ('<form name="form1" method="post" action="invoer.php">');
print ('<select name="categorie">');
$result = mysql_query ("SELECT DISTINCT category,catnum FROM info_categories");
print ('<option value="">kiezen!!!</option>\n');
while($row = mysql_fetch_array($result, MYSQL_BOTH))
{
print ('<option value="'.$row["catnum"].'">'.$row["category"].'-'.$row["catnum"].'</option>\n');
}
print ('</select>');

print ('<tr><td>URL:<td><input type="text" name="urlfield" value="http://www.">');
print ('<tr><td>Naam in DBase:<td><input type="text" name="naamfield">');
//print ('<tr><td>Subategorie:<td>');
//print ('<select name="subcategorie">');
//print ('<option value="0">n.v.t.</option>\n');
//$result = mysql_query ("SELECT DISTINCT category,catnum FROM info_categories");
//while($row = mysql_fetch_array($result, MYSQL_BOTH))
//{
//print ('<option value="'.$row["catnum"].'">'.$row["category"].'</option>\n');
//}
//print ('</select>');
print ('<tr><td>&nbsp;<td>');
print ('<input type="submit" name="Submit" value="Submit"> &nbsp; &nbsp; <INPUT TYPE="reset" VALUE="Reset"></table>');

//$result = mysql_query ("SELECT DISTINCT name, url FROM url WHERE category = '$cat'");
//while($row = mysql_fetch_array($result, MYSQL_BOTH))
//{
//print ($row["category"]." <a href=\"".$row["url"]."\"> ".$row["name"]."</a><br>\n");
//}

//close user connection
mysql_free_result($result);

$categorie = $_POST['categorie'];
$urlfield = $_POST['urlfield'];
$naamfield = $_POST['naamfield'];
$subcategorie = $_POST['subcategorie'];

if ($categorie != "") {
print ($categorie.$urlfield.$naamfield.$subcategorie);

$sql = "INSERT INTO url (id, name, url, category) VALUES ('', '$naamfield', '$urlfield', '$categorie')";

$sqlb = 'INSERT INTO `url` (`id`, `name`, `url`, `category`) VALUES ("", "'.$naamfield.'", "'.$urlfield.'", "'.$categorie.'")';

//						if ( !$db->sql_query($sql) )
//						{
//							message_die(GENERAL_ERROR, 'Could not insert shadow topic', '', __LINE__, __FILE__, $sql);
//						}
$result = mysql_query ($sql);

//mysql_free_result($sql); ///beide zijn blijkbaar not a valid MySQL result resource
//mysql_free_result($result); ///beide zijn blijkbaar not a valid MySQL result resource
print('<P>'.$sql);
print('<P>'.$sqlb);
print('<P>'.$result.'<br>---<P>');

$sql = 'SELECT * FROM url ORDER BY name DESC LIMIT 0, 30';
$result = mysql_query ($sql);

//mysql_free_result($sql);
//mysql_free_result($result);
}

?>


</form> 
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><a href="catinvoer.php">nieuwe (sub)categorie</a> </DIV> </p>
</BODY>
</HTML>

