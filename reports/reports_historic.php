<?php
/*************************************************************
 *                  Historic Data Reporting                  *
 *************************************************************/
include('reports_helpers.php');


// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
function getHistoricOverall($type) {
	require('../Config.php');

	$table = getCategories('Overall');

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


	printHistoricTable($table, $header);
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
function getHistoricService($type) {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('Service');

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

	printHistoricTable($table, $header);
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
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

	printHistoricTable($table, $header);
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
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

	printHistoricTable($table, $header);
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
function getHistoricRequired() {
	require('../Config.php');

	// TODO: Need to add required visit to appointment form.
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
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

	printHistoricTable($table, $header);
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
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

	printHistoricTable($table, $header);
}

?>