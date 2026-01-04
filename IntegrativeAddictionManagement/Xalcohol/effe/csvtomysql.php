<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>csv import</title>

</head>

<body>

<?
##################################################################################################
# Your specific MySQL connection info. These will be overridden by $defaults_filename if it exists
# then any user input typed into the form.  You'd typically hide this info in an 
# include statement.  Obviously keep the variable names the same if you do
$host 		= "localhost";
$user 		= "Phillip";
$password 	= "helloagain";
$database 	= "testdatabase";
$tablename	= "testtable";
$filename	= "export.csv";

$defaults_filename = "csvtomysql.ini";
$tablenamemaxlength = 64;		# MySQL doesn't want bigger table names than this
$fieldnamemaxlength = 64;		# MySQL doesn't want bigger field names than this
$replacethesecharacters = "`";	# Characters in the field names read in from the csv we want to replace
$replacewithcharacters	= "'";	# Characters to replace those above.  These two lines are used in several strtr() functions
$csv_line_length	= 1000;		# Must be longer than the longest line in the csv file
$fgetcsv_delimiter	= ',';		# Edit this if you have a different delimiter character
$fgetcsv_enclosure	= '"';		# Edit this if you have a different enclosure character

if (is_file($defaults_filename))
{												# The file exists and its data will overwrite the hard coded defaults above
	$handle = fopen("$defaults_filename", "r");	# Open the file for reading
	$data = fgetcsv($handle, $csv_line_length,$fgetcsv_delimiter,$fgetcsv_enclosure);	# Get the first record (in this case the only record)
	$host		= $data[0];
	$user		= $data[1];
	$password	= $data[2];
	$database	= $data[3];
	$tablename	= $data[4];
	$filename	= $data[5];
}

# Following reads in any user values entered which will overwrite those above
if(isset ($_POST['host']) AND $_POST['host'] !=="")
{	$host = $_POST['host'];			}
if(isset ($_POST['username']) AND $_POST['username'] !=="")
{	$user = $_POST['username'];			}
if(isset ($_POST['password']) AND $_POST['password'] !=="")
{	$password = $_POST['password'];		}
if(isset ($_POST['database']) AND $_POST['database'] !=="")
{	$database = $_POST['database'];		}
if(isset ($_POST['tablename']) AND $_POST['tablename'] !=="")
{	$tablename = $_POST['tablename'];	}
if(isset ($_POST['filename']) AND $_POST['filename'] !=="")
{	$filename = $_POST['filename'];		}

##################################################################################################
if(isset($_POST['notes']))
{
	echo " This code will take a csv file and create or, insert or update, the data into a MySQL database.<br />
It assumes the first line contains the field names and uses that to build the SQL query<br />
for the following data lines.  <b>WARNING.</b> If you choose to do an update, all fields listed in the csv<br />
file will be overwritten in the database.  NULL fields (i.e. ,, in the csv file) are not overwritten.<br />
If you don't want certain fields overwritten make sure they are not in the csv file.<br />
<br />

When the script reads the first line containing the field names it replaces some characters MySQL might<br />
not like.  These can be adjusted with the \$replacethesecharacters and \$replacewithcharacters variables.<br />
I had problems here still not resolved.  A ' in a single csv field name didn't cause a problem.  In two fields<br />
the table would not be created but only when the fields were close together(?)<br />
<br />
The values in the six fields are hard coded at the start of the script.  You may want to put your values
in an include file somewhere secure. Alternatively:

The 'Set Values as Defaults' button writes the current values of the six fields to 'csvtomysql.ini' in the 
current working directory.  The script will read in these values if the file exists and replace those hard coded
in the script.  It's written in plain text so think about whether you want to store your password here.

To do an UPDATE, first make sure your file has been uploaded.  Enter the filename uploaded if different<br />
from the dafault of 'export.csv' in the '<b>Type the file name for the csv file to use:</b>' box, then click<br />
the '<b>Build Field List for UPDATE</b>' button.  This should give you a list of fields on which to base the<br />
SQL query.  Primary fields are prefixed 'PRI', unique fields 'UNI' and index fields marked 'MUL'. Choose a field then click the '<b>Update</b>' button.<br /> 
<br />


I'm new to PHP programming so doubtless there are better ways to do any number of things <br />
differently to the way I've done it here, but if it works.....  Note that I use the mysql<b>i</b> version
of the command that allows you to access the functionality provided by MySQL 4.1 and above.  If you use the
original mysql version do a global replace on the script.<br />
<br />
There are any number of things that will cause the code to fail.<br />
It will certainly fail if you try to insert duplicate data into fields where duplicates aren't<br />
allowed as there is no check.  Obviously you could code a check before insertion and bypass<br />
lines that contain duplicates, but then you get into the whole 'report back to the user the <br />
lines that have failed' routine.  Really beyond the scope of this program.<br />
It will also fail if the data is too big to INSERT or UPDATE into a field, or is the wrong type etc,<br />
but if you're using a MySQL database you would probably know how to fix the data or database to fix these problems.<br />
<br />
It's fully public domain, do with it what you like, but don't come crying to me if it<br />
breaks something on your machine.  You do backup your databases don't you!<br />
<br />
The development enviroment is;<br />
Firefox 2.0.0.13<br />
PHP 5.2.1<br />
Apache 2.2.4<br />
MySQL 5.0.22<br />
Windoze XP Sp2<br />
I don't think there's anything unusual here so it should work under most set up's<br /><br />
This is Version 1.00.00.  You know what that means!<br />
<br />
I hope you'll find it useful, I've tried to make the code self explanatory.  If you do find<br />
it useful please let me know by dropping me a line at phillipbiggs@hotmail.co.uk<br />
All the best Phillip Biggs<br /><br />
p.s. for beginners out there new to PHP and MySQL I can recommend 'PHP & MySQL' a Visual Blueprint<br />
book to get you started.  ISBN 0-470-04839-5
<form id='csv'name='csv'method='post' action='{$_SERVER['PHP_SELF']}'><p><input type='submit' name='continue' value='Continue' /></p></form>";
	exit;
}
##################################################################################################
function Check_File_Exists($local_filename)
{
	if (is_file($local_filename))
	{	return(1);	}			# Set a positive return as the file exists
	else
	{
		echo 'File <b>',$local_filename,'</b> does not exist in the current working directory.<br />
			Please check and try again';
		echo "<form id='csv'name='csv'method='post' action='{$_SERVER['PHP_SELF']}'><p><input type='submit' name='continue' value='Continue' />&nbsp&nbsp;  To edit your current values click the browser back button.</p></form>";
		exit;
	}
}
	
##################################################################################################
# Find the maximum file transfer size in bytes allowed by your php.ini in 'upload_max_filesize'
$max_file_size = ini_get('upload_max_filesize');
# The default is usually two meg and stored as '2M'. The next couple of lines determine if the
# value is stored as '2M' or as '2097152' (if you've stored it in kilobytes or gigs you're on your own)
$max_file_size = 1 * $max_file_size;		# This will turn '2M' into 2 but leave 2097152 untouched
if (strlen ($max_file_size) <= 3 )			# If it's a small number the value was probably in megs
{	$max_file_size = $max_file_size * 1024 * 1024;	}

##################################################################################################


# If you choose to upload a file, this bit copies it into the current working directory
if(isset($_POST['upload']))
{
	# Create a destination string for the uploading file.
	# The 'getcwd' gets the current working directory
	$destination = getcwd()."\\".$_FILES['csvname']['name'];
	# The file is uploaded into a temporary location and has to be moved by this function
	move_uploaded_file($_FILES['csvname']['tmp_name'],$destination);
	if ($_FILES['csvname']['size']==0)
	{
		echo '<p><b>The returned file size is zero bytes!</b><br />
			The most probable cause for this is that the file size is larger than the maximum allowled<br />
			in your php.ini file "upload_max_filesize" setting which is currently set to <b>',$max_file_size,'</b> bytes.';
	}
	else 
	{
		echo "<p></p><b>The file uploaded is:</b>
    		{$_FILES['csvname']['name']} ({$_FILES['csvname']['size']} bytes)<br />
    		<b>to directory: </b>",getcwd(),"\
			<p>( if the filename and/or destination are missing then the upload has failed )</p>";
	}
	echo "<form id='csv'name='csv'method='post' action='{$_SERVER['PHP_SELF']}'><p><input type='submit' name='continue' value='Continue' /></p></form>";
	exit;
}
##################################################################################################
if(isset($_POST['set_defaults']))		# User want to write the current values to csvtomysql.ini
{
	$handle = fopen($defaults_filename,"w+b");		# http://uk.php.net/manual/en/function.fopen.php
	$output_data = '"'.$host.'","'.$user.'","'.$password.'","'.$database.'","'.$tablename.'","'.$filename.'"';
	if (fwrite($handle, $output_data) === FALSE)
	{
		echo "Cannot write to file ',$defaults_filename,'.";
		exit;
	}
	echo "Data written to file ',$defaults_filename,'.";
	fclose($handle);		# Be good and tidy up after ourselves
	echo "<form id='csv'name='csv'method='post' action='{$_SERVER['PHP_SELF']}'><p><input type='submit' name='continue' value='Continue' /></p></form>";
	exit;
}




##################################################################################################
# Do a check to make sure that a MySQL field name has been selected if UPDATE has been chosen
if($_POST['sql_update']=="Default")		# Default means the user has selected an update but not picked a field from the dropdown list
{
	echo "You must select a field name to select the data by if using UPDATE.</p>
		<form id='csv'name='csv'method='post' action='{$_SERVER['PHP_SELF']}'><p><input type='submit' name='continue' value='Continue' />&nbsp&nbsp; To edit your current values click the browser back button.</p></form>";
	exit;
}
##################################################################################################
# Create a new database has been chosen.
if(isset($_POST['csv_create']))
{
	if(!$cxn = mysqli_connect($host,$user,$password))
	{
		echo "<p>Couldn't make a connection using host '",$host,"'... user '",$user,"' and the password entered.</p>";
		exit();
	}
	$sql = "CREATE DATABASE ".$database.";";			# Create the database.  Check you have CREATE rights for your login id in MySQL
	if($_POST['sql_feedback']=="on")
	{	echo $sql,'<br />';		}						# User wants full feedback of sql statement
	$result = mysqli_query($cxn,$sql)
	or die("Couldn't execute insert query: ".mysqli_error($cxn));
	
	if ($result)
	{	echo "Database '",$database,"' created.<br />";	}
	$sql = 'USE '.$database.' ;';						# Tell MySQL which database we're working with for the later table creation
	$result = mysqli_query($cxn,$sql)
		or die("Couldn't execute insert query: ".mysqli_error($cxn));
	if (Check_File_Exists($filename))					# Call my function to check the file is there (loads of error messages result otherwise)
	{	$handle = fopen("$filename", "r");	}			# Open the file for reading
	$data = fgetcsv($handle, $csv_line_length,$fgetcsv_delimiter,$fgetcsv_enclosure);			# Get the first record

	$size = count($data)-1;					# Count how many fields per line. Used in building the $sql statement (-1 as arrays start at 0)

	rewind($handle);						# Reset the handle to the start of the file stream 

	$length = 0;							# We're going to work out the maximum length of any field in the csv
	echo "Checking the csv file for the longest field.<br />";
	while (($data = fgetcsv($handle, $csv_line_length)) !== FALSE)
	{
		$loop	= 0;
		
		while ($loop <= $size)
		{	

			if($_POST['sql_feedback']=="on")			# User wants full feedback of output
			{		
				if ($loop == 0)
				{	echo '<br />';	}	
				echo $data[$loop],'&nbsp&nbsp&nbsp&nbsp&nbsp;';
			}
			if (strlen($data[$loop]) >= $length)		# Calculate the length of the field in $data[$loop]
			{	$length = strlen($data[$loop]);		}	# Make $length the new length if longer than current value
			$loop++;
		}
	}		
	echo "<br />Maximum field length is ",$length,". All fields will be set to this length.<br />";
	# Now we'll build the sql command to create the table.
	rewind($handle);								# Reset the handle to the start of the file stream
	$sql = "CREATE TABLE `".$tablename."` (`";		# Start building the $sql statement
	$data = fgetcsv($handle, $csv_line_length,$fgetcsv_delimiter,$fgetcsv_enclosure);
	#echo "<pre>LINE 203... ";	var_dump($data);	echo "</pre>";	# Handy for testing purposes
	$loop = 0;

	while ($loop <= $size)
	{	
		$data[$loop] = strtr($data[$loop],$replacethesecharacters,$replacewithcharacters);	# Replace unwanted characters in the csv field names
#		$data[$loop] = mysqli_real_escape_string($cxn,$data[$loop]);	# We'll escape the fields just in case there are any funnies in it like ' or \
		if ($data[$loop] >= $fieldnamemaxlength)
		{
			echo '<br />Field ',$data[$loop],' is longer than the MySQL allowled limit of ',$fieldnamemaxlength,'.<br />
				Please adjust the field length in the csv file and try again.<br />';
			echo "<form id='csv'name='csv'method='post' action='{$_SERVER['PHP_SELF']}'><p><input type='submit' name='continue' value='Continue' /></p></form>";
			exit;
		}
		if ($loop==$size)
		{	$sql = $sql.$data[$loop]."` VARCHAR(".$length.") NOT NULL );";	}	# Close off the sql statement
		else
		{	$sql = $sql.$data[$loop]."` VARCHAR(".$length.") NOT NULL, `";	}
		$loop++;

	}		

	if($_POST['sql_feedback']=="on")
	{		echo $sql,'<br />';	}						# User wants full feedback of output
	$result = mysqli_query($cxn,$sql)
		or die("Couldn't execute insert query: ".mysqli_error($cxn));
	if ($result)
	{
		echo "<br />Database table '",$tablename,"' created using type VARCHAR of length ",$length," for all fields.<br />";
		echo 'You may want to examine the new database and change the field types and lengths to suit your purposes.<br />';
		echo '<br /><b>NOTE: This only created the database and DID NOT insert the data.</b><br /> Run INSERT on the same csv file now to insert the data.<br />';
		# I could have automatically done the INSERT by POSTing forwards all the hostname/username/password etc but this programs is already a lot bigger than I intended.
	}

	fclose($handle);		# Be good and tidy up after ourselves
	echo "<form id='csv'name='csv'method='post' action='{$_SERVER['PHP_SELF']}'><p>
	<input type='submit' name='continue' value='Continue' /></p>  To run the INSERT with your current values click the browser back button.</form>";
	exit;
}
##################################################################################################

# File has been submitted and user wants to add data, so let's get on with processing it...
if(isset($_POST['csv_insert']) or isset($_POST['csv_update']))
{
	# Set up a few variables we'll need
	$first_pass		 	= 1;						# We'll do something on just the first pass later
	$count				= 0;						# Will display at the end to tell us how many records we processed
	if (Check_File_Exists($filename))							# Call my function to check the file is there (loads of error messages result otherwise)
	{	$handle = fopen("$filename", "r");	}			# Open the file for reading

	# We've got the SQL info, now we'll make the connection
	if(!$cxn = mysqli_connect($host,$user,$password,$database))
	{
		echo "<p>The ",$database," database is not available right now. Please try again later.</p>";
		exit();
	}
	# fgetcsv reads a csv file ($handle) into an array. It assumes comma as the field delimiter and
	# double quotation mark as the field enclosure character.  http://uk.php.net/manual/en/function.fgetcsv.php
	while (($data = fgetcsv($handle, $csv_line_length)) !== FALSE)
	{
		if(isset($_POST['csv_insert']))		# We're doing an INSERT.  The UPDATE section is lower down
		{
			if ($first_pass)
			{
				$size = count($data)-1;	# Count how many fields per line. Used in building the $sql statement (-1 as arrays start at 0)
				echo 'Number of fields per line is... ',$size+1,'.<br />';		# I like feedback
				/* Now we'll build the first part of the sql statement we'll use later.
				We'll do it here so we only have to go through the process once.  It will create
				everything needed up to the first piece of data.  */
				$sql_first_part = "INSERT INTO `$tablename` (`";
				$loop = 0;		# We'll use $loop to keep track of where we are so we don't put in a trailing comma
				while ($data[$loop])
				{
					$data[$loop] = strtr($data[$loop],$replacethesecharacters,$replacewithcharacters);	# Replace unwanted characters in the csv field names
					if ($loop==$size)
					{	$sql_first_part = $sql_first_part.$data[$loop]."`) VALUES (";		}
					else
					{	$sql_first_part = $sql_first_part.$data[$loop]."` , `";	}
					$loop++;
				}
				#echo $sql_first_part,'<br />';	# It's useful to keep some code handy for testing purposes
				$first_pass = 0;				# Don't want to do this bit again
			}
			else
			{
				# We'll now create the second half of the sql statement that contains the data
				##################################################################################################
				/* This section tests for a null length field.  As writing "$data[$loop]", as we do later on, with
				a null length field will cause the code to fail, we'll replace them with a single space.  You can
				of course put anything in there you like for your database instead */
				$loop = 0;
				foreach($data as $value)
				{
					if($value!="")
					{	$data[$loop] = $value;	}
					else
					{	$data[$loop]= " ";		}					# Replace "" with a space
					$loop++;										# Increment the counter
				}
				##################################################################################################
				# Now we'll build the full $sql statement
				$sql = $sql_first_part;
				# We'll use $loop to keep track of where we are so we can close off the
				# sql statement on the last value of the line
				$loop = 0;
				while ($data[$loop])
				{
					# We'll escape the data in case there are any odd characters which MySQL wont like http://uk.php.net/manual/en/mysqli.real-escape-string.php
					$data[$loop] = mysqli_real_escape_string($cxn,$data[$loop]);
					if ($loop==$size)
					{	$sql = $sql."'".$data[$loop]."');";		}	# Close off the sql statement
					else
					{	$sql = $sql."'".$data[$loop]."', ";	}
					$loop++;										# Increment the counter
				}
				#echo "<pre>";	var_dump($data);	echo "</pre>";	# Handy for testing purposes
				if($_POST['sql_feedback']=="on")
				{	echo $sql,'<br />';		}						# User wants full feedback of sql statement
				$result = mysqli_query($cxn,$sql)
				or die("Couldn't execute insert query: ".mysqli_error($cxn));
				if ($result)
				{
					$count++;										# Increment the counter
					echo 'Record ',$count,' entered.<br />';		# Told you I liked feedback
				}
			}					
		}
		##################################################################################################
		if(isset($_POST['csv_update']))		# We're doing an UPDATE here.  The INSERT section is above
		{
			if ($first_pass)
			{
				$size = count($data)-1;					# Count how many fields per line. Used in building the $sql statement (-1 as arrays start at 0)
				$update_field = $_POST['sql_update'];	# This is the field selected in the drop down field list
				# In this section because the SQL UPDATE statement is structured differently to the INSERT
				# we need to read in the field names into an array as they will be used for every pass of the
				# data unlike the INSERT section where they were used once to build the first part of the SQL
				$loop = 0;
				while ($data[$loop])
				{
					$data[$loop] = strtr($data[$loop],$replacethesecharacters,$replacewithcharacters);	# Replace unwanted characters in the csv field names
					$field_names[] = $data[$loop];
					if ($update_field==$data[$loop])	# Get the index position of the field used to set the WHERE in the UPDATE	
					{	$update_index = $loop;	}
					$loop++;
				}
				$first_pass = 0;				# Don't want to do this bit again
			}
			else
			{
				$loop = 0;				
				$sql = "UPDATE ".$tablename." SET ";
				foreach($data as $value)
				{
					if($value!="")
					{
						# We'll escape the data in case there are any odd characters which MySQL wont like http://uk.php.net/manual/en/mysqli.real-escape-string.php
						$data[$loop] = mysqli_real_escape_string($cxn,$data[$loop]);
						$sql = $sql."`".$field_names[$loop]."` = '".$data[$loop]."', ";	
					}
					$loop++;										# Increment the counter
				}
				$sql = trim($sql," ,");								# This will trim off the final space and comma which we don't want at the end of the SET section
				$sql = $sql."WHERE `".$update_field."` = '".$data[$update_index]."';";	# Close off the sql statement   put in WHERE .sql_update.=.value of field we're updating;
				if($_POST['sql_feedback']=="on")
				{	echo $sql,'<br />';		}						# User wants full feedback of sql statement
				$result = mysqli_query($cxn,$sql)
				or die("Couldn't execute insert query: ".mysqli_error($cxn));
				if ($result)
				{
					$count++;										# Increment the counter
					echo 'Record ',$count,' entered.<br />';		# Told you I liked feedback

				}
			}
		}	
	}
	echo '<p><b>Import completed.  ',$count,' records updated or inserted.</b></p>';
	fclose($handle);		# Be good and tidy up after ourselves
	echo "<form id='csv'name='csv'method='post' action='{$_SERVER['PHP_SELF']}'><p><input type='submit' name='continue' value='Continue' /></p></form>";
	exit;
}
else
{
	# Display the form to request user input
	echo "<h2>CREATE, INSERT or UPDATE data from a csv file into a MySQL database.</h2>
		<h3>Leave any or all of fields marked * blank to use the defaults coded into the script...</h3>";
	echo "<form id='csv'name='csv'method='post' action='{$_SERVER['PHP_SELF']}'>";
	#echo "<form id='csv'name='csv'method='post' action='post_test.php'>";
	echo "<p>Type the hostname of the target system: * &nbsp&nbsp(default '$host')	<br /><input type='text' name='host' size='50' />
	<p>Type the username for the database: * &nbsp&nbsp(default '$user')	<br /><input type='text' name='username' size='50' />
	<p>Type the password for the database: *
		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
	Tick for full SQL command & other detailed output <input type='checkbox' name='sql_feedback' id='checkbox' /><br /><input type='password' name='password' size='50' /></p>
	<p>Type the database name: * &nbsp&nbsp(default '$database')<br /><input type='text' name='database' size='50' /></p>
	<p>Type the table name for the database: * &nbsp&nbsp(default '$tablename')<br /><input type='text' name='tablename' size='64' maxlength='",$tablenamemaxlength,"'/></p>
	<p>Type the file name for the csv file to use: * &nbsp&nbsp(default '$filename')
	<br /><input type='text' name='filename' size='50' />&nbsp;&nbsp;&nbsp;(Assumes it's in the same directory as this script)</p>";

	if (isset($_POST['build_list']))	# Build the list of filenames from the selected tablename
	{
		if(!$cxn = mysqli_connect($host,$user,$password,$database))
		{
			echo "<p>Tried to connect to ",$database," database to retrieve field names. It is not available right now. Please try again later.</p>";
			exit();
		}

		$sql = "SHOW COLUMNS FROM ".$tablename.";";		# Load in the information from the table.
		$result = mysqli_query($cxn,$sql);
		if (!$result)
		{
			echo 'Could not run query on table ',$tablename.'.  Error'. mysql_errori();
			exit;
		}
		echo "Pick the MySQL field used to select the data to be UPDATEd, then click 'Update'.<br />
		&nbsp&nbsp&nbsp&nbsp
		<select name='sql_update' id='sql_update'>";
		# The next section will read in the column names and try to establish if there are any index fields


		while ($row = mysqli_fetch_assoc($result))
		{
			$field_names[]	= $row["Field"];
			$key_type[]	= $row["Key"];
			$loop++;
		}
		# Going to build a $display_names array that will show the index type if the field is indexed
		$loop 	= 0;						# Set the counter to 0		
		while ($field_names[$loop])	
		{
			$display_names[$loop] = $key_type[$loop]."............".$field_names[$loop];
			$loop++;
		}
			
		$loop = 0;								# Set the counter to 0
		echo "<option value='Default'>Choose Carefully!</option>";
		while ($field_names[$loop])
		{
			echo "<option value='",$field_names[$loop],"'>",$display_names[$loop],"</option>";
			$loop++;
		}
		echo "</select>
		&nbsp&nbsp;Suggestion:  Pick an index field if possible.&nbsp&nbsp&nbsp
		<input type='submit' name='csv_update' value='Update' />&nbsp&nbsp&nbsp&nbsp;";	
	}
	else
	{
		echo "<p><input type='submit' name='csv_create' value='CREATE' />&nbsp&nbsp&nbsp&nbsp;
		<input type='submit' name='csv_insert' value='INSERT' />&nbsp&nbsp&nbsp&nbsp;
		<input type='submit' name='build_list' value='Build Field List for UPDATE' />&nbsp&nbsp&nbsp&nbsp;";

	}
	echo "<input type='submit' name='set_defaults' value='Set Values as Defaults' />&nbsp&nbsp&nbsp&nbsp;
	<input type='submit' name='notes' value='Read Notes' /></p></form></p></form>
	<p> ...or...</p>";
	echo"<form enctype='multipart/form-data' action='{$_SERVER['PHP_SELF']}' method='POST'>
	<input type='hidden' name='MAX_FILE_SIZE' value='$max_file_size' >
	<p>Upload a file to process first:&nbsp;&nbsp;&nbsp;(Will upload into the current working directory for this script)<br /><input type='file' name='csvname' size='50' /></p>
	<p><input type='submit' name='upload' value='Upload csv' /></p>
	</form>";
}

?>
  
</body>
</html>

