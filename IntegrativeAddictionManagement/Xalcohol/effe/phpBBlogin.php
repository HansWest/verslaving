<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Log In</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<?php
//The Basics: Borrow phpBB's session initialization code 

//Include common.php 

//Check for authorization [In this Article, just checking for login/logout status (optional)] 

//Session (and other required) Code: The following code must be entered into each of the PHP pages for which you want phpBB to do sessions. Code:

define('IN_PHPBB', true); 
$phpbb_root_path = '../forum/';
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx); 

// 
// Start session management 
// 
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 
// 
// End session management 
//


//PAGE_INDEX is used in the View Online Page to show the user's location on the forum. It can be any of the values defined in /includes/constants.php under Code:

// Page numbers for session handling


//Include Common.php  Done in the above code. This allows for you to use the phpBB DBAL, Templating system, Auth system, login system, and lang system. 
//Note: If you do this (and it is required), and your board goes down, the rest of your site will go down. 


//Check for Authorization(optional)  In theory, because we included common.php above we can use phpBB2's built in Authenticication system. We could do this, but it would be a lot of work. For the sake of simplicity, we'll go over how to check if the user is logged in or not, and what to do about it. First, the code to check for login status: Code:


if( $userdata['session_logged_in'] ) 
   { 
      echo '[insert your HTML/PHP or whatever here] ';
   } 
else 
       { 
               echo('Please Login'); 
       }


//Notes: You can change the error to whatever you want, even use a $lang variable. 
//You can also use the message_die() function for the error.


//Other Notes: Although not required, it is highly recommended to append_sid() to all links in the pages. It is required that you append_sid() when linking back to the phpBB board itself. Using Append_sid() 


//The login HTML would be Code:
?>
<form action="login.php" method="post"><input type="text" name="username"><br /><input type="password" name="password"><br /> 
<input type="submit" value="login" name="login"> 
</form>
</body>
</html>
