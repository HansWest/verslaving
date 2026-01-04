<?php

require_once('db_inc_register_funcs.php');

function user_change_password () {
  // Do new passwords match?
  if ($_POST['new_password1'] && ($_POST['new_password1'] == $_POST['new_password2'])) {
    // Is password long enough?
    if (strlen($_POST['new_password1']) >= 6) {
      // Is the old password correct?
      if (strlen($_POST['old_password']) > 1) {
        $change_user_name = strtolower($_COOKIE['user_name']);
        $old_password = $_POST['old_password'];
	$crypt_pass = md5($old_password);
        $new_password1 = $_POST['new_password1'];
        $query = "SELECT * 
                  FROM personalia
                  WHERE user_name = '$change_user_name'
                  AND paswoord = '$crypt_pass'";
        $result = mysql_query($query);
        if (!$result || mysql_num_rows($result) < 1) {
          $feedback = 'ERROR - User not found or bad password';
          return $feedback;
        } else {
	         $crypt_newpass = md5($new_password1);
          $query = "UPDATE personalia
                    SET paswoord = '$crypt_newpass'
                    WHERE user_name = '$change_user_name'
                    AND paswoord = '$crypt_pass'";
          $result = mysql_query($query);
          if (!$result || mysql_affected_rows() < 1) {
            $feedback = 'ERROR - Er is een probleem met de update van het paswoord';
            return $feedback;
          } else {
            return 1;
          }
        }
      } else {
        $feedback = 'ERROR - Graag het oude paswoord ingeven';
        return $feedback;
      }
    } else {
      $feedback .= 'ERROR - Het nieuwe paswoord is niet lang genoeg';
      return false;
    }
  } else {
    $feedback = 'ERROR - De opgegeven paswoorden (twee dezelfde om typefouten te voorkomen) zijn niet gelijk';
    return $feedback;
  }
}


function user_change_email() {
  global $supersecret_hash_padding;
  if (validate_email($_POST['new_email'])) {
    $hash = md5($_POST['new_email'].$supersecret_hash_padding);

    // Send out a new confirm email with a new hash
    $user_name = strtolower($_COOKIE['user_name']);
    $password1 = $_POST['password1'];
    $crypt_pass = md5($password1);
    $emailadres = $_POST['new_email'];
    $query = "UPDATE personalia
              SET confirm_hash = '$hash',
                  is_confirmed = 0,
                  emailadres = '$emailadres'
              WHERE user_name = '$user_name'
              AND paswoord = '$crypt_pass'";
    $result = mysql_query($query);
    if (!$result || mysql_affected_rows() < 1) {
      $feedback = 'ERROR - Het verkeerde paswoord';
      return $feedback;
    } else {
      // Send the confirmation emailadres
      $encoded_email = urlencode($_POST['new_email']);
      $mail_body = <<< EOMAILBODY
Bedankt voor het registreren op HelpDisk.nl/alcohol.  Klik op de onderstaande link om jouw inschrijving te valideren:

http://www.helpdisk.nl/alcohol/contact/confirm.php?hash=$hash&emailadres=$encoded_email

Vriendelijk groetend,
H.R.J. West			 
EOMAILBODY;
      mail($emailadres, 'SMA registratie acceptatie', $mail_body, 'From: info@helpdisk.nl');
      // If you use email rather than password cookies,
      // uncomment the following line
      user_set_tokens($user_name);
      return 1;
    }
  } else {
    $feedback = 'ERROR - Dit nieuwe emailadres is geen valide email adres';
    return $feedback;
  }
}

?>