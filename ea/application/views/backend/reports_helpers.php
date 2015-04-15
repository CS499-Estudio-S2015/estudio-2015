<?php
/*************************************************************
 *                       Helper Methods                      *
 *************************************************************/
// This file includes methods that help form the statistics
// for both types of searches, Historic and Current.  Methods 
// include printing tables with acquired data, \


// printCurrentTable() function
// Inputs: 
//	$table - the multideimensional array consisting of pulled data
//	$header - the header for the data table
// Outputs:
//	No return value, HTML is printed to the webpage
// Notes:  
//	The escape characters are used to nicely format the HTML output.
//  Includes some formatting to find percent change between two numbers.
function printCurrentTable($table, $header) {
	echo "<div class='report-table'>\n";
	echo "\t<table>\n";

	// Print Header Row
	echo "\t\t<tr>\n";
	foreach($header as $row) {
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

		// If previous month data is equal to 0 (prevent divide by 0 error)
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
			// TO-DO: CSS format red for neg change, green for pos change
			$change = (float)($arr[2] - $arr[1]) / $arr[1] * 100;
			echo "\t\t\t<td>" . number_format($change, 2, '.', '') . "</td>";
		}
		echo "\t\t</tr>\n";
	}

	echo "\t</table>\n";
	echo "</div>\n";
}

// printHistoricTable() function
// Inputs: 
//	$table - the multideimensional array consisting of pulled data
//	$header - the header for the data table
// Outputs:
//	No return value, HTML is printed to the webpage
// Notes:  
//	The escape characters are used to nicely format the HTML output
function printHistoricTable($table, $header) {
	echo "<div class='report-table'>\n";
	echo "\t<table>\n";

	// Print Header Row
	echo "\t\t<tr>\n";
	foreach($header as $head) {
		echo "\t\t\t<td>" . $head . "</td>\n";
	}
	echo "\t\t</tr>\n";

	foreach ($table as $row) {
		echo "\t\t<tr>\n";
		foreach ($row as $data) {
			echo "\t\t\t<td>" . $data . "</td>\n";
		}

		echo "\t\t</tr>\n";
	}

	echo "\t</table>\n";
	echo "</div>\n";
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
function getHistoricHeader($type, $dates) {
	$header = array();
	array_push($header, '');

	foreach ($dates as $date) {
		list($startYear, $startMonth, $startDay) = explode("-", $date[0]);
		list($endYear, $endMonth, $endDay) = explode("-", $date[1]);
		switch ($type) {
			case "month":
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

// getDatesFromType() function
// Inputs: 
//	$type - the type of date 
// Outputs:
//	
// Notes:  
//	
function getDatesFromType($type) {
	// Get current date
	date_default_timezone_set('America/Louisville');
	$currentDate = date('j n Y', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
	list($day, $month, $year) = explode(" ", $currentDate);

	$dates = array();
	switch ($type) {
		case "month":
			for ($i = 0; $i < 6; $i = $i + 1) {
				$start = date('Y-m-d H:i:s', mktime(0, 0, 0, $month - $i, 1, $year));
				$end = date('Y-m-d H:i:s', mktime(23, 59, 59, ($month - $i) + 1, 0, $year));

				$temp = array();
				array_push($temp, $start);
				array_push($temp, $end);

				array_push($dates, $temp);
			}
			break;
		case "semester":
			$offset = 0;
			for ($i = 0; $i < 6; $i = $i + 1) {
				if ($month >= 1 && $month <= 6) {
					//echo "Current date is Spring\n";
					$offset += $i % 2;
					if ($i % 2 == 0) {
						//echo "Spring\n";
						$start = date('Y-m-d H:i:s', mktime(0, 0, 0, 1, 1, $year - $offset));
						$end = date('Y-m-d H:i:s', mktime(0, 0, 0, 7, 1, $year - $offset));
					} else {
						//echo "Fall\n";
						$start = date('Y-m-d H:i:s', mktime(0, 0, 0, 7, 1, $year - $offset));
						$end = date('Y-m-d H:i:s', mktime(0, 0, 0, 1, 1, ($year - $offset) + 1));
					}
				} else {
					// echo "Current date is Fall\n";
					if ($i % 2 == 0) {
						// echo "Fall\n";
						$start = date('Y-m-d H:i:s', mktime(0, 0, 0, 7, 1, $year));
						$end = date('Y-m-d H:i:s', mktime(0, 0, 0, 1, 1, $year));
					} else {
						// echo "Spring\n";
						$start = date('Y-m-d H:i:s', mktime(0, 0, 0, 1, 1, $year));
						$end = date('Y-m-d H:i:s', mktime(0, 0, 0, 7, 1, $year));		
					}
				}

				$temp = array();
				array_push($temp, $start);
				array_push($temp, $end);

				array_push($dates, $temp);
			}
			break;
		case "year":
			for ($i = 0; $i < 3; $i = $i + 1) {
				if ($month <= 12 && $month >= 9) {
					//echo "Fall";
					$start = date('Y-m-d H:i:s', mktime(0, 0, 0, 8, 1, $year - $i));
					$end = date('Y-m-d H:i:s', mktime(0, 0, 0, 6, 1, ($year - $i) + 1));
				}

				if ($month <= 8 && $month >= 1) {
					//echo "Spring";
					$start = date('Y-m-d H:i:s', mktime(0, 0, 0, 8, 1, $year - ($i + 1)));
					$end = date('Y-m-d H:i:s', mktime(0, 0, 0, 6, 1, $year - $i));
				}
				
				$temp = array();
				array_push($temp, $start);
				array_push($temp, $end);

				array_push($dates, $temp);
			}
			
			break;
		default:
			break;
	}

	// Return array to use for processing
	//var_dump($dates);
	return $dates;
}

// getCategories() function
// Inputs: 
//	$type - the type of category
// Outputs:
//	
// Notes:  
//	
function getCategories($type) {
	$table = array();
	switch ($type) {
		case 'Overall':
			array_push($table, array('Num. of Appointments'));
			array_push($table, array('Num. of Participants'));

			$stmt = false;	
			break;

		case 'Service':
			// 
			$query = "SELECT name FROM ea_services";
			$stmt = prepareQuery($query, "Could not prepare Service Category");
			break;

		case 'Year':
/*
			array_push($table, array('Freshman'));
			array_push($table, array('Sophmore'));
			array_push($table, array('Junior'));
			array_push($table, array('Senior'));
			array_push($table, array('Graduate Student'));
			array_push($table, array('Faculty'));
			array_push($table, array('Other'));
*/
			$query = "SELECT DISTINCT year FROM Client";
			$stmt = prepareQuery($query, "Could not prepare Year Category");
			break;

		case 'Major':
/*
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
*/
			$query = "SELECT DISTINCT major FROM Client";
			$stmt = prepareQuery($query, "Could not prepare Major Category");
			break;

		case 'English':
		case 'Required':
		case 'First':
			array_push($table, array('Yes'));
			array_push($table, array('No'));

			$stmt = false;
			break;

		case 'Tutors':
			$query = "SELECT DISTINCT first_name, last_name FROM ea_users WHERE id_roles = 2";
			$stmt = prepareQuery($query, "Could not prepare Tutors Category");
			break;

		default:
			$stmt = false;
			break;
	}

	// Fetch all the rows from the executed statement and 
	// create a two-dimensional array of categories if
	// the statement executed
	if ($stmt) {
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			if ($type == 'Tutors') {
				array_push($table, array($row[0], $row[1]));
			} else {
				array_push($table, array($row[0]));
			}
			
    	}
	}
	

	return $table;
}

// prepareQuery() function
// Inputs: 
//	$query - the SQL query to prepare
//	$err_message - error message string to print with stack trace
// Outputs:
//	$stmt - a PDO prepared statement object where results can be fetched
function prepareQuery($query, $err_message) {
	require('../Config.php');

	try {
		$stmt = $db->prepare($query);
		$stmt->execute();
	} catch (Exception $e) {
		echo $err_message . "\n";
		echo $e;
		exit;
	}

	return $stmt;
}


?>