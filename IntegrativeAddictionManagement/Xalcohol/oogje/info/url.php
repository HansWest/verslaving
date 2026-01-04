<?php
include 'headr.php';
include 'dbconnect.php';

//open up database
mysql_select_db('OOGJE');


$result = mysql_query ("SELECT category, name, url FROM url");
while($row = mysql_fetch_array($result, MYSQL_BOTH))
{
print ($row["category"]." <a href=\"".$row["url"]."\" target=\"_blank\"> ".$row["name"]."</a><br>\n");
}

//close user connection
mysql_free_result($result);?>

</DIV>
</BODY>
</HTML>
