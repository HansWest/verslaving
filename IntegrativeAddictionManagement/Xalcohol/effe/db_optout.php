<!-- Listing 17-6: checkbox displaying boolean data from database (optout.php) -->
<?php
// Open connection to the database
   mysql_connect("localhost", "phpuser", "sesame") or die("Failure to communicate with database");
 mysql_select_db("test");

// If the form has been submitted, record the preference and redisplay
if (isset($_POST['optout'] && $_POST['submit'] == 'submit') {
  $emailadres = $_POST['emailadres'];
  $as_email = addslashes($_POST['emailadres']);
if (isset($_POST['optout']) && $_POST['submit'] == 1) {
    $optout = 1;
  } else {
    $optout = 0;
  }

  // Update value
  $query = "UPDATE checkbox
            SET BoxValue = $optout
            WHERE BoxName = 'OptOut'
            AND emailadres = '$as_email'";
  $result = mysql_query($query);
  if (mysql_error() == "") {
    $success_msg = '<P>Your preference has been updated.</P>';
  } else {
    error_log(mysql_error());
    $success_msg = '<P>Something went wrong.</P>';
  }
  // Get the value
  $query = "SELECT BoxValue FROM checkbox WHERE BoxName = 'OptOut' AND emailadres = '$as_email'";
  $result = mysql_query($query);
  $optout = mysql_result($result, 0, 0);

  if ($optout == 0) {

    $checked = "";
  } elseif ($optout == 1) {
    $checked = 'checked';
  }
}


// Now display the page
$thispage = $_SERVER['PHP_SELF']; //Have to do this for heredoc

$form_page = <<< EOFORMPAGE
<HTML>
<HEAD>
<TITLE>Semi-sleazy opt-in form</TITLE>
</HEAD>

<BODY>
$success_msg
<FORM METHOD=POST ACTION="$thispage">
Een vriend of vriendin heeft mij opgegeven als steun-figuur bij zijn/haar ontwenning<BR>
Maar ik maak graag gebruik van de 'opt out'-functie (zodat ik geen emails meer via deze site ontvang) door deze checkbox aan te vinken en mijn email-adres in te vullen</FONT>
<P>
email-adres:  <INPUT TYPE="text" NAME="emailadres" SIZE=25 VALUE="$emailadres"> voor opt-out functie<BR><BR>
<INPUT TYPE="checkbox"  NAME="optout" VALUE=1 $checked><BR><BR>
<INPUT TYPE="submit" NAME="submit" VALUE="submit">
</FORM>

</BODY>
</HTML>
EOFORMPAGE;
echo $form_page;

?>

