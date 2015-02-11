<?php
	//  Calendar.php
	//  Purpose:  Handles a jQuery GET request when a user clicks on a date on the
	//		calendar displayed on the makeAppointment page.  Will display all available
	//		times for appointments on the selected day, and provide radio buttons for
	//		a user to select one of the available times to start their appointment.
	//	Input:  calendarday via GET -- the day clicked on the calendar.
	//	Output: a table of available appointment times and radio buttons to select a
	//			start time for an appointment.  Returned to the jQuery request from
	//			makeAppointment.php


session_start();
include_once("Config.php");

if( !isset( $_SESSION['user'] ) )
{
	header( 'Location: '.$pathPrefix.'estudioMakeAppointment.php' ); exit;
}

?>

<?php
$current_url = base64_encode("http://".$SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);


		// Class used to manage information of each (15 minute) interval between
		// a Tutor's shift start and shift end times.
		class Interval
		{
			public $intervalStart;
			public $intervalEnd;
			public $available;  // is interval is available for scheduling?
			public $tutorEmail;

			public function __construct($iStart, $iEnd, $iTutorEmail){
				$this->intervalStart = $iStart;
				$this->intervalEnd = $iEnd;
				$this->available = "true";
				$this->tutorEmail = $iTutorEmail;
			}
		}

		// get the selected day via GET array
		$day = $_GET['calendarday'];


		// select all of the times (tutor time shifts)
		// need to modify to only select those shifts on the selected week day
		$timesResult = $mysqli->query( "SELECT * FROM Times WHERE WeekDay= DAYOFWEEK('".$day."');" );

		// select all of the appointments already scheduled for the selected day
		$appResult = $mysqli->query( "SELECT * FROM Appointment WHERE DATE(StartTime) = STR_TO_DATE('".$day."', '%Y-%m-%d');" );

	if( $timesResult )
	{
		// only run these lines of code if there is a tutor scheduled to work on this day.
		// if num_rows == 0, there is no tutor scheduled.
		if( $timesResult->num_rows > 0 )
		{
			// for each 15 minute interval in the shifts, check if an appointment starts
			// or lasts through that start time.
			// If there is no conflicting appointment, display it as available to the
			// customer.

			while( $timeObj = $timesResult->fetch_object() )
			{
				// get the this startTime for a shift and put it into a string
				$dt = new DateTime($timeObj->StartTime);
				$shiftStartTime = $dt->format('H:i:s');

				// get the endTime for a shift and put it into a string
				$dt = new DateTime($timeObj->EndTime);
				$shiftEndTime = $dt->format('H:i:s');




				/*----POPULATE INTERVALS ARRAY!----*/
				// populate the intervals array with all 15 minute intervals between
				// shiftStart and shiftEnd
				$intervals = array();
				$currentIntervalStart = new DateTime($shiftStartTime);
				$shiftEndTime = new DateTime($shiftEndTime);
				$index = 0;
				while( $currentIntervalStart < $shiftEndTime )
				{
					$currentIntervalEnd = new DateTime($currentIntervalStart->format("H:i:s"));;

					$currentIntervalEnd->add( new DateInterval('PT15M') );
					$tutorEmailString = $timeObj->TutorEmail;
					echo $testvar;
					$intervals[$index] = new Interval( $currentIntervalStart,$currentIntervalEnd, $tutorEmailString );

					$currentIntervalStart = $currentIntervalEnd;
					$index = $index + 1;
				}
				/*----END POPULATION OF INTERVALS ARRAY----*/

				// check all previously scheduled appointments,
				// if there is no appointment conflicting with a 15 min interval
				// inside of the current shift, then the interval's 'available'
				// member variable should remain true.  Otherwise, set it to false.
				while( $appObj = $appResult->fetch_object() )
				{
					// get the start time of this appointment
					$dt = new DateTime($appObj->StartTime);
					$appStartTime = $dt->format('H:i:s');

					// for each 15 minute interval between shiftStart and shiftEnd,
					// check if the appStartTime+duration collides.
					// if not, keep the boolean value of the interval as TRUE
					// if so, change the boolean value of the interval to FALSE

					// ** CONDITIONS **
						// IF the appointment->TutorEmial == interval->TutorEmail
						// THEN
							// IF the appointment startTime == interval startTime
							// THEN interval is unavailable.
							// IF the appointment start time < interval starttime AND
							// the appointment startTime+duration > interval startTime
							// THEN the time interval is unavailable.
						// ELSE
							// Skip this one (it will remain available
					foreach( $intervals as $intervalObj )
					{
						$appointmentStartTime = new DateTime( $appStartTime );
						$intStartTime = new DateTime( $intervalObj->intervalStart->format("H:i:s") );
						$appDuration = new DateInterval( "PT".$appObj->Duration."M" );
						$appTutorEmail = $appObj->Email;
						$intervalTutorEmail = $intervalObj->tutorEmail;

						if( $appTutorEmail == $intervalTutorEmail )
						{

							if( $appointmentStartTime == $intStartTime )
							{
								$intervalObj->available = "false";
							}
							if( $appointmentStartTime < $intStartTime &&
								$appointmentStartTime->add($appDuration) > $intStartTime )
							{
								$intervalObj->available = "false";
							}
						}
					}

				}


				// after checking each shift, reset the pointer to row 0 of
				// the appointment query result for the next shift's check.
				$appResult->data_seek(0);

                echo '<table class="appointmentsTable" >';
				echo '<th> Appointment Start Time </th><th> Select </th>';
                foreach( $intervals as $obj )
                {
                    echo '<tr style="border:1px solid black">';

					// convert the military time stored in the database into AM/PM time for user display
					$militaryTimeString = $obj->intervalStart->format("H:i:s");

					// **INVARIANT:  $obj->tutorEmail has a row in the Tutor table with the email as the primary key
					/* Select from the tutor table where the tutorEmail = the one for this interval */
						// used to get the tutor name for display to the user
						// ****NOTE: Can be done more efficiently using a join in the initial appointments query
						// but done here for clarity for the sake of future programmers.  Changing this should probably
						// be done in the future during the maintenance phase of development.
					$thisTutorInformationResult = $mysqli->query( "SELECT * FROM Tutor WHERE Email = '".$obj->tutorEmail."';" );
					$tutorInfoObj = $thisTutorInformationResult->fetch_object();
                    echo '<td style="width: 500px; border:1px solid black">'.date( "g:i A", strtotime( $militaryTimeString) ).' -- '.$tutorInfoObj->tFirstName.' <br></td>';
					if( $obj->available == "false" ) {
						echo '<td style="border:1px solid black; background: #562878"></td>';
					}
					else {
						echo '<td style="border:1px solid black; width: 90px; background: #017338;">';
						// create and display a radio button for this interval (value is the date time and tutor email separated by spaces)
						echo '<input type="radio" form="clientBooking" name="startTime" value="'.$day.' '.$obj->intervalStart->format("H:i:s").' '.$obj->tutorEmail.'" /></td>';
					}
                    echo '</tr>';
                }
                echo '</table>';

			}
		}
		else
		{
			echo '<div style="position: relative; margin-left: 20px; font-size: 18pt; top: 50%;">';
			echo 'No tutors are working on this day. Sorry for the inconvenience.';
			echo '</div>';
		}

	}

		/*----- DEBUGGING OUTPUT OF SCHEDULED APPOINTMENTS -----*/
	/*		if( $appResult )
		{
			if( $appResult->num_rows == 0 ) { echo 'No appointments on this day'; }
			else {
				$appResult->data_seek(0);
				while( $obj = $appResult->fetch_object() )
				{
					echo '----------- Appointment found! ----------- <br>';
					echo 'Appointment startTime: '.$obj->StartTime.'<br>';
					echo 'Appointment duration:  '.$obj->Duration.'<br>';

				}

			}
		}

		echo '<div style="position: absolute; left: 50%; margin-left: 300px; font-size: 18pt; top: 50%;">You are looking at the info for: '.$day;
	*/
		/*----- END DEBUGGING OUTPUT -----*/

?>

