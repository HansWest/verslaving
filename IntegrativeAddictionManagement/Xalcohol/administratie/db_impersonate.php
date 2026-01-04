<?php

/**************************************************
 * Script to set user cookie so admins can browse *
 * site from the viewpoint of a particular user.  *
 * Potentially VERY unsafe!!!  Protect it with    *
 * your life!                                     *
 **************************************************/

// If this person isn't recognized as the admin, bounce them
if ($_COOKIE['user_name'] != 'Admin') {
  header("Location: index.php");
}

require_once('../assets/dbconnect.php');
require_once('../assets/db_inc_login_funcs.php');

function user_impersonate() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals
  if (!$_POST['user_name'] || !$_POST['password']) {
    $feedback = 'ERROR - Missing username or password';
    return $feedback;
  } else {
    $user_name = strtolower($_POST['user_name']);
    // Don't need to trim because extra spaces should fail for this
    // Don't need to addslashes because single quotes aren't allowed
    $password = $_POST['password'];
    // Don't need to addslashes because we'll be hashing it
    $crypt_pwd = md5($password);
    $query = "SELECT user_name
              FROM personalia
              WHERE user_name = 'Administrator
              AND password='$crypt_pwd'";
    $result = mysql_query($query);
    if (!$result || mysql_num_rows($result) < 1)
	{
		  $feedback = 'ERROR - User not found or password incorrect';
		  return $feedback;
    }else{
		if (mysql_result($result, 0, 0) == 'Admin')
		{
			user_set_tokens($user_name);
    	    return 1;
		}
	}
  }
}

if ($submit == 'Login') {
  $feedback = user_impersonate();
  if ($feedback == 1) {
    // On successful login, redirect to homepage
    header("Location: index.php");
  } else {
    $feedback_str = "<P class=\"errormess\">$feedback</P>";
  }
} else {
  $feedback_str = '';
}


// ----------------
// DISPLAY THE FORM
// ----------------
include_once('db_header_footer.php');
site_header('Login To OpenCortex');

// Superglobals don't work with heredoc
$php_self = $_SERVER['PHP_SELF'];

$login_form = <<< EOLOGINFORM
<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 ALIGN=CENTER WIDTH=621>
<TR>
  <TD ROWSPAN=2><IMG WIDTH=15 HEIGHT=1 SRC=../images/spacer.gif></TD>
  <TD WIDTH=606 HEIGHT=1><IMG WIDTH=606 HEIGHT=1 SRC=../images/spacer.gif></TD>
</TR>
<TR>
 <TD>

$feedback_str
<P CLASS="bold">LOGIN</P>
<FORM ACTION="$php_self" METHOD="POST">
<P CLASS="bold">Username<BR>
<INPUT TYPE="TEXT" NAME="user_name" VALUE="" SIZE="10" MAXLENGTH="15"></P>
<P CLASS="bold">Password<BR>
<INPUT TYPE="password" NAME="password" VALUE="" SIZE="10" MAXLENGTH="15"></P>
<P><INPUT TYPE="SUBMIT" NAME="submit" VALUE="Login"></P>
</FORM>

 </TD>
</TR>
</TABLE>
EOLOGINFORM;
echo $login_form;

site_footer();

?>
