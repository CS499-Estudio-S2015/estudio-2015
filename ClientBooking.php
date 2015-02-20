<?php
    // ClientLogin
    // Purpose:  queries the database for the provided Student ID and password.
    // Input:  receives StudentID and Password from index.php via a POST request
    // Output:  upon successful login (username found and password match) redirects
    //      to the client profile page, setting the 'user' session variable

session_start();
include_once("Config.php");
// if the user is already logged in, direct them to their profile.
// ** this may be better suited to only happen when the user navigates to index.php
if( !isset( $_SESSION[ 'user' ] ) ) {
    header( 'Location: '.$pathPrefix.'estudioMakeAppointment.php?conflict=' ); exit;
}

?>

<?php
$current_url = base64_encode("http://".$SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

		//var_dump($_POST);
		
        $appointmentDateTimeAndEmail = $_POST['time'];

		// split up the date, time and email
		$date = strtok( $appointmentDateTimeAndEmail, ' ' );
		$time = strtok( ' ' );
		$email = strtok( ' ' );
		// reassemble the datetime
		$aptDateTime = $date.' '.$time;

		// get the studentID
		$studentID = $_SESSION['user'];

		// get the duration
		$duration = $_POST['duration'];

		// get the group size
		$groupSize = $_POST['quantity'];

		// get first time visit
		$firstVisit = $_POST['firstVisit'];

		// get the comment
		$comment = $_POST['comment'];

		// get the service
		$service = $_POST['service'];

		// convert $firstVisit to tinyint for input into database
		if( $firstVisit == "Yes" )
		{
			$firstVisit = 1;
		} else {
			$firstVisit = 0;
		}

		// check if time + duration conflicts with another appointment.
		 // select all of the appointments already scheduled for the selected day
        $appResult = $mysqli->query( "SELECT * FROM Appointment WHERE DATE(startTime) = STR_TO_DATE('".$aptDateTime."', '%Y-%m-%d');" );
		if( $appResult )
		{
			echo 'app query successful';
		}
		if( $appResult->num_rows > 0 )
		{
			echo 'things found <br>';
		}

		// convert the string into a php datetime type to get the requested starttime
		$request_startTime = new DateTime($aptDateTime);
		// get the end time
		$request_startTimePlusDuration = new DateTime($aptDateTime);
		$request_startTimePlusDuration->add( new DateInterval( 'PT'.$duration.'M') );

		// boolean for whether or not there is a conflict with a previously scheduled appointment
		$scheduleConflict = false;

		///////////////
		/*-- NOTE: --*/
		///////////////
		//  this while loop looks through all of the previously scheduled appointments for a collision with the
		//	selected date and time and tutor.  Each appointment will be held in $obj while it is being analyzed.
		while( $obj = $appResult->fetch_object() )
		{
			// initialize variables to store start and end times for the current appointment.
			$existing_startTimePlusDuration = new DateTime($obj->startTime);
			$existing_startTimePlusDuration->add( new DateInterval( 'PT'.$obj->duration.'M') );
			$existing_startTime = new DateTime($obj->startTime);

			// first check to see if this slot chosen has an email matching the currently checked appointment($obj)
			// if the emails don't match, then this appointment($obj) will not collide with the selected time.
			if( $email == $obj->tutorID )
			{

				// if the requested end time is > existing start time AND requested startTime < existing start time
				if( $request_startTimePlusDuration > $existing_startTime && $request_startTime < $existing_startTime )
				{
					// collision
					$scheduleConflict = true;
				}
				// if the requested startTime is < existing end time AND requested start time > existing start time
				if( $request_startTime < $existing_startTimePlusDuration && $request_startTime > $existing_startTime )
				{
					// collision
					$scheduleConflict = true;
				}
			}
		}


		// if there is no conflict, insert these values into the Appointment table
		if( !$scheduleConflict )
		{
			echo '<br>'.$aptDateTime.'<br>';
			$result = $mysqli->query( "INSERT INTO Appointment (tutorID, clientID, startTime, duration, groupSize, firstVisit, comment, helpService)
				Values ('".$email."','".$studentID."','".$aptDateTime."',".$duration.",".$groupSize.",".$firstVisit.",'".$comment."','".$service."' )" );
			if( $result )
			{
				header( 'Location: '.$pathPrefix.'clientInfo.php#tab2' ); exit;
			}
			else
			{
				echo $appointmentDateTimeAndEmail;
				echo 'Something went wrong with the insert into the Appointment table.  A developer needs to look at the ClientBooking.php file';
			}
		}
		else
		{
			header( 'Location: '.$pathPrefix.'estudioMakeAppointment.php?conflict=' ); exit;
		}
?>


