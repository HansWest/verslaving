<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
Notes:</span>

<br />
The value of $phpbb_root_path may change (if required), as may PAGE_INDEX (if wanted).  $phpbb_root_path should be a relative directory path to your phpBB page.  For example, if you have the following web site directory layout: 

<br />
</span><table width="90%" cellspacing="1" cellpadding="3" border="0" align="center"><tr> 	  <td><span class="genmed"><b>Quote:</b></span></td>	</tr>	<tr>	  <td class="quote">

<br />
/public_html/

<br />
../integrated

<br />
...../index.php

<br />
...../news.php

<br />
...../downloads.php

<br />
../phpBB2/

<br />
...../index.php

<br />
...../faq.php

<br />
...../memberlist.php</td>	</tr></table><span class="postbody">

<br />
$phpbb_root_path for the /integrated/ directory would be </span><table width="90%" cellspacing="1" cellpadding="3" border="0" align="center"><tr> 	  <td><span class="genmed"><b>Code:</b></span></td>	</tr>	<tr>	  <td class="code">$phpbb_root_path = '../phpBB2/';</td>	</tr></table><span class="postbody">

<br />
<span style="font-weight: bold">PAGE_INDEX</span> is used in <a href="http://www.phpbb.com/phpBB/viewonline.php" target="_blank" class="postlink">the View Online Page</a> to show the user's location on the forum.  It can be any of the values defined in /includes/constants.php under </span><table width="90%" cellspacing="1" cellpadding="3" border="0" align="center"><tr> 	  <td><span class="genmed"><b>Code:</b></span></td>	</tr>	<tr>	  <td class="code">// Page numbers for session handling</td>	</tr></table><span class="postbody">

<br />


<br />
<li> <span style="font-size: 18px; line-height: normal">Include Common.php</span>

<br />
Done in the above code.  This allows for you to use the phpBB DBAL, Templating system, Auth system, login system, and lang system.

<br />
<span style="font-weight: bold">Note:</span> If you do this (and it is required), and your board goes down, the rest of  your site will go down.

<br />


<br />
<li> <span style="font-size: 18px; line-height: normal">Check for Authorization(optional)</span>

<br />
In theory, because we included common.php above we can use phpBB2's built in Authenticication system.  We could do this, but it would be a lot of work.  For the sake of simplicity, we'll go over how to check if the user is logged in or not, and what to do about it.  First, the code to check for login status: </span><table width="90%" cellspacing="1" cellpadding="3" border="0" align="center"><tr> 	  <td><span class="genmed"><b>Code:</b></span></td>	</tr>	<tr>	  <td class="code">

<br />
if&#40; $userdata&#91;'session_logged_in'&#93; &#41;

<br />
&nbsp; &nbsp;&#123;

<br />
&nbsp; &nbsp;&nbsp; &nbsp;&#91;insert your HTML/PHP or whatever here&#93;

<br />
&nbsp; &nbsp;&#125;

<br />
else

<br />
&nbsp; &nbsp; &nbsp; &nbsp;&#123;

<br />
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;echo&#40;'Please Login'&#41;;

<br />
&nbsp; &nbsp; &nbsp; &nbsp;&#125;</td>	</tr></table><span class="postbody">

<br />
<span style="font-size: 16px; line-height: normal">Notes: <ul><li>You can change the error to whatever you want, even use a $lang variable.

<br />
<li> You can also use the message_die() function for the error.</ul></span>

<br />


<br />
<li><span style="font-size: 18px; line-height: normal">Other Notes:</span>

<br />
<ul> <li> Although not required, it is <span style="font-weight: bold">highly recommended</span> to append_sid() to all links in the pages.  It <span style="font-weight: bold">is required</span> that you append_sid() when linking back to the phpBB board itself. <a href="http://www.phpbb.com/kb/article.php?article_id=58" target="_blank" class="postlink">Using Append_sid()</a>

<br />
<li> The login HTML would be </span><table width="90%" cellspacing="1" cellpadding="3" border="0" align="center"><tr> 	  <td><span class="genmed"><b>Code:</b></span></td>	</tr>	<tr>	  <td class="code">&lt;form action=&quot;login.php&quot; method=&quot;post&quot;&gt;&lt;input type=&quot;text&quot; name=&quot;username&quot;&gt;&lt;br /&gt;&lt;input type=&quot;password&quot; name=&quot;password&quot;&gt;&lt;br /&gt;

<br />
&lt;input type=&quot;submit&quot; value=&quot;login&quot; name=&quot;login&quot;&gt;

<br />
&lt;/form&gt;</td>	</tr></table><span class="postbody"> </ul></ul>

<br />


<br />
[edit by wanrecords: the last code example has been slightly editted to include <span style="font-style: italic">name="login"</span> which is necessary for this to work. big thanks to <span style="font-weight: bold">tcalp</span> for bringing this to our attention.]</span></td>

				  </tr>

				  <tr>

					<td class="catBottom" align="center">

									  </td>

				  </tr>

				</table>

					<tr> 
	  <td width="100%"> 
		<hr size="1">
	  </td>
	</tr>
	<tr> 
	</tr>
	<tr>
			
		  <td nowrap rowspan="2" align="center">
		  <form method="post" action="login.php">
		  <font color="{loginerrorcolor}"><b></b></font> <span class="siteTextSmall">Username: 
		  </span> 
		  <input type="text" name="username" class="post">
		  <span class="siteTextSmall">Password: </span> 
		  <input type="password" name="password" class="post">
		  <input type="hidden" name="login" value="1">
		  <input type="submit" value="Login" class="mainoption">
		  </form>
		  </td>
				   
	</tr>
  </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">






<?php
include 'heador.php';
include 'dbconnect.php';

//open up database
mysql_select_db('HELPDISK');

$cat = $_GET['cat'];


$catnum = mysql_query ("SELECT catnum FROM url_categories WHERE category = '$cat'");
$catno = mysql_fetch_row($catnum);

print ("<h4>Gekozen categorie: $cat / Catno: ".$catno[0]."</h4><P>\n");
///print ("Categorie: $cat / Catno: ".$catno[0]."<br>\n");
/// is hetzelfde als: print ("Categorie: ".$cat." / Catno: ".$catno[0]."<P>\n");

$catselect = mysql_query ("SELECT DISTINCT catnum,category FROM url_categories WHERE subcatof = '$catno[0]'");
$count = mysql_num_rows($catselect);
if ($count != 0) {
	print ("<b>".$cat."</b> has ".$count." Subcategories:<br>\n");
							
	while($row = mysql_fetch_array($catselect, MYSQL_BOTH))
	{
		//print ("browse <a href=\"browseCat.php?cat=".$row["catnum"]."\"> ".$row["category"]."</a> - ");
		print ("<a href=\"listCat.php?cat=".$row["category"]."\"> ".$row["category"]."</a><br>\n");
	}
}

print ("<DIV CLASS=\"str\"><p><br>URL's: <br></DIV>\n");
// print ("SELECT * FROM url WHERE category = ".$catno[0]);
$result = mysql_query ("SELECT * FROM url WHERE category =".$catno[0]);
while($row = mysql_fetch_array($result, MYSQL_BOTH))
{
	print ("<a href=\"".$row["url"]."\" target=\"_blank\"> ".$row["name"]."</a><br>\n");
}

//close user connection
mysql_free_result($catselect);
mysql_free_result($result);
?>

</DIV>
</BODY>
</HTML>

