<?php
// Helpers
//
function printTable($rows) {
	//var_dump($rows);
	foreach($rows as $row) {
		echo "<tr>";
		for ($i = 0; $i < count($row) / 2; $i++) {
			echo "<td>" . $row[$i] . "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}

// SQL Reads
//
function getAllApptByYear() {
	require('Config.php');
	$query = "SELECT YEAR(startTime) AS Year, COUNT(apptID) AS Count
			  FROM Appointment
			  GROUP BY YEAR(startTime)";

	try {
		$stmt = $db->prepare($query);
		$stmt->execute();
	} catch (Exception $e) {
		echo "Could not retrieve Appt By Year data";
		echo $e;
		exit;
	}

	if ($stmt) {
		$table = $stmt->fetchAll();
	}

	echo '<div class="report-table">';
	echo "<table>";
	echo "<tr>";
	echo "<td>Academic Year</td>";
	echo "<td>Number of Appointments</td>";
	echo "</tr>";
	printTable($table);
	echo "</div>\n";
}

function getApptFromMajorByMonth() {
	require('Config.php');
	$query = "SELECT Client.Major, COUNT(Appointment.apptID) AS Count
		 	  FROM Appointment RIGHT JOIN Client ON Appointment.clientID = Client.id
		 	  WHERE MONTH(Appointment.startTime) = ?
		 	  GROUP BY Month(Appointment.startTime), Client.Major";


	try {
		$stmt = $db->prepare($query);
		$stmt->execute();
	} catch (Exception $e) {
		echo "Could not retrieve Appointment/Major by month data\n";
		echo $e;
		exit;
	}

	if ($stmt) {
		$table = $stmt->fetchAll();
	}

	echo '<div class="report-table">';
	echo "<table>";
	printTable($table);
	echo "</div>\n";
}
?>