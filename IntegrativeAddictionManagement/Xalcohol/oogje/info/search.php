<?php
include 'searchheadr.php';
include 'dbconnect.php';

//open database
mysql_select_db('OOGJE');



print ("<form method='post' name='search_form' action='search.php?option=search'>");
print ("<input name='searchword' type='text' value='' size='40'>");
print ("<input type='submit' name='submit' value='Search'><br><br>");
//print ("<input type='radio' name='searchwhere' value='name' checked>Search Names<br>");
//print ("<input type='radio' name='searchwhere' value='url'>Search URLs <br><br>");

//print ("Sort Results By: <select size='1' name='orderby'><option>Most Popular</option>
//<option>Most Recent</option>
//<option>Alphabetical</option>
//<option>Category</option>
//</select>&nbsp;&nbsp;");



$search = $_POST['searchword'];
//$searchTable =$_POST['searchwhere'];

if (!empty($search)){
print ("Now searches through names, urls and categories<br><p>\n");	

//print ("Search: <b>".$search."</b> in <b>".$searchTable."s</b><br><p>\n");

//$result = mysql_query ("SELECT name, url FROM url WHERE name REGEXP '$search'");
//$result = mysql_query ("SELECT name, url FROM url WHERE $searchTable LIKE '%$search%'");
$result = mysql_query ("SELECT * FROM url WHERE (name LIKE '%$search%' OR url LIKE '%$search%' OR category LIKE '%$search%')");
$count = mysql_num_rows($result);
print ($count." results for <b>".$search."</b><br><p>\n");
print ("<DIV CLASS=\"main\">\n");

	while($row = mysql_fetch_array($result, MYSQL_BOTH))
	{
	print ($row["category"]." <a href=\"".$row["url"]."\" target=\"_blank\">".$row["name"]."</a><br>\n");
	}
}
//close user db connection
//mysql_free_result($result);
?>
</DIV>
</BODY>
</HTML>

