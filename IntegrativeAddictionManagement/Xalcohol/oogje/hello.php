<?php 
/* Config Section */ 
//unset($supervisor);
$pass = 'marcel'; // Set the password. 
$pass2 = 'fack'; // Set the password. 
$cookiename = 'fuzzybrush'; // Optional change: Give the cookie a name.  
$cookienaam = 'supervisor'; // Optional change: Give the cookie a name.  
//if (!isset($_COOKIE[$cookiename2])) {
//$supervisor = 'x'
//;}
$expirytime = time()+4900; // Optional change: Set an expiry time for the password (in seconds)
$msg = 'Dit is niet het paswoord dat ik je gegeven heb, hoor...'; // Optional change: Error message displayed when password is incorrect.
/* End Config */ 

/* Logout */ 
if (isset($_REQUEST['logout'])) { 
 setcookie($cookiename,'',time() - 4900); // remove cookie/password 
 setcookie($cookienaam,'',time() - 4900); // remove cookie/password 
 if (substr($_SERVER['REQUEST_URI'],-12)=='?logout=true') { // if there is '?logout=true' in the URL 
 $url=str_replace('?logout=true','',$_SERVER['REQUEST_URI']); // remove the string '?logout=true' from the URL 
 header('Location: '.$url); // redirect the browser to original URL 
 } 
 show_login_page(''); 
 exit(); 
} 

$logout_button='<form action="'.$_SERVER['REQUEST_URI'].'" method="post"><input type="submit" name="logout" value="Logout" /></form>'; 
$logout_text='<a href="'.$_SERVER['REQUEST_URI'].'?logout=true">Logout</a>';
/* End Logout Stuff */ 

/* FUNCTIONS */ 
function setmycookie() { 
global $cookienaam,$supervisor,$cookiename,$pass,$expirytime; 
 setcookie($cookiename,$pass,$expirytime); 
 setcookie($cookienaam,$supervisor,$expirytime); 
} 

function show_login_page($msg) { 
?> 
 
<html> 
<!--html xmlns="http://www.w3.org/1999/xhtml"--> 
<head> 
<title>Aanmelden is vereist</title> 
<style type="text/css"> 
<!-- 
.error {color:#FF6FCF} 
#main {text-align:center;padding:15px} 
#header {font:bold 130% Verdana, Arial, sans-serif;color:#FFFFFF;width:100%;height:2.5em;text-align:center;background:#444444;line-height:3em} 
#mid {font:bold 100% Verdana, Arial, sans-serif;margin:3em 0 3em 0} 
#footer {font:Verdana, Arial, sans-serif;font-size:50%;text-align:center;width:100%} 
--> 
</style> 

 <script language="JavaScript" type="text/javascript"> 
 <!-- 
 function focus() { 
 document.pass.password.select(); 
 document.pass.password.focus(); 
 } 
 //--> 
 </script> 
 </HEAD> 
 <BODY onLoad="focus()" bgcolor="#eeeeee" text="#333333"> 
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
<div id="header">Sorry, maar dit deel is even niet openbaar...</div> 
<div id="main"> 
 <div id="mid"> 
 <form action="" name="pass" method="POST">
      jouw paswoord is:&nbsp; 
      <input type="password" name="password" size="20">&nbsp; 
 <input type="submit" value="Login"> 
 <input type="hidden" name="sub" value="sub"> 
 </form> 
 <div class=error><?=$msg?></div> 
 </div> 
 </div> 
</div> 
</body> 
</html> 
<? } 

/* END FUNCTIONS */ 
$errormsg=''; 
if (isset($_POST['sub'])) { // if form has been submitted 
 if ($_POST['password']<>$pass) { // if password is incorrect 
 if ($_POST['password']==$pass2) { // if password is 2
 $supervisor="1";
  setmycookie(); 
} else {
 $errormsg=$msg; 
 show_login_page($errormsg); 
 exit(); 
 }
 } else { // if password is correct 
 setmycookie(); 
} 
} else { 
 if (isset($_COOKIE[$cookiename])) { // if cookie isset 
 if ($_COOKIE[$cookiename]==$pass) { // if cookie is correct 
 // do nothing 
 } else { // if cookie is incorrect 
 show_login_page($errormsg); 
 exit(); 
 } 
 } else { // if cookie is not set 
 show_login_page($errormsg); 
 exit(); 
 } 
} 
?>