<?php
include('reports_helpers.php');

function getHistoricHeader($type, $dates) {
	$header = array();
	array_push($header, '');

	foreach ($dates as $date) {
		list($startYear, $startMonth, $startDay) = explode("-", $date[0]);
		list($endYear, $endMonth, $endDay) = explode("-", $date[1]);
		switch ($type) {
			case "month":
				// TO-DO: Format Month for abbreviation
				$month = date('M', mktime(0, 0, 0, $startMonth, 1, $startYear));
				$head = $month . " " . $startYear;
				break;
			case "semester":
				$semester = "";
				if ($startMonth >= 1 && $startMonth <= 6) {
					$semester = "Spring ";
				} else {
					$semester = "Fall ";
				}

				$head = $semester . $startYear;
				break;
			case "year":
				$head = $startYear . " - " . $endYear;
				break;
			default:
				break;
		}
		
		array_push($header, $head);
	}

	return $header;
}

/************************************
 *             Historic             *
 ************************************/
function getHistoricOverall($type) {
	require('../Config.php');

	$table = array();
	array_push($table, array('Num. of Appointments'));
	array_push($table, array('Num. of Participants'));

	$dates = getDatesFromType($type);

	// Header Generation
	$header = getHistoricHeader($type, $dates);
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1) {

		// Loop to get category data across each date
		foreach($dates as $date) {
			// Query String
			// TODO: still need to add client creation date
			switch ($row) {
				case 0:
					$query = "SELECT COUNT(A.apptID) AS Ctr
					  		  FROM Appointment AS A
					  		  WHERE A.startTime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "'";
					break;
				case 1:
					$query = "SELECT SUM(A.groupSize) AS Sum
					  		  FROM Appointment AS A
					  		  WHERE A.startTime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "'";
					break;
				default:
					break;
			}

			// Try to execute query in database; print exception if failure		        
			try {
				$stmt = $db->prepare($query);
				$stmt->execute();
			} catch (Exception $e) {
				echo "Count not retrieve Historic - Overall data\n";
				echo $e;
				exit;
			}

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], ($thisData[0][0] == NULL) ? 0 : $thisData[0][0]);
			}
		}
	}


	printHistoricTable($table, $header);
}

function getHistoricService($type) {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = array();
	array_push($table, array('Writing Help'));
	array_push($table, array('Writing Help for ESL Student'));
	array_push($table, array('Oral Presentation Help'));
	array_push($table, array('Digital Media Help'));
	array_push($table, array('Thesis or Dissertation Help'));
	array_push($table, array('EGR201 Help'));
	array_push($table, array('Other'));

	$dates = getDatesFromType($type);

	// Header Generation
	$header = getHistoricHeader($type, $dates);
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1) {

		// Loop to get category data across each date
		foreach($dates as $date) {
			// Query String
			$query = "SELECT COUNT(A.apptID) AS Ctr
					  FROM Appointment AS A
					  WHERE A.startTime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "' AND
					        helpService = '" . $table[$row][0] . "'";

			// Try to execute query in database; print exception if failure		        
			try {
				$stmt = $db->prepare($query);
				$stmt->execute();
			} catch (Exception $e) {
				echo "Count not retrieve Historic - Service data\n";
				echo $e;
				exit;
			}

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		}
	}

	printHistoricTable($table, $header);
}

function getHistoricYear($type) {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = array();
	array_push($table, array('Freshman'));
	array_push($table, array('Sophmore'));
	array_push($table, array('Junior'));
	array_push($table, array('Senior'));
	array_push($table, array('Graduate Student'));
	array_push($table, array('Faculty'));
	array_push($table, array('Other'));

	$dates = getDatesFromType($type);

	// Header Generation
	$header = getHistoricHeader($type, $dates);
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1) {
		// Loop to get category data across each date
		foreach($dates as $date) {
			// Query String
			$query = "SELECT COUNT(A.apptID) AS Ctr
					  FROM Appointment AS A
					  	   INNER JOIN Client AS C
					  	   ON A.clientID = C.id
					  WHERE A.startTime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "' AND
					        C.year = '" . $table[$row][0] . "'";

			// Try to execute query in database; print exception if failure		        
			try {
				$stmt = $db->prepare($query);
				$stmt->execute();
			} catch (Exception $e) {
				echo "Count not retrieve Historic - Year data\n";
				echo $e;
				exit;
			}

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		}
	}

	printHistoricTable($table, $header);
}

function getHistoricMajor($type) {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = array();
	array_push($table, array('Biosystems and Agricultural Engineering'));
	array_push($table, array('Chemical Engineering'));
	array_push($table, array('Civil Engineering'));
	array_push($table, array('Computer Engineering'));
	array_push($table, array('Computer Science'));
	array_push($table, array('Electrical Engineering'));
	array_push($table, array('Masters in Engineering'));
	array_push($table, array('Manufacturing Systems Engineering'));
	array_push($table, array('Materials Science and Engineering'));
	array_push($table, array('Mechanical Engineering'));
	array_push($table, array('Mining Engineering'));
	array_push($table, array('Undeclared'));
	array_push($table, array('Other'));

	$dates = getDatesFromType($type);

	// Header Generation
	$header = getHistoricHeader($type, $dates);
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1) {
		
		// Loop to get category data across each date
		foreach($dates as $date) {
			// Query String
			$query = "SELECT COUNT(A.apptID) AS Ctr
					  FROM Appointment AS A
					  	   INNER JOIN Client AS C
					  	   ON A.clientID = C.id
					  WHERE A.startTime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "' AND
					        C.major = '" . $table[$row][0] . "'";

			// Try to execute query in database; print exception if failure		        
			try {
				$stmt = $db->prepare($query);
				$stmt->execute();
			} catch (Exception $e) {
				echo "Count not retrieve Historic - Major data\n";
				echo $e;
				exit;
			}

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		}
	}

	printHistoricTable($table, $header);
}

function getHistoricRequired() {
	require('../Config.php');

	// TODO: Need to add required visit to appointment form.
}

function getHistoricFirstVisit($type) {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = array();
	array_push($table, array('Yes'));
	array_push($table, array('No'));
		
	$dates = getDatesFromType($type);

	// Header Generation
	$header = getHistoricHeader($type, $dates);
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1) {
		// Convert category string to number for DB read 
		// (Yes = 1, No = 0)
		if ($row == 0) {
			$bit = 1;
		} else {
			$bit = 0;
		}


		// Loop to get category data across each date
		foreach($dates as $date) {
			// Query String
			$query = "SELECT COUNT(A.apptID) AS Ctr
					  FROM Appointment AS A
					  WHERE A.startTime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "' AND
					        A.firstVisit = " . $bit;

			// Try to execute query in database; print exception if failure		        
			try {
				$stmt = $db->prepare($query);
				$stmt->execute();
			} catch (Exception $e) {
				echo "Count not retrieve Historic - First Visit data\n";
				echo $e;
				exit;
			}

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		}
	}

	printHistoricTable($table, $header);
}

function getHistoricEnglish($type) {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = array();
	array_push($table, array('Yes'));
	array_push($table, array('No'));
		
	$dates = getDatesFromType($type);

	// Header Generation
	$header = getHistoricHeader($type, $dates);
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1) {
		// Convert category string to number for DB read 
		// (Yes = 1, No = 0)
		if ($row == 0) {
			$bit = 0;
		} else {
			$bit = 1;
		}


		// Loop to get category data across each date
		foreach($dates as $date) {
			// Query String
			$query = "SELECT COUNT(A.apptID) AS Ctr
					  FROM Appointment AS A
					  		INNER JOIN Client AS C
					  		ON A.clientID = C.id
					  WHERE A.startTime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "' AND
					        C.english = " . $bit;

			// Try to execute query in database; print exception if failure		        
			try {
				$stmt = $db->prepare($query);
				$stmt->execute();
			} catch (Exception $e) {
				echo "Count not retrieve Historic - English data\n";
				echo $e;
				exit;
			}

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		}
	}

	printHistoricTable($table, $header);
}

?>