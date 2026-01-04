
<?php
include 'headr.php';
include 'dbconnect.php';

//open up database
mysql_select_db('OOGJE');

$cat = $_GET['cat'];

print ('<P><table border=0><tr><td>Subcategorie van Hoofdcategorie:<td>');
print ('<form name="form1" method="post" action="catinvoer.php">');
print ('<select name="subcategorie">');
$result = mysql_query ("SELECT DISTINCT category,catnum FROM info_categories");
while($row = mysql_fetch_array($result, MYSQL_BOTH))
{
print ('<option value="'.$row["catnum"].'">'.$row["category"].'-'.$row["catnum"].'</option>\n');
}
print ('<option value="0">Nieuwe hoofdcategorie</option>\n');
print ('</select>');

print ('<tr><td>Naam van de categorie:<td><input type="text" name="catfield" >');
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

$categorie = $_POST['subcategorie'];
$urlfield = $_POST['catfield'];
//$naamfield = $_POST['naamfield'];
//$subcategorie = $_POST['subcategorie'];

if ($urlfield != "") {
print ($categorie.$urlfield.$naamfield.$subcategorie);

$sql = "INSERT INTO info_categories (cat, catnum, subcatof, category) VALUES ('', '', '$categorie', '$urlfield')";

//$sql = 'INSERT INTO info_categories (cat, catnum, subcatof, category) VALUES (''0'', '''', ''9'', ''test'')';
//						if ( !$db->sql_query($sql) )
//						{
//							message_die(GENERAL_ERROR, 'Could not insert shadow topic', '', __LINE__, __FILE__, $sql);
//						}
$result = mysql_query ($sql);

//mysql_free_result($sql);

//mysql_free_result($result);
print('<P>'.$sql);
print('<P>'.$result.'<br>---<P>');

mysql_free_result($result); ///?


$sql = 'SELECT * FROM info_categories ORDER BY category ASC LIMIT 0, 30';
$result = mysql_query ($sql);
mysql_free_result($sql);
}

?>


</form>
</BODY>
</HTML>

