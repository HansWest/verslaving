Gebruik deze functie om het ip adres van een site bezoeker te achterhalen. 
 bv. 
 $ip = getIP(); 

 Natuurlijk is geen enkel script helemaal bulletproof (als iemand achter een anonieme proxy zit die helemaal geen headers mee stuurt bv.) maar deze functie komt een eind in de richting. 
 Tevens worden lokale (LAN) adressen er uit gefilterd. 

 Er wordt gecontroleerd op 
 HTTP_CLIENT_IP 
 HTTP_X_FORWARDED_FOR 
 HTTP_VIA 
 REMOTE_ADDR 

 Dit zijn de headers die tot nu toe her en der gevonden heb. 
 Als er meer zijn die door een proxy mee gestuurd kunnen worden, moet je maar even een comment achter laten.
 
 
 <?

/*---------------------------------------------------------------------- 

  Functie      : getIP

  Omschrijving : IP adress van clients ophalen

  Gebruik      : getIP()

  Argumenten   : In: void

               : Uit: String $ip (client ip adress of "0.0.0.0" als er geen ip wordt gevonden)

---------------------------------------------------------------------- */

function getIP()
{
	if(!empty($_SERVER['HTTP_CLIENT_IP']))
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$ips = explode (",", $_SERVER['HTTP_X_FORWARDED_FOR']);
		for ($i = 0; $i < count($ips); $i++) 
		{
			$ips[$i] = trim($ips[$i]);
        	if (!eregi("^(10|172\.16|192\.168)\.", $ips[$i]))
			{
            	    $ip = $ips[$i];
					break;
            }
        }
    }
	elseif (!empty($_SERVER['HTTP_VIA'])) 
	{
		$ips = explode (",", $_SERVER['HTTP_VIA']);
		for ($i = 0; $i < count($ips); $i++) 
		{
			$ips[$i] = trim($ips[$i]);
        	if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) 
			{
            	    $ip = $ips[$i];
					break;
            }
        }
    }
	elseif(!empty($_SERVER['REMOTE_ADDR']))
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	else
	{
		$ip = "0.0.0.0"; 
	}
	return $ip;
}
?>