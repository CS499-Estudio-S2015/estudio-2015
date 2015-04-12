<?php
	/*  ClientRegister
		Purpose: This file uses the information provided on index.php in the
		registration box to add a row to the Client table.

		Input: First Name, Last Name, Student ID number, major, academic year,
		whether english is the user's second language, email address, and
		password.  All of this information was checked for validity via
		JavaScript on index.php and is used in a mysqli query to insert into
		Client.  All user input is converted to mysql_real_escape_string to
		protect against SQL injection.

		Output:  A client row is added to the Client table, and the user is
		redirected to the my profile page upon successful addition.  If the
		student ID was already in the table, the user is directed back to
		index.php with an error message displayed.
	*/



session_start();
include_once("Config.php");

?>

<?php
//$current_url = base64_encode("http://".$SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

if ($mysqli->connect_error) {
	die("Connection failed: " . $mysqli->connect_error);
}

// get all of the info from the post array
$lastName = $_POST['lastName'];
$firstName = $_POST['firstName'];
$major = $_POST['major'];
$year = $_POST['year'];
$english = $_POST['english'];
$email = $_POST['email'];
$password = $_POST['password'];
$englishSecondLanguage = 0;
if( $english == "yes" ) { $englishSecondLanguage = 1; }

// Prepared Statements for Registration
//
// First, validate that email address isn't registered
if (!($select = $mysqli->prepare("SELECT EXISTS(SELECT * FROM Client WHERE email = ?)"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	header( 'Location: '.$pathPrefix.'index.php?error='.$mysqli->errno ); exit;
}

if (!$select->bind_param("s", $email)) {
	echo "Binding parameters failed: (" . $select->errno . ") " . $select->error;
	header( 'Location: '.$pathPrefix.'index.php?error='.$mysqli->errno ); exit;
}

if (!$select->execute()) {
	echo "Binding parameters failed: (" . $select->errno . ") " . $select->error;
	header( 'Location: '.$pathPrefix.'index.php?error='.$mysqli->errno ); exit;
} else {
	$select->bind_result($res);
	$select->fetch();
	$select->close();
	
	if ($res) { 	// if email has been registered, redirect with error uri
		header( 'Location: '.$pathPrefix.'index.php?error=id_taken' ); exit;
	} else {		// else create new client 
		if (!($insert = $mysqli->prepare("INSERT INTO Client (lastName,firstName,major,year,english,email,password) VALUES (?,?,?,?,?,?,?)"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			header( 'Location: '.$pathPrefix.'index.php?error=prepare' ); exit;
		}

		if (!$insert->bind_param("ssssiss", $lastName,$firstName,$major,$year,$englishSecondLanguage,$email,$password)) {
			echo "Binding parameters failed: (" . $insert->errno . ") " . $insert->error;
			header( 'Location: '.$pathPrefix.'index.php?error=bind' ); exit;
		}

		if (!$insert->execute()) {
			echo "Execute failed: (" . $insert->errno . ") " . $insert->error;
			header( 'Location: '.$pathPrefix.'index.php?error=execute' ); exit;
		} else {
			$_SESSION['user'] = mysqli_insert_id($mysqli);
			header( 'Location: '.$pathPrefix.'./ea' ); exit;
		}

		$insert->close();
	}
}

// put the client info into the Client table




// try {
// //$results = $mysqli->query("INSERT INTO Client (lastName,firstName,major,year,english,email,password)
// //	Values ('".$lastName."','".$firstName."','".$major."','".$year."',".$englishSecondLanguage.",'".$email."','".$password."')");

// }
// catch (Exception $ex) {
// 	echo $ex;
// }

// if the user wasn't found in the database, direct them to their
// profile page after insertion
// if( $results )
// {
// 	// Set the session variable for user
// 	$_SESSION['user'] = mysqli_insert_id($mysqli);
// 	header( 'Location: '.$pathPrefix.'estudioMakeAppointment.php' ); exit;
// }
// if the user was already registered (that studentID was taken)
// then redirect back to the index page with error message
// else
// {
// 	header( 'Location: '.$pathPrefix.'index.php?idtaken=' ); exit;
// }
?>

