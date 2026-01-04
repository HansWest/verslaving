<title>Passing Value <?php echo $value; ?></title>
<body bgcolor="#FFFFFF" text="#000000">
<table width="100%" border="0" height="100%">
  <tr>
    <td align="center" valign="middle">
      <p><font face="Verdana, Arial, Helvetica, sans-serif" size="2">This is just 
        the middle page where you can do whatever...<br>
        The value you passed by the way was <b> 
        <?php echo $value; ?>
        </b></font></p>
      <p><font face="Verdana, Arial, Helvetica, sans-serif" size="2">You can now 
        click <a href="end.php?value=<?php echo $value; ?>">here</a> to end your variable back to<br>
        another HTML-based page with a Flash file in it.</font></p>
    </td>
  </tr>
</table>
