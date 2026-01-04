<?php

   $argument = $_GET["filename"];


   // Remove ASCIIZ

   $argument = str_replace("\0", "", $argument);


   // Remove "directory up"

   $argument = "./" . str_replace("", "../", $argument);


   // Escape the argument

   $argument = escapeshellarg($argument);


   // and execute the command

   system("find -name ".$argument.".php");

?>
