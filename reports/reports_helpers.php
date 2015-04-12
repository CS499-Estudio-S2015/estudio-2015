<?php


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

// Stub for Historic Print
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
						$end = date('Y-m-d H:i:s', mktime(0, 0, 0, 1, 1, $year - ($offset + 1)));
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

function getCategories($type) {
	switch ($type) {
		case 'Service':
			$table = array();
			
			// 
			$query = "SELECT name FROM ea_services";
			$stmt = prepareQuery($query, "Could not prepare Service Category");

			// 
			while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
				array_push($table, array($row[0]));
		    }

			break;

		default:
			break;
	}

	return $table;
}

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