<?php
/*************************************************************
 *                  Historic Data Reporting                  *
 *************************************************************/
// This files provides info for each report by reading from 
// the database and formatting a table for output.  The file
// defines only the methods for the Current Reporting Section

// Includes
include('reports_helpers.php');
include('../Config.php');


// getHistoricOverall() function
// Inputs: 
//	$type - the type of date range (month, semester, year)
// Outputs:
//	A formatted and statistically accurate date is written to
//  the webpage from this method  
function getHistoricOverall($type) {
	require('../Config.php');

	$table = getCategories('Overall');

	// Get date range of data to be searched
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
			$stmt = prepareQuery($query, 'Could not retrieve Historic - Overall data');

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], ($thisData[0][0] == NULL) ? 0 : $thisData[0][0]);
			}
		}
	}

	// Print table to webpage
	printHistoricTable($table, $header);
}

// getHistoricService() function
// Inputs: 
//	$type - the type of date range (month, semester, year)
// Outputs:
//	A formatted and statistically accurate date is written to
//  the webpage from this method   
function getHistoricService($type) {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('Service');

	// Get date range of data to be searched
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
			$stmt = $prepareQuery($query, 'Count not retrieve Historic - Service data');

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		}
	}

	// Print table to webpage
	printHistoricTable($table, $header);
}

// getHistoricYear() function
// Inputs: 
//	$type - the type of date range (month, semester, year)
// Outputs:
//	A formatted and statistically accurate date is written to
//  the webpage from this method   
function getHistoricYear($type) {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('Year');

	// Get date range of data to be searched
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
			$stmt = prepareQuery($query, 'Could not retrieve Historic - Year data');

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		}
	}

	// Print table to webpage
	printHistoricTable($table, $header);
}

// getHistoricMajor() function
// Inputs: 
//	$type - the type of date range (month, semester, year)
// Outputs:
//	A formatted and statistically accurate date is written to
//  the webpage from this method  
function getHistoricMajor($type) {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('Major');

	// Get date range of data to be searched
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
			$stmt = prepareQuery($query, 'Could not retrieve Historic - Major data');

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		}
	}

	// Print table to webpage
	printHistoricTable($table, $header);
}

// getHistoricRequired() function
// Inputs: 
//	$type - the type of date range (month, semester, year)
// Outputs:
//	A formatted and statistically accurate date is written to
//  the webpage from this method   
function getHistoricRequired() {
	require('../Config.php');

	// TODO: Need to add required visit to appointment form.
}

// getHistoricFirstVisit() function
// Inputs: 
//	$type - the type of date range (month, semester, year)
// Outputs:
//	A formatted and statistically accurate date is written to
//  the webpage from this method   
function getHistoricFirstVisit($type) {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('First');

	// Get date range of data to be searched
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
			$stmt = prepareQuery($query, 'Could not retrieve Historic - First Visit data');
			

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		}
	}

	// Print table to webpage
	printHistoricTable($table, $header);
}

// getHistoricEnglish() function
// Inputs: 
//	$type - the type of date range (month, semester, year)
// Outputs:
//	A formatted and statistically accurate date is written to
//  the webpage from this method   
function getHistoricEnglish($type) {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('English');

	// Get date range of data to be searched
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
			$stmt = prepareQuery($query, 'Count not retrieve Historic - English data');

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		}
	}

	// Print table to webpage
	printHistoricTable($table, $header);
}

?>