<?phpob_start();session_start();require("admin.php");require("config.php");?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"><head><link rel="stylesheet" type="text/css" href="style.css">    <title>PUDS Donation System</title></head><body>	<div id="header">		<h1>PayPay-ULX Donation System Config Installer</h1>	</div><?php//Gets the current URLfunction curDomain() {	$pageURL = 'http';	if ($_SERVER["HTTPS"] == "on") {		$pageURL .= "s";	}		$pageURL .= "://";	if ($_SERVER["SERVER_PORT"] != "80") {		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];	} else {		$pageURL .= $_SERVER["SERVER_NAME"];	}	return $pageURL;}//Gets the current Directoryfunction curDirectory() {	$current_dir_url = 'http';	if ($_SERVER["HTTPS"] == "on") {		$pageURL .= "s";	}		$current_dir_url .= "://";	if ($_SERVER["SERVER_PORT"] != "80") {		$current_dir_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];	} else {		$current_dir_url .= $_SERVER["SERVER_NAME"];	}	$current_dir_url .= dirname($_SERVER['PHP_SELF']);	return $current_dir_url;}//Session information	$steam64 = $_SESSION['id'];	$steamID = $_SESSION['sid'];	$friendlyName = $_SESSION['name'];	$mAvatar = $_SESSION['mAvatar'];	//Defaultsif (empty($UseDB)) {	$UseDB = 'true';}if (empty($_STEAMAPI)) {	$_STEAMAPI = $_SESSION['steamAPI'];}if (empty($HOST)) {	$HOST = 'localhost';}if (empty($payPalURL)) {	$payPalURL = 'https://www.paypal.com/cgi-bin/webscr';}if (empty($website)) {	$website = curDomain();}if (empty($currency)) {	$currency = 'GBP';}if (empty($payPalEmail)){	$payPalEmail = 'Changeme@changeme.com';}if (empty($IPN)) {	$IPN = curDirectory() .'/ipn.php';}if (empty($donateDir)) {	$donateDir = curDirectory();}if (empty($prices)) {	$prices = array("1","2","3");}if (empty($ranks)) {	$ranks = array("iron", "bronze", "gold");}if (empty($commands)) {	$commands = array("ulx adduserid", "ulx adduserid", "ulx adduserid");}if (empty($messageRankFail)){	$messageRankFail ='	Thank you for your purchase $name Your rank information 	------------------------- 	Paid: \$fee 	SteamID: \$steamid 	Rank: \$rank 	-------------------------	There has been an issue when adding your SteamID to the correct usergroup.	Please contact the server admin to resolve this issue.';}if (empty($messageSuccess)){	$messageSuccess ='Thank you for your purchase $name Your rank information	------------------------- 	Paid: \$fee 	SteamID: \$steamid	Rank: \$rank	-------------------------	Your rank will be available immediately';}if (empty($messageIPNFail)){	$messageIPNFail ='	Hello, The donation has failed to be verified by PayPal IPN, however payment may have been taken.	Please contact the owner of the server to resolve this issue.';}if (ISSET($_POST["Submit"])) {	$prices_str = '"' . implode('", "', explode(',', $_POST[prices])). '"';	$ranks_str = '"' . implode('", "', explode(',', $_POST[ranks])). '"';	$commands_str = '"' . implode('", "', explode(',', $_POST[commands])). '"';		echo '<p> Config successfully updated!</p>';	$string = "<?php \$name = '';\n	\$fee = '';\n	\$steamid = '';\n	\$rank = '';\n	\$donationDir = '$_POST[donationDir]';\n	\$IP = '$_POST[IP]';\n	\$PORT = '$_POST[PORT]';\n	\$PASSWORD = '$_POST[PASSWORD]';\n	\$_STEAMAPI = '$_POST[steamapi]';\n	\$UseDB = '$_POST[UseDB]';\n	\$HOST = '$_POST[HOST]';\n	\$DBUSER = '$_POST[DBUSER]';\n	\$DBPASS = '$_POST[DBPASS]';\n	\$DBNAME = '$_POST[DBNAME]';\n	\$DBTABLE = '$_POST[DBTABLE]';\n	\$payPalURL = '$_POST[payPalURL]';\n	\$IPN = '$_POST[IPN]';\n	\$payPalEmail = '$_POST[payPalEmail]';\n	\$website = '$_POST[website]';\n	\$currency = '$_POST[currency]';\n	\$prices = array($prices_str);\n	\$ranks =  array($ranks_str);\n	\$commands = array($commands_str);\n	\$messageRankFail = '$_POST[messageRankFail]';\n	\$messageSuccess = '$_POST[messageSuccess]';\n	\$messageIPNFail = '$_POST[messageIPNFail]';\n	?>";	 $fp = FOPEN("config.php", "w");	FWRITE($fp, $string);	FCLOSE($fp);	header("Location: $donateDir/install.php");};if (!isset($_SESSION['id'])) {    header("Location: $donateDir/login.php");    exit();}if($_SESSION['admin'] == true){echo "	<p> Hello $friendlyName</p>	<img src='$mAvatar'/>	<a href='$donateDir/logout.php'>Logout</a>	<form action='' method='post' name='install' id='install'>	<h2>Garrysmod Server Configuration</h2>	<p><input name='IP' type='text' id='IP' value=$IP>Server IP</p>Your garrysmod Server IP or localhost if your server runs on the same server as this website.	<p><input name='PORT' type='text' id='PORT' value=$PORT>Server Port</p>Your garrysmod Server port.	<p><input name='PASSWORD' type='password' id='PASSWORD' value=$PASSWORD>RCON Password</p>Your garrysmod rcon password - remember to set it up on your gmod server!	<h2>Donation directory</h2>	<p><input name='donationDir' type='text' id='donationDir' value=$donateDir style='width: 300px;'>Donation Files Directory</p> You should not need to change this.	<h2>Steam API Key</h2>	<p><input name='steamapi' type='text' id='steamapi' value='$_STEAMAPI' style='width: 300px;'>Steam API Key</p> Get one <a href=http://steamcommunity.com/dev/registerkey>here</a>	<h2>MySQL Database Configuration</h2>	<p><select name='UseDB' type='text' id='UseDB'>";		$truefalse ="<option value='true'>True</option>				<option value='false'>False</option>";	$truefalse = str_replace("'$UseDB'", "'$UseDB' selected", $truefalse);	echo $truefalse;	echo"</select>	Use MySQL (true/false) 	</p> Set to true to enable saving of donations to a mysql database. Setting to false will not save any record of donations (other than the log files).	<p><input name='HOST' type='text' id='HOST' value=$HOST>Database Host</p>If this script is on the same webserver as your database leave as localhost	<p><input name='DBUSER' type='text' id='DBUSER' value=$DBUSER>Database User</p>The user for the MySql database	<p><input name='DBPASS' type='password' id='DBPASS' value=$DBPASS>Database Password</p>Password for the MySql user	<p><input name='DBNAME' type='text' id='DBNAME' value=$DBNAME>Database Name</p>The name of the database	<p><input name='DBTABLE' type='text' id='DBTABLE' value=$DBTABLE>Database Table</p>The name of the database table to store the donation information (PUDS will create it if its not already made)	<p>	<h2>PayPal Configuration</h2> 	<select name='payPalURL' type='text' id='payPalURL'>";	$paypalurls ="<option value='https://www.paypal.com/cgi-bin/webscr'>Live PayPalURL</option>	<option value='https://www.sandbox.paypal.com/cgi-bin/webscr'>Sandbox PayPalURL</option>";	$paypalurls = str_replace("'$payPalURL'", "'$payPalURL' selected", $paypalurls);	echo $paypalurls;	echo "</select>	PayPal URL 	</p>Set to Sandbox for testing, Set to Live for a live environment.	<p><input name='payPalEmail' type='text' id='payPalEmail' value='$payPalEmail' style='width: 300px;'>PayPal E-mail</p> The paypal account the donations go to - remember to change this to a sandbox account if testing the sandbox.	<p><input name='IPN' type='text' id='IPN' value=$IPN style='width: 300px;'>IPN Script URL</p> The location of the IPN script, you should not need to change this.	<p><input name='website' type='text' id='website' value=$website style='width: 300px;'>Your website</p> PUDS will automatically fill this in for you.	<p><select name='currency' type='text' id='currency'>";	$currencycodes ="<option value='AUD'>AUD Australian Dollar</option>	<option value='CAD'>CAD Canadian Dollar</option>	<option value='CZK'>CZK Czech Koruna</option>	<option value='DKK'>DKK Danish Krone</option>	<option value='EUR'>EUR Euro</option>	<option value='HKD'>HKD Hong Kong Dollar</option>	<option value='HUF'>HUF Hungarian Forint</option>	<option value='ILS'>ILS Israeli New Sheqel</option>		<option value='JPY'>JPY Japanese Yen</option>		<option value='MXN'>MXN Mexican Peso</option>		<option value='NOK'>NOK Norwegian Krone</option>		<option value='NZD'>NZD New Zealand Dollar</option>		<option value='PHP'>PHP Philippine Peso</option>		<option value='PLN'>PLN Polish Zloty</option>			<option value='GBP'>GBP Pound Sterling</option>			<option value='SGD'>SGD Singapore Dollar</option>	<option value='SEK'>SEK Swedish Krona</option>	<option value='CHF'>CHF Swiss Franc</option>	<option value='TWD'>TWD Taiwan New Dollar</option>	<option value='THB'>THB Thai Baht</option>	<option value='USD'>USD U.S. Dollar</option>";	$currencycodes = str_replace("'$currency'", "'$currency' selected", $currencycodes);	echo $currencycodes;	$prices_str = implode(",", $prices);	$ranks_str = implode(",", $ranks);	$commands_str = implode(",", $commands);	echo "</select>	Your currency</p>Set to the currency donators will pay in, these are all functional with PayPal.	<h2>Donation/Rank Configuration</h2> 	<p>Each item in the following lists align with each other, please keep them comma separated.</p>	<p><input name='prices' type='text' id='prices' value='$prices_str' style='width: 300px;'>Prices</p> eg. 1,2,3,4 or 10,20,50,100 etc.	<p><input name='ranks' type='text' id='ranks' value='$ranks_str' style='width: 300px;'>Ranks</p> These are the ULX groups which users are donating for. eg. bronze,silver,gold or rank1,rank2,rank3	<p><input name='commands' type='text' id='commands' value='$commands_str' style='width: 300px;'>Commands</p> eg. ulx adduserid,ulx adduserid,ulx adduserid - currently PUDS only supports ulx adduser as a command for each rank.	<h2>E-mail Messages Configuration</h2> 	<p>The e-mail section currently does not accept variables such as \$steamid, \$fee, \$rank. These must be put in without a backslash before the variable,directly into config.php	<p><TEXTAREA name='messageRankFail' rows='10' cols='80'>$messageRankFail</TEXTAREA>Failed Rank E-mail</p>	<p><TEXTAREA name='messageSuccess' rows='10' cols='80'>$messageSuccess</TEXTAREA>Successful E-mail</p>	<p><TEXTAREA name='messageIPNFail' rows='10' cols='80'>$messageIPNFail</TEXTAREA>IPN Failed E-mail</p>	<p>Click Save to write to the config file. Click Load to load the config for editing.</p>	<input type='submit' name='Submit' value='Save'>	<input type='button' value='Load' onClick='window.location.reload()'>	</p>	</form>";} else {	if ($_SESSION['id']) {		echo "<p>Hello, $friendlyName You are not admin! Please login as admin.		<img src='$mAvatar'/>		<a href='$donateDir/logout.php'>Logout</a>";	}	} ?>	</body></html>