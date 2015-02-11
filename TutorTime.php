<?php

session_start();
include_once("Config.php");
if( !isset( $_SESSION[ 'staff' ] ) ) {
    header( 'Location: '.$pathPrefix.'index.php' ); exit;
}

?>

<!-- This is the code that connects to the scheduleTutor.html page that actually adds the tutor's time to the database. -->

<?php
$current_url = base64_encode("http://".$SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

	// get the information from the post array
	$tutorEmail = $_POST['Email'];
	$weekday = $_POST['weekday'];
	$startTime = $_POST['start_time'];
	$endTime = $_POST['end_time'];


	// check the Tutor table for the provided tutor name.  If it is not found, redirect back with an error message
	$tutorFound = $mysqli->query("SELECT * FROM Tutor WHERE Email= '".$tutorEmail."'");

	if( $tutorFound->num_rows == 0 )
	{
		// header redirect to scheduleTutor.php with an error message ("Email provided is not registered.  Check for typos and try again.")
		header( 'Location: '.$pathPrefix.'scheduleTutor.html?tutorNotFound=' ); exit;
	}

	// INVARIANT:  at this point, the tutor was definitely found in the Tutor table and is therefore registered.

	// insert the tutor shift into the Times table
	$results = $mysqli->query("INSERT INTO Times Values ('".$startTime."','".$endTime."','".$tutorEmail."','".$weekday."')");
    if( !$results )
    {
        echo 'Failed Query';
    }
	header('Location: '.$pathPrefix.'scheduleTutor.html?successfulEntry=' ); exit; //fix header

	exit;
?>
