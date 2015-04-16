<?php
/*************************************************************
 *                  Current Data Reporting                   *
 *************************************************************/
// This  
//
// Includes
include('reports_helpers.php');
//include('../../../../Config.php');


// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
//
function getCurrentOverall() {
	// Set up two-dimensional array to hold data for output
	$table = getCategories('Overall');
	
	$i = 1;

	// Loop to get current and previous month data
	while ($i >= 0)
	{
		// Get the date needed for database read
		$date = date('n Y', mktime(0, 0, 0, date('m') - $i, 1, date('Y')));
		list($month, $year) = explode(" ", $date);

		// Query String 
		// TODO: still need to add client creation date
		$query = "SELECT COUNT(A.id) AS Ctr,
	   					 SUM(A.group_size) AS Sum
				  FROM ea_appointments AS A
				  WHERE MONTH(A.start_datetime) = " . $month . " AND
				        YEAR(A.start_datetime) = " . $year;

		// Try to execute query in database; print exception if failure		        
		$stmt = prepareQuery($query, 'Could not retrieve Current - Overall data');

		// If valid query execution, return data and insert into table array
		// in the proper location
		if ($stmt) {
			$thisData = $stmt->fetchAll();
			array_push($table[0], $thisData[0][0]);
			array_push($table[1], $thisData[0][1]);
		}
	
		// Increment counter to find next date
		$i = $i - 1;
	}


	// Define table header and print table
	$head = array('', 'Last Month', 'This Month', '% Change');
	printCurrentTable($table, $head);
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
//
function getCurrentService() {
	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('Service');
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1)
	{
		// Loop to get current and previous month data
		$i = 1;
		while ($i >= 0)
		{
			// Get the date needed for database read
			$date = date('n Y', mktime(0, 0, 0, date('m') - $i, 1, date('Y')));
			list($month, $year) = explode(" ", $date);

			// Query String
			$query = "SELECT COUNT(A.id) AS Ctr
					  FROM ea_appointments AS A
					  	   RIGHT JOIN ea_services AS S ON A.id_services = S.id
					  WHERE MONTH(A.start_datetime) = " . $month . " AND
					  		YEAR(A.start_datetime) = " . $year . " AND
					  		S.name = '" . $table[$row][0] . "'";

			// Try to execute query in database; print exception if failure		        
			$stmt = prepareQuery($query, "Could not retrieve Current - Service data");
		
			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		
			// Increment counter to find next date
			$i = $i - 1;
		}
	}

	// Define table header and print table
	$head = array('', 'Last Month', 'This Month', '% Change');
	printCurrentTable($table, $head);
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
//
function getCurrentYear() {
	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('Year');
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1)
	{
		// Loop to get current and previous month data
		$i = 1;
		while ($i >= 0)
		{
			// Get the date needed for database read
			$date = date('n Y', mktime(0, 0, 0, date('m') - $i, 1, date('Y')));
			list($month, $year) = explode(" ", $date);

			// Query String 
			$query = "SELECT COUNT(A.apptID) AS Ctr
					  FROM Appointment AS A
					  		INNER JOIN Client AS C
					  		ON A.clientID = C.id
					  WHERE MONTH(A.startTime) = " . $month . " AND
					        YEAR(A.startTime) = " . $year . " AND
					        C.year = '" . $table[$row][0] . "'";

			// Try to execute query in database; print exception if failure		        
			$stmt = prepareQuery($query, 'Could not retrieve Current - Academic Year data');

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		
			// Increment counter to find next date
			$i = $i - 1;
		}
	}

	// Define table header and print table
	$head = array('', 'Last Month', 'This Month', '% Change');
	printCurrentTable($table, $head);
}

function getCurrentMajor() {
	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('Major');
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1)
	{
		// Loop to get current and previous month data
		$i = 1;
		while ($i >= 0)
		{
			// Get the date needed for database read
			$date = date('n Y', mktime(0, 0, 0, date('m') - $i, 1, date('Y')));
			list($month, $year) = explode(" ", $date);

			// Query String 
			$query = "SELECT COUNT(A.apptID) AS Ctr
					  FROM Appointment AS A
					  		INNER JOIN Client AS C
					  		ON A.clientID = C.id
					  WHERE MONTH(A.startTime) = " . $month . " AND
					        YEAR(A.startTime) = " . $year . " AND
					        C.major = '" . $table[$row][0] . "'";

			// Try to execute query in database; print exception if failure		        
			$stmt = prepareQuery($query, 'Could not retrieve Current - Major Year data');

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		
			// Increment counter to find next date
			$i = $i - 1;
		}
	}

	// Define table header and print table
	$head = array('', 'Last Month', 'This Month', '% Change');
	printCurrentTable($table, $head);
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
//
function getCurrentRequired() {
	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('Required');
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1)
	{
		// Convert category string to number for DB read 
		// (Yes = 1, No = 0)
		if ($row == 0) {
			$bit = 1;
		} else {
			$bit = 0;
		}

		// Loop to get current and previous month data
		$i = 1;
		while ($i >= 0)
		{
			// Get the date needed for database read
			$date = date('n Y', mktime(0, 0, 0, date('m') - $i, 1, date('Y')));
			list($month, $year) = explode(" ", $date);

			// Query String 
			$query = "SELECT COUNT(A.id) AS Ctr
					  FROM ea_appointments AS A
					  WHERE MONTH(A.start_datetime) = " . $month . " AND
					        YEAR(A.start_datetime) = " . $year . " AND
					        A.first_visit = " . $bit;

			// Try to execute query in database; print exception if failure		        
			$stmt = prepareQuery($query, 'Could not retrieve Current - First Visit data');

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		
			// Increment counter to find next date
			$i = $i - 1;
		}
	}

	// Define table header and print table
	$head = array('', 'Last Month', 'This Month', '% Change');
	printCurrentTable($table, $head);
}


// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
//
function getCurrentFirstVisit() {
	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('First');
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1)
	{
		// Convert category string to number for DB read 
		// (Yes = 1, No = 0)
		if ($row == 0) {
			$bit = 1;
		} else {
			$bit = 0;
		}

		// Loop to get current and previous month data
		$i = 1;
		while ($i >= 0)
		{
			// Get the date needed for database read
			$date = date('n Y', mktime(0, 0, 0, date('m') - $i, 1, date('Y')));
			list($month, $year) = explode(" ", $date);

			// Query String 
			$query = "SELECT COUNT(A.id) AS Ctr
					  FROM ea_appointments AS A
					  WHERE MONTH(A.start_datetime) = " . $month . " AND
					        YEAR(A.start_datetime) = " . $year . " AND
					        A.first_visit = " . $bit;

			// Try to execute query in database; print exception if failure		        
			$stmt = prepareQuery($query, 'Could not retrieve Current - First Visit data');

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		
			// Increment counter to find next date
			$i = $i - 1;
		}
	}

	// Define table header and print table
	$head = array('', 'Last Month', 'This Month', '% Change');
	printCurrentTable($table, $head);
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
//
function getCurrentEnglish() {
	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('English');
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1)
	{
		// Convert category string to number for DB read 
		// (Yes = 1, No = 0)
		if ($row == 0) {
			$bit = 0;
		} else {
			$bit = 1;
		}

		// Loop to get current and previous month data
		$i = 1;
		while ($i >= 0)
		{
			// Get the date needed for database read
			$date = date('n Y', mktime(0, 0, 0, date('m') - $i, 1, date('Y')));
			list($month, $year) = explode(" ", $date);

			// Query String 
			$query = "SELECT COUNT(A.apptID) AS Ctr
					  FROM Appointment AS A
					  	   INNER JOIN Client AS C
					  	   ON A.clientID = C.id
					  WHERE MONTH(A.startTime) = " . $month . " AND
					        YEAR(A.startTime) = " . $year . " AND
					        C.english = " . $bit;

			// Try to execute query in database; print exception if failure		        
			$stmt = prepareQuery($query, 'Count not retrieve Current - English data');

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		
			// Increment counter to find next date
			$i = $i - 1;
		}
	}

	// Define table header and print table
	$head = array('', 'Last Month', 'This Month', '% Change');
	printCurrentTable($table, $head);
}

//
//
//
function getCurrentTutors() {
	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('Tutors');
	
	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1)
	{

		// Pop last name from the current table[$row] for future formatting change
		$last_name = array_pop($table[$row]);

		// Loop to get current and previous month data
		$i = 1;
		while ($i >= 0)
		{
			// Get the date needed for database read
			$date = date('n Y', mktime(0, 0, 0, date('m') - $i, 1, date('Y')));
			list($month, $year) = explode(" ", $date);

			// Query String
			$query = "SELECT COUNT(A.id) AS Ctr
					  FROM ea_appointments AS A
					  	   INNER JOIN ea_users AS U ON A.id_users_provider = U.id
					  WHERE MONTH(A.start_datetime) = " . $month . " AND
					  		YEAR(A.start_datetime) = " . $year . " AND
					  		U.first_name = '" . $table[$row][0] . "' AND
					  		U.last_name = '" . $last_name . "'";

			// Try to execute query in database; print exception if failure		        
			$stmt = prepareQuery($query, "Could not retrieve Current - Tutors data");
		
			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		
			// Increment counter to find next date
			$i = $i - 1;
		}

		// Append last name to first for proper formatting
		$table[$row][0] .= (" " . $last_name);
	}

	// Define table header and print table
	$head = array('', 'Last Month', 'This Month', '% Change');
	printCurrentTable($table, $head);
}


/*************************************************************
 *                  Historic Data Reporting                  *
 *************************************************************/


// getHistoricOverall() function
// Inputs: 
//	$type - the type of date range
// Outputs:
//	
// Notes:  
function getHistoricOverall($type) {
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
					$query = "SELECT COUNT(A.id) AS Ctr
					  		  FROM ea_appointments AS A
					  		  WHERE A.start_datetime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "'";
					break;
				case 1:
					$query = "SELECT SUM(A.group_size) AS Sum
					  		  FROM ea_appointments AS A
					  		  WHERE A.start_datetime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "'";
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

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
function getHistoricService($type) {
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
			$query = "SELECT COUNT(A.id) AS Ctr
					  FROM ea_appointments AS A
					  	   RIGHT JOIN ea_services AS S ON A.id_services = S.id
					  WHERE A.start_datetime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "' AND
					        S.name = '" . $table[$row][0] . "'";

			// Try to execute query in database; print exception if failure		        
			$stmt = prepareQuery($query, 'Could not retrieve Historic - Service data');

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

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
function getHistoricYear($type) {
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

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
function getHistoricMajor($type) {
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

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
function getHistoricRequired($type) {
	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('Required');

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
			$query = "SELECT COUNT(A.id) AS Ctr
					  FROM ea_appointments AS A
					  WHERE A.start_datetime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "' AND
					        A.req_visit = " . $bit;

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

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
function getHistoricFirstVisit($type) {
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
			$query = "SELECT COUNT(A.id) AS Ctr
					  FROM ea_appointments AS A
					  WHERE A.start_datetime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "' AND
					        A.first_visit = " . $bit;

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

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
function getHistoricEnglish($type) {
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
			$stmt = prepareQuery($query, 'Could not retrieve Historic - English data');

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

//
//
// TO-DO
function getHistoricTutors($type) {
	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = getCategories('Tutors');

	// Get date range of data to be searched
	$dates = getDatesFromType($type);

	// Header Generation
	$header = getHistoricHeader($type, $dates);

	// Loop to get data for each category
	for ($row = 0; $row < count($table); $row = $row + 1) {

		// Pop last name from the current table[$row] for future formatting change
		$last_name = array_pop($table[$row]);

		// Loop to get category data across each date
		foreach($dates as $date) {
			// Query String
			$query = "SELECT COUNT(A.id) AS Ctr
					  FROM ea_appointments AS A
					  	   INNER JOIN ea_users AS U ON A.id_users_provider = U.id
					  WHERE A.start_datetime BETWEEN '" . $date[0] . "' AND '" . $date[1] . "' AND
					  		U.first_name = '" . $table[$row][0] . "' AND
					  		U.last_name = '" . $last_name . "'";

			// Try to execute query in database; print exception if failure		        
			$stmt = prepareQuery($query, 'Could not retrieve Historic - Tutor data');

			// If valid query execution, return data and insert into table array
			// in the proper location
			if ($stmt) {
				$thisData = $stmt->fetchAll();
				array_push($table[$row], $thisData[0][0]);
			}
		}

		// Append last name to first for proper formatting
		$table[$row][0] .= (" " . $last_name);
	}

	

	// Print table to webpage
	printHistoricTable($table, $header);
}

?>