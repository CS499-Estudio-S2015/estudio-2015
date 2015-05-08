<?php

	// Code to export data from MySQL table to .csv file for reports on administration page

	include_once("Config.php");
	include('ea/application/views/backend/reports_helpers.php');

	// create the file, w+ can be used to wipe out and overwrite an existing file with the same name
	// essentially this line will open an output stream that everything to be exported will be written to.
	// At the end of this file, header calls are made to send the output to a .csv file
	$outputStream = fopen('php://output', 'w+');

	//write spreadsheet column headings
	//fputcsv($outputStream, array('Major', 'Year', 'English As First Language', 'Group Size',  'First Time Visit', 'Help Topic'));

	// query to get all of the fields required for reports via Admin(Emily Dotson) specifications.
	// This includes the client's major, year, whether english is their first language, groupsize,
	// first time visit or not, and the help service requested.
	$query = "CALL ReportDump";
	try {
		$stmt = $db->prepare($query);
		$stmt->execute();
	} catch (Exception $e) {
		echo $e;
		exit;
	}



/*	
	$rows = $mysqli->query( 'SELECT Client.major, Client.year, Client.english, Appointment.groupSize, Appointment.firstVisit, Appointment.helpService
				FROM Client, Appointment
				WHERE Client.id = Appointment.clientID' );
 */

	// loop over the rows of data and output them
	$i = 0;
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_NUM)) {
		if ($i == 0) {
			$req = $row['Required'];
			$first = $row['FirstVisit'];
			$esl = $row['ESL'];
		} else {
			$req = ($row['Required'] == 1) ? 'Yes' : 'No';
			$first = ($row['FirstVisit'] == 1) ? 'Yes' : 'No';
			$esl = ($row['ESL'] == 1) ? 'Yes' : 'No';
		}
		
		$list = array(
					$row['ApptTime'],
					$row['FirstName'],
					$row['LastName'],
					$row['email'],
					$row['Service'],
					$row['Tutor'],
					$req,
					$first,
					$row['GroupSize'],
					$row['Major'],
					$row['Year'],
					$esl
				);

		var_dump($list);
/*
	while($row = $rows->fetch_object())
	{
		$englishFirstLang;
		$firstVisit;
		// get all of the info from this row
		if( $row->english == 0 ) { $englishFirstLang = "Yes"; }
		else { $englishFirstLang = "No"; }
		if( $row->firstVisit == 0 ) { $firstVisit = "No"; }
		else { $firstVisit = "Yes"; }

		$list = array( $row->major, $row->year, $englishFirstLang, $row->groupSize, $firstVisit, $row->helpService );
*/
		// write it to the stream
		fputcsv($outputStream, $list);
	}

	// we are finished writing and close the "outputStream"
	fclose($outputStream);

	// Format date for filename

	// output headers send the output to a .csv file that is downloaded.
	$filename="eStudioReport.csv";
	header('Content-type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$filename);
?>
