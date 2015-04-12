<?php
// File Description

// Constants
include('reports_helpers.php');

/*******************************************************
 *                        Current                      *
 *******************************************************/
function getCurrentOverall() {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	$table = array();
	array_push($table, array('Num. of Appointments'));
	array_push($table, array('Num. of Participants'));
	$i = 1;

	// Loop to get current and previous month data
	while ($i >= 0)
	{
		// Get the date needed for database read
		$date = date('n Y', mktime(0, 0, 0, date('m') - $i, 1, date('Y')));
		list($month, $year) = explode(" ", $date);

		// Query String 
		// TODO: still need to add client creation date
		$query = "SELECT COUNT(A.apptID) AS Ctr,
	   					 SUM(A.groupSize) AS Sum
				  FROM Appointment AS A
				  WHERE MONTH(A.startTime) = " . $month . " AND
				        YEAR(A.startTime) = " . $year;

		// Try to execute query in database; print exception if failure		        
		try {
			$stmt = $db->prepare($query);
			$stmt->execute();
		} catch (Exception $e) {
			echo "Count not retrieve Current - Overall data\n";
			echo $e;
			exit;
		}

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

function getCurrentService() {
	require('../Config.php');

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
			$query = "SELECT COUNT(id) AS Ctr
					  FROM ea_appointments
					  WHERE MONTH(start_datetime) = " . $month . " AND
					  		YEAR(start_datetime) = " . $year . " AND
					  		"
/*
			$query = "SELECT COUNT(A.apptID) AS Ctr
					  FROM Appointment AS A
					  WHERE MONTH(A.startTime) = " . $month . " AND
					        YEAR(A.startTime) = " . $year . " AND
					        helpService = '" . $table[$row][0] . "'";
 */

			// Try to execute query in database; print exception if failure		        
			$stmt = prepareQuery($query, "Count not retrieve Current - Service data");
		
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

function getCurrentYear() {
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
			try {
				$stmt = $db->prepare($query);
				$stmt->execute();
			} catch (Exception $e) {
				echo "Count not retrieve Current - Academic Year data\n";
				echo $e;
				exit;
			}

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
			try {
				$stmt = $db->prepare($query);
				$stmt->execute();
			} catch (Exception $e) {
				echo "Count not retrieve Current - Major data\n";
				echo $e;
				exit;
			}

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

function getCurrentRequired() {
	require('../Config.php');

	// TODO: Need to add required visit to appointment form.
}

function getCurrentFirstVisit() {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = array();
	array_push($table, array('Yes'));
	array_push($table, array('No'));
	
	
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
			$query = "SELECT COUNT(A.apptID) AS Ctr
					  FROM Appointment AS A
					  WHERE MONTH(A.startTime) = " . $month . " AND
					        YEAR(A.startTime) = " . $year . " AND
					        A.firstVisit = " . $bit;

			// Try to execute query in database; print exception if failure		        
			try {
				$stmt = $db->prepare($query);
				$stmt->execute();
			} catch (Exception $e) {
				echo "Count not retrieve Current - First Visit data\n";
				echo $e;
				exit;
			}

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

function getCurrentEnglish() {
	require('../Config.php');

	// Set up two-dimensional array to hold data for output
	// Makes secondary array for each category
	$table = array();
	array_push($table, array('Yes'));
	array_push($table, array('No'));
	
	
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
			try {
				$stmt = $db->prepare($query);
				$stmt->execute();
			} catch (Exception $e) {
				echo "Count not retrieve Current - English data\n";
				echo $e;
				exit;
			}

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




?>