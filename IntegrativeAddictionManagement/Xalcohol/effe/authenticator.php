<?php
  $the_right_user = 'user';  // example only! not recommended
  $the_right_password = 'password';  // example only!

  if(!isset($PHP_AUTH_USER)) {
    Header("WWW-Authenticate: Basic realm=\"effe\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "Canceled by user\n";
    exit;
  } else {
    if (($PHP_AUTH_USER == 'user') &&
        ($PHP_AUTH_PW == 'pass')) //see caution below
      print("The realm is yours<BR>");
    else
      print("We don't need your kind<BR>");
  }
?>