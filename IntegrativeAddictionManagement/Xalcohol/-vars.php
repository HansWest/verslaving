<?php include "gegevens_sma.php"; ?>
<html>
<head>
<title> ::: :: : <?php echo($prognaamkort);?> : :: :::</title>
<meta name="description" content="Welkom op de site .">
<meta name="keywords" content=", H@ns">
<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.5)">
<link href="assets/smd.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#333333" link="#662222" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
<p>Gebruikte Variabelen</p>
  <p>Programma Algemeen</p><?php
echo("$prognaamkort prognaamkort - <br>");
echo("$prognaamlang - <br>");
echo("$ - <br>");
echo("$ - <br>");
echo("$ - <br>");
?>
<p>Personalia</p><?php
echo("$voornaam - 20 lang<br>");
echo("$achternaam - 30 lang<br>");
echo("$gebjaar - (init value 'jjjj'<br>");
echo("$gebmaand - (init value 'mm'<br>");
echo("$gebdag - (init value 'dd'<br>");
echo("$paswoord - <br>");
echo("$ - <br>");
echo("$ - <br>");
?> 
<p>Programmasturing</p>
<p> 
   <?php
echo("$startdatum - startdtum ontwenning<br>");
echo("$strategie - <br>");
echo("$doelen - <br>");
echo("$afwezing15pos - <br>");
echo("$afweging15neg - <br>");
echo("$ - <br>");
?> 
<p>Pagina opmaak</p>
<p> 
   <?php
echo("$hiero1 - de plek waar je bent aangegeven aaan het begin van de pagina<br>");
echo("$hiero2 - de het kader van de plek waar je bent aangegeven aaan het begin van de pagina<br>");
echo("$doelen - <br>");
echo("$ - <br>");
echo("$ - <br>");
echo("$ - <br>");
?> 
</p>
<p>&nbsp; </p>
</body>
</html>