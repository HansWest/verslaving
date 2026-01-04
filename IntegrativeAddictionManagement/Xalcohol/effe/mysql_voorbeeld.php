<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Databse voorbeeld</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
<?php

 $conn = mysql_connect("localhost", "mysql_user", "mysql_password");

 if (!$conn) {
   echo "Unable to connect to DB: " . mysql_error();
   exit;
 }

 if (!mysql_select_db("mydbname")) {
   echo "Unable to select mydbname: " . mysql_error();
   exit;
 }

 $sql = "SELECT id as userid, fullname, userstatus
   FROM sometable
   WHERE userstatus = 1";

 $result = mysql_query($sql);

 if (!$result) {
   echo "Could not successfully run query ($sql) from DB: " . mysql_error();
   exit;
 }

 if (mysql_num_rows($result) == 0) {
   echo "No rows found, nothing to print so am exiting";
   exit;
 }

 // While a row of data exists, put that row in $row as an associative array
 // Note: If you're expecting just one row, no need to use a loop
 // Note: If you put extract($row); inside the following loop, you'll
 // then create $userid, $fullname, and $userstatus
 while ($row = mysql_fetch_assoc($result)) {
   echo $row["userid"];
   echo $row["fullname"];
   echo $row["userstatus"];
 }

 mysql_free_result($result);

 ?>
 Example 4. mysql_fetch_array() with MYSQL_BOTH
<?php
 mysql_connect("localhost", "mysql_user", "mysql_password") or
   die("Could not connect: " . mysql_error());
 mysql_select_db("mydb");

 $result = mysql_query("SELECT id, name FROM mytable");

 while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
   printf ("ID: %s Name: %s", $row[0], $row["name"]);
 }

 mysql_free_result($result);
 ?>

</body>
</html>
