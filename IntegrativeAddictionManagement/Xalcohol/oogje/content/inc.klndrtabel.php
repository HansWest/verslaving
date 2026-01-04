<?php 
$jjjjmmdd = $HTTP_GET_VARS[jjjjmmdd];
$go_to = $HTTP_GET_VARS[go_to];
 if (($timestamp = strtotime($go_to)) === -1) {
$datum = date(Y-m-d);
 }
$datum = date('Y-m-d', strtotime($go_to));
$datum = strtotime($datum);
//$jaar= date('Y', $datum);
//$maand= date('m', $datum);
///$dag= date('d', $datum);

 echo "<table width=\"200\">\n"; 
 echo "<tr><td class=\"kalendrtd\">"; 

 /* Start weergave berekeningsdeel */ 
 $zoekmaand = date("n", $datum); 
 switch (date("n", $datum)) {
			case 12:
$naamzoekmnd = "december";
			    break;
case 11:
$naamzoekmnd = "november";
			    break;
case 10:
$naamzoekmnd = "oktober";
			    break;
case 9:
$naamzoekmnd = "september";
			    break;
case 8:
$naamzoekmnd = "augustus";
			    break;
case 7:
$naamzoekmnd = "juli";
			    break;
case 6:
$naamzoekmnd = "juni";
			    break;
case 5:
$naamzoekmnd = "mei";
			    break;
case 4:
$naamzoekmnd = "april";
			    break;
case 3:
$naamzoekmnd = "maart";
			    break;
case 2:
$naamzoekmnd = "februari";
			    break;
case 1:
$naamzoekmnd = "januari";
		}		
$zoekjaar = date("Y"); 

 /* Navigatie deel */ 
 $last_month = $zoekmaand - 1; 
 $next_month = $zoekmaand + 1; 
 /* Navigatie deel beveiligen tegen mogelijke fouten*/ 
 if ($last_month == 12) { 
 $last_year = $zoekjaar - 1; 
 } else { 
 $last_year = $zoekjaar; 
 } 
 if ($next_month == 1) { 
 $next_year = $zoekjaar + 1; 
 } else { 
 $next_year = $zoekjaar; 
 } 

 /* Hoofdtitel aanmaken */ 
 echo "<table width=\"100%\">\n"; 
 echo "<tr><td class=\"kalendrtd\" colspan=\"2\">"; 
 echo "<center><a href=".$_SERVER['PHP_SELF']."?jjjjmmdd=$jjjjmmdd&go_to=". date('Y-m-d')." class=\"menubutton\"> $naamzoekmnd $zoekjaar </a></center>"; 
 echo "</td></tr>\n"; 
 echo "<td align=\"left\"><a href=".$_SERVER['PHP_SELF']."?jjjjmmdd=$jjjjmmdd&go_to=". date('Y-m-d', mktime (0, 0, 0, $last_month, 1, $last_year))." class=\"menubutton\">&lt;&lt;&lt;&lt;&lt;</a></td>"; 
 echo "<td align=\"right\"><a href=".$_SERVER['PHP_SELF']."?jjjjmmdd=$jjjjmmdd&go_to=". date('Y-m-d', mktime (0, 0, 0, $next_month, 1, $next_year))." class=\"menubutton\">&gt;&gt;&gt;&gt;&gt;</a></td>";
echo "</table>\n"; 

 /* Titels aanmaken voor de kalender */ 
 echo "<table width=\"100%\" border=\"0\">\n"; 
 echo "<tr><td class=\"weekdgn\"> </td>\n"; 
 echo "<td class=\"weekdgn\">Zo</td>\n"; 
 echo "<td class=\"weekdgn\">Ma</td>\n"; 
 echo "<td class=\"weekdgn\">Di</td>\n"; 
 echo "<td class=\"weekdgn\">Wo</td>\n"; 
 echo "<td class=\"weekdgn\">Do</td>\n"; 
 echo "<td class=\"weekdgn\">Vr</td>\n"; 
 echo "<td class=\"weekdgn\">Za</td>\n"; 
 echo "</td></tr>\n"; 

 /* Voorberekenen voor het tekenen */ 
 $eerstedag = date("w", mktime(0, 0, 0, $zoekmaand, 1, $zoekjaar)); 
 $totaantaldgn = date("t", mktime(0, 0, 0, $zoekmaand, 1, $zoekjaar)); 
 $week_num = 1; 
 $day_num = 1; 
 $zoekdag = " "; 

 /* Doorloop het aantal weergeven weken (primaire teller in het proces) */ 
 while ($week_num <= 6) { 
 echo "<tr>\n"; 

 if (($zoekdag-1)>0) { 
 if ($zoekdag>$totaantaldgn) { 
 echo "<td class=\"weekdgn\"> </td>"; 
 } else { 
 echo "<td class=\"weekdgn\">".date("W",mktime(0,0,0,$zoekmaand,$zoekdag+2,$zoekjaar))."</td>"; 
 } 
 } else { 
if ($i <=1) { echo "<td class=\"weekdgn\">".date("W",mktime(0,0,0,$zoekmaand,1,$zoekjaar))."</td>";}
else { echo "<td > </td>"; }
 } 

 /* Loop door de weekdagen */ 
 for ( $i = 0; $i <= 6; $i++ ) { 
 if ($week_num == 1) { 
 if ($i < $eerstedag) 
 $zoekdag = " "; 
 else if ($i == $eerstedag) { 
 $zoekdag = 1; 
 } 
 } else { 
 if ($zoekdag > $totaantaldgn) 
 $zoekdag = " "; 
 } 
 /* Weekdag weergeven */ 
 if ($zoekdag == " "){
  echo "<td> </td>\n"; 
} else { 
 if (date("d-m-Y",mktime(0,0,0,$zoekmaand,$zoekdag,$zoekjaar))==date("d-m-Y")) { 
 /* Datum van vandaag */ 
 echo "<td class=\"klndr_nowtd\"><a href=".$_SERVER['PHP_SELF']."?jjjjmmdd=". date('Y-m-d', mktime (0, 0, 0, $zoekmaand,$zoekdag,$zoekjaar))."&go_to=$go_to class=\"kallnk\"><b>$zoekdag</b></a></td>\n"; 
 } else { 
 echo "<td class=\"klndr_normtd\"><a href=".$_SERVER['PHP_SELF']."?jjjjmmdd=". date('Y-m-d', mktime (0, 0, 0, $zoekmaand,$zoekdag,$zoekjaar))."&go_to=$go_to class=\"kallnk\">$zoekdag</a></td>\n"; 
 } 
 }
 /* Tellen naar de volgende weekdag */ 
 if ($zoekdag != " ") 
 $zoekdag++; 
 } 

 /* Volgende week doorlopen */ 
 echo "</tr>\n"; 

 $week_num++; 
 } 

 /* Afronden van alle tags */ 
 echo "</table>\n"; 
 echo "</td></tr>\n"; 
 echo "</table>\n"; 
 ?> 
