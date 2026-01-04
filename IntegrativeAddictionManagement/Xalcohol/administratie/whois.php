<?
// Whois Lookupform by Bart Roelofs, 3rd of April 2004 
// Based on: whoislookup 2.0 -  Atlaz (zend@atlaz.net), 13th January 2004 
function whoislookup($sDomain) 
{ 
    $aDom = explode(".", $sDomain); 
    if(substr($sDomain, 0, 4) == 'www.' && count($aDom) >= 3) 
    { 
        $sDomain = substr($sDomain,4); 
    } 
    $sExt = strtolower($aDom[count($aDom) - 1]); 
    $aNic = array('ar','im','as','am','au','bt','bg','cl','cc','cg','bi','rw','zr','cr','cz','dk','ec','fo','gl','fr','de','ir', 'it','jo','my','mx','ni','nl','nu','pk','pl','ru','sg','sk','es','tw','th','to','tm','uk','ua','co','ch','li'); 
    $aUS = array('com','net','org','info','biz'); 
    $aRipe = array('il','gr','gg','je'); 
    $aAPNic = array(); 
    $aAUNic = array(); 
    $aJPNic = array('jp'); 
    if($sExt != "") 
    { 
        $iErrorLevel = 0; 
        if(in_array($sExt, $aNic)) 
        { 
            $sServer = "whois.nic." . $sExt; 
        } 
        elseif(in_array($sExt, $aUS)) 
        { 
            $sServer = "whois.networksolutions.com"; 
        } 
        elseif(in_array($sExt, $aRipe)) 
        { 
            $sServer = "whois.ripe.net"; 
        } 
        elseif(in_array($sExt, $aAPNic)) 
        { 
            $sServer = "whois.apnic.net"; 
        } 
        elseif(in_array($sExt, $aAUNic)) 
        { 
            $sServer = "whois.ausregistry.net.au"; 
        } 
        elseif(in_array($sExt, $aJPNic)) 
        { 
            $sServer = "whois.nic.ad.jp"; 
            $sDomain = $sDomain . "/e"; 
        } 
        elseif($sExt == "se") 
        { 
            $sServer = "whois.nic-se.se"; 
        } 
        elseif($sExt == "lu") 
        { 
            $sServer = "whois.restena.lu"; 
        } 
        else 
        { 
            $iErrorLevel = 2; 
        } 
    } 
    else 
    { 
        $iErrorLevel = 1; 
    } 
     
    if (!empty($sDomain) && $iErrorLevel == 0) 
    { 
        $fp = fsockopen("$sServer", 43, &$errno, &$errstr, 30); 
        if(!$fp) 
        { 
            $output = "$errstr ($errno)<br>\n"; 
        } 
        else 
        { 
            fputs($fp,"$sDomain\n"); 
            while(!feof($fp)) 
            { 
                $sOutput = $sOutput . ereg_replace("\t", "&nbsp;", fgets($fp,128)) . "<BR>\n"; 
            } 
            fclose($fp); 
        } 
    } 
    elseif($iErrorLevel == 2) 
    { 
        $sOutput = "Error $sExt for domain $sDomain is not a recognised extension<br>\n"; 
    } 
    return $sOutput; 
}
?>
<?
if(!isset($_POST['whois'])){
	echo "
		<form name=\"whois\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">
		  <table width=\"500\" border=\"0\">
			<tr>
			  <td width=\"111\">Domeinnaam:</td>
			  <td width=\"379\"><input name=\"domain\" type=\"text\" id=\"domain\" size=\"50\"></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td><input name=\"whois\" type=\"submit\" id=\"whois\" value=\"Whois\"></td>
			</tr>
		  </table>
		</form>
		";
}else{
	$domain = $_POST['domain'];
	echo whoislookup($domain);
}
?>