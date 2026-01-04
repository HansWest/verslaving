<?php
include 'headr.php';
include 'dbconnect.php';

//open up database
mysql_select_db('OOGJE');

$cat = $_GET['cat'];


$catnum = mysql_query ("SELECT catnum FROM info_categories WHERE category = '$cat'");
$catno = mysql_fetch_row($catnum);

print ("<h4>Gekozen categorie: $cat / Catno: ".$catno[0]."</h4><P>\n");
///print ("Categorie: $cat / Catno: ".$catno[0]."<br>\n");
/// is hetzelfde als: print ("Categorie: ".$cat." / Catno: ".$catno[0]."<P>\n");

$catselect = mysql_query ("SELECT DISTINCT catnum,category FROM info_categories WHERE subcatof = '$catno[0]'");
$count = mysql_num_rows($catselect);
if ($count != 0) {
	print ("<b>".$cat."</b> has ".$count." Subcategories:<br>\n");
							
	while($row = mysql_fetch_array($catselect, MYSQL_BOTH))
	{
		//print ("browse <a href=\"browseCat.php?cat=".$row["catnum"]."\"> ".$row["category"]."</a> - ");
		print ("<a href=\"listCat.php?cat=".$row["category"]."\"> ".$row["category"]."</a><br>\n");
	}
}

print ("<DIV CLASS=\"str\"><p><br>URL's: <br></DIV>\n");
// print ("SELECT * FROM url WHERE category = ".$catno[0]);
$result = mysql_query ("SELECT * FROM url WHERE category =".$catno[0]);
while($row = mysql_fetch_array($result, MYSQL_BOTH))
{
	print ("<a href=\"".$row["url"]."\" target=\"_blank\"> ".$row["name"]."</a><br>\n");
}

//close user connection
mysql_free_result($catselect);
mysql_free_result($result);
?>

</DIV>
</BODY>
</HTML>

