<?php
include 'headr.php';
include 'dbconnect.php';

//open up database
mysql_select_db('OOGJE');

$cat = $_GET['cat'];


$result = mysql_query ("SELECT DISTINCT category FROM info_categories WHERE subcatof = '0'");
while($row = mysql_fetch_array($result, MYSQL_BOTH))
{
print ("<a href=\"listCat.php?cat=".$row["category"]."\"> ".$row["category"]."</a><br>\n");
}

//$result = mysql_query ("SELECT DISTINCT name, url FROM url WHERE category = '$cat'");
//while($row = mysql_fetch_array($result, MYSQL_BOTH))
//{
//print ($row["category"]." <a href=\"".$row["url"]."\"> ".$row["name"]."</a><br>\n");
//}

//close user connection
mysql_free_result($result);?>

</DIV>
</BODY>
</HTML>

