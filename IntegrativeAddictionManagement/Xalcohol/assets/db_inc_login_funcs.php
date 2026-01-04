<?php

// A file with the database host, user, password, and selected database
include_once('dbconnect.php');

// A string used for md5 encryption.  You could move it to a file 
// outside the web tree for more security.
$supersecret_hash_padding = 'A stringetje that is used to pad out short strings for md5 encryption.';


$LOGGED_IN = false;
unset($LOGGED_IN);


function user_isloggedin()
{
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals
  global $supersecret_hash_padding, $LOGGED_IN;
  // Have we already run the hash checks? 
  // If so, return the pre-set var
  if (isSet($LOGGED_IN)) {
    return $LOGGED_IN;
  }
  if ($_COOKIE['user_name'] && $_COOKIE['id_hash']) {
    $hash = md5($_COOKIE['user_name'].$supersecret_hash_padding);
    if ($hash == $_COOKIE['id_hash']) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}


function user_login() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals
  if (!$_POST['user_name'] || !$_POST['password']) {
    $feedback = 'ERROR - Missing username or password';
    return $feedback;
  } else {
    $user_name = strtolower($_POST['user_name']);
    $password = $_POST['password'];
    // Don't need to trim because extra spaces should fail for this
    // Don't need to addslashes because single quotes aren't allowed
    // Don't need to addslashes because we'll be hashing it
    $crypt_pwd = md5($password);
    $query = "SELECT user_name, is_confirmed
              FROM personalia
              WHERE user_name = '$user_name'
              AND paswoord = '$crypt_pwd'";
    $result = mysql_query($query);
    if (!$result || mysql_num_rows($result) < 1){
      $feedback =  '<img src="../pics/macmandwn.gif" width="23" height="28" /> <font color="#800040"> <b>ERROR - Deze accountaaam is niet gevonden of het door jou gegeven paswoord klopte niet...</b></font>';
      return $feedback;
    } else {
      if (mysql_result($result, 0, 'is_confirmed') == '1') {
	       user_set_tokens($user_name);
	       return 1;
      } else {
	       $feedback = '<img src="../pics/macmandwn.gif" width="23" height="28" /> <font color="#800040"> <b>ERROR - Jouw account is nog niet bevestigd door de email die verstuurd is aan het adres dat jij hebt opgegeven.</font>';
	       return $feedback;
      }
    }
  }
}


function user_logout() {
  setcookie('user_name', '', (time()+2592000), '/', '', 0);
  setcookie('id_hash', '', (time()+2592000), '/', '', 0);
}


function user_set_tokens($user_name_in) {
  global $supersecret_hash_padding;
  if (!$user_name_in) {
    $feedback =  'ERROR - No username';
    return false;
  }
  $user_name = strtolower($user_name_in);
  $id_hash = md5($user_name.$supersecret_hash_padding);

  setcookie('user_name', $user_name, (time()+2592000), '/', '', 0);
  setcookie('id_hash', $id_hash, (time()+2592000), '/', '', 0);
}

?>
