<?php
//This is the config file, used to link to configure all database connection requests
// set the path prefix used in any header redirect (the path to this directory)


/* Live Server 
$pathPrefix = 'https://scheduling.engr.uky.edu/~beta';

//set database login information
$db_username = 'beta';
$db_password = 'MV.gVfRNzc';
$db_name = 'estudio_beta';
$db_host = 'localhost';
*/


/* Matt's Test Server */
$pathPrefix = 'localhost/estudio-2015/';

// set database login info
$db_username = 'root';
$db_password = '';
$db_name = 'estudio_beta';
$db_host = 'localhost';


// connect to the database and set up a mysqli object
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// connect to the database using PDO API
try {
	$db = new PDO("mysql:host=" . $db_host . ";dbname=" . $db_name, $db_username, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("SET NAMES 'utf8'");
} catch (Exception $e) {
	echo "Could not connect to the database.";
}

?>

