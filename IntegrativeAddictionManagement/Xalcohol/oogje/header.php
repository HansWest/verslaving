<?php include("hello.php"); ?>
<html>
<head>
<title>Oogje in't zeil</title>
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
<p>&nbsp;</p><tr><td align="center" valign="top">
<br>
<?php 
if ($_COOKIE[$cookienaam] == "1") {echo "<a href=\"r_afspraken.php\"><b>supervisor</b></a> &nbsp; &nbsp; | "; }
 ?><a href="todo.php">to do</a> | 
<a href="afspraken.php">afspraken</a> | 
<a href="contacten.php">contacten</a> |
<a href="notities.php">notities</a> | 
<div align="right"><?=$logout_text?></div>
<br><br>