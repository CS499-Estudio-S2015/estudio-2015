<?php
// File Description

// Constants


/*******************************************************
 *                     Helper Methods                  *
 *******************************************************/
// printCurrentTable() function
// Inputs: 
//	$table - the multideimensional array consisting of correct data
//	$head - 
// Outputs:
//	No return value, HTML is printed to the webpage
// Notes:  
//	The escape characters are used to nicely format the HTML output
function printCurrentTable($table, $head) {
	echo "<div class='report-table'>\n";
	echo "\t<table>\n";

	// Print Header Row
	echo "\t\t<tr>\n";
	foreach($head as $row) {
		echo "\t\t\t<td>" . $row . "</td>\n";
	}
	echo "\t\t</tr>\n";

	// Print all data rows of the table
	foreach($table as $arr) {
		echo "\t\t<tr>\n";
		// Print data for each child array
		foreach($arr as $data) {
			echo "\t\t\t<td>" . $data . "</td>\n";
		}

		// If previous data is equal to 0 (prevent divide by 0 error)
		if ($arr[1] == 0)
		{
			// And current data is not 0
			if ($arr[2] != 0) {
				echo "\t\t\t<td>100.00</td>";	// Print 100 gain
			}
			// Otherwise, both data points are 0
			else {
				echo "\t\t\t<td>0.00</td>";		// Print 0 gain
			}
		}
		// Otherwise, can divide to find percent change
		else
		{
			// TODO: CSS format red for neg change, green for pos change
			$change = (float)($arr[2] - $arr[1]) / $arr[1] * 100;
			echo "\t\t\t<td>" . number_format($change, 2, '.', '') . "</td>";
		}
		echo "\t\t</tr>\n";
	}

	echo "\t</table>\n";
	echo "</div>\n";
}


/*******************************************************
 *                        Current                      *
 *******************************************************/
function getCurrentOverall() {
	require('Config.php');

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
	require('Config.php');

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

			// Query String (TODO: still need to add client creation date)
			$query = "SELECT COUNT(A.apptID) AS Ctr
					  FROM Appointment AS A
					  WHERE MONTH(A.startTime) = " . $month . " AND
					        YEAR(A.startTime) = " . $year . " AND
					        helpService = '" . $table[$row][0] . "'";

			// Try to execute query in database; print exception if failure		        
			try {
				$stmt = $db->prepare($query);
				$stmt->execute();
			} catch (Exception $e) {
				echo "Count not retrieve Current - Service data\n";
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

function getCurrentYear() {
	require('Config.php');

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

			// Query String (TODO: still need to add client creation date)
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
	require('Config.php');

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

			// Query String (TODO: still need to add client creation date)
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
	require('Config.php');

	// TODO: Need to add required visit to form.
}

function getCurrentFirstVisit() {
	require('Config.php');

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

			// Query String (TODO: still need to add client creation date)
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
	require('Config.php');

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

			// Query String (TODO: still need to add client creation date)
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


/************************************
 *             Historic             *
 ************************************/


?>