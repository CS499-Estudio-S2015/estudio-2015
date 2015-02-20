<?php

/*
    StaffLogin
    -- Backend file.
    Purpose:  Queries the database using info given from staffPortal.php.  Uses email and password to verify
              login information and then log in the user.  If the  user has admin access, they are directed
              to the admin page.  If they are just a tutor, they are directed to the tutor page.

*/


session_start();

include_once("Config.php");

?>

<?php
$current_url = base64_encode("http://".$SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

		$email = $_POST['email'];
		$password = $_POST['password'];

		if ($mysqli->connect_error) {
 		   die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
		}

        // Get the tutor or admin with the given email and password
		$queryResult = $mysqli->query("SELECT * FROM Tutor WHERE email='".$email."' AND password='".$password."'");
		if( $queryResult )
		{
            // if the password matches, and the email is found...
			if( $queryResult->num_rows > 0 ) {
				$thisClient = $queryResult->fetch_object();
				// set the session variable and log them in.
				$_SESSION['staff'] = $email;
				if( $thisClient->isAdmin == 1 )
				{
					header( 'Location: '.$pathPrefix.'adminHelp.html' ); exit;
				} else {
					header( 'Location: '.$pathPrefix.'tutorProfile.php' ); exit;
				}
			}
			else  // the password didn't match, or the email was not found.
			{
				header( 'Location: '.$pathPrefix.'staffPortal.php?loginerror='.$email.'&'.$password ); exit;
			}
		}

        // if the result comes back false, then the query encountered problems connecting
        // notify the user
        echo 'The Server is down. Try again later.';


?>

