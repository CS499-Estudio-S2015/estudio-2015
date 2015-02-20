<?php
	// ClientLogin
	// Purpose:  queries the database for the provided Student ID and password.
	// Input:  receives StudentID and Password from index.php via a POST request
	// Output:  upon successful login (username found and password match) redirects
	//		to the client profile page, setting the 'user' session variable

session_start();
include_once("Config.php");
// if the user is already logged in, direct them to their profile.
// ** this may be better suited to only happen when the user navigates to index.php
if( isset( $_SESSION[ 'user' ] ) ) {
    header( 'Location: '.$pathPrefix.'clientInfo.php#tab1' );
}

?>

<?php
$current_url = base64_encode("http://".$SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

		// get the studentID and password from the POST array
		$email = $_POST['studentID'];
		$password = $_POST['password'];

		// check that the database connection was successful
		if ($mysqli->connect_error) {
 		   die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
		}


		// retrieve the row of the client table (all columns) for the provided
		// student ID.
		$queryResult = $mysqli->query("SELECT * FROM Client WHERE email='".$email."'");
		// if the query was successful
		if( $queryResult )
		{
			// check if an entry was found for this studentID (if this ID is registered)
			if( $queryResult->num_rows > 0 ) {
				$thisClient = $queryResult->fetch_object();
				if( $thisClient->password == $password )
				{
					// if the password matches, set the session variable and log them in.
					$_SESSION['user'] = $thisClient->id;
					header( 'Location: '.$pathPrefix.'clientInfo.php#tab1' ); exit;
				}
				else
				{
					// if the password does not match, return a login error via GET
					// ** index.php will check if loginerror isset, and print a message
					// accordingly
					header( 'Location: '.$pathPrefix.'index.php?loginerror=' ); exit;
				}
			}
			else
			{
				// if the username is not found in the database, return login error via GET
				// ** index.php checks if loginerror isset, and prints a message
				// accordingly
				header( 'Location: '.$pathPrefix.'index.php?loginerror=' ); exit;
			}

		}
		else
		{
			// The query was unsuccessful.
			echo 'The database query was unsuccessful.  The server may be down, or there
					is a problem connecting to the database.';
		}

?>

