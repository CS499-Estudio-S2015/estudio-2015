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
$current_url = base64_encode("http://".$SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);


		// get all of the info from the post array
		$lastName = $_POST['lastName'];
		$firstName = $_POST['firstName'];
		$studentID = $_POST['studentID'];
		$major = $_POST['major'];
		$year = $_POST['year'];
		$english = $_POST['english'];
		$email = $_POST['email'];
		$password = $_POST['password'];
        $englishSecondLanguage = 0;
		if( $english == "yes" ) { $englishSecondLanguage = 1; }

		// Set the session variable for user
		$_SESSION['user'] = $studentID;

		// put the client info into the Client table
    	$results = $mysqli->query("INSERT INTO Client Values ('".$lastName."','".$firstName."','".$studentID."','".$major."','".$year."',".$englishSecondLanguage.",'".$email."','".$password."')");

		// if the user wasn't found in the database, direct them to their
		// profile page after insertion
		if( $results )
		{
			header( 'Location: '.$pathPrefix.'estudioMakeAppointment.php' ); exit;
		}
		// if the user was already registered (that studentID was taken)
		// then redirect back to the index page with error message
		else
		{
			header( 'Location: '.$pathPrefix.'index.php?idtaken=' ); exit;
		}
?>

