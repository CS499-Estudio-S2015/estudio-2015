<?php
require('Config.php');

$tutors = array(85, 89, 94, 95, 96);
$customers = array(86, 88, 90, 91, 92, 93, 97, 98, 99);
$services = array(13, 14, 15, 16, 17, 18);

// echo $tutors[0];
// echo $tutors[count($tutors)];

for ($i = 0; $i < 20; $i = $i + 1) {

	// $rand_tutor = rand($tutors[0], $tutors[count($tutors) - 1]);
	$rand_tutor = $tutors[rand(0, count($tutors) - 1)];
	$rand_cust = $customers[rand(0, count($customers) - 1)];
	// $rand_cust = rand($customers[0], $customers[count($customers) - 1]);
	$rand_service = rand($services[0], $services[count($services) - 1]);
	$year = rand(2012, 2015);
	$month = rand(1, 12);
	$day = rand(1, 28);
	$hour = rand(10, 18);

	$start = date('Y-m-d H:i:s', mktime($hour, 0, 0, 5, $day, 2015));
	$end  = date('Y-m-d H:i:s', mktime($hour + 1, 0, 0, 5, $day, 2015));
	$book =  date('Y-m-d H:i:s', mktime($hour, 0, 0, $month, $day - 2, $year));

	$group_size = rand(1, 5);
	$req_visit = rand(0, 1);
	$first_visit = rand(0, 1);


	$query = "INSERT INTO ea_appointments (book_datetime, start_datetime, end_datetime, id_users_provider, id_users_customer, id_services, group_size, req_visit, first_visit) 
					 VALUES ('" . $book . "', '"
					 		    . $start . "', '"
					 		    . $end . "', "
					 		    . $rand_tutor . ", "
					 		    . $rand_cust . ", "
					 		    . $rand_service . ", "
					 		    . $group_size . ", "
					 		    . $req_visit . ", "
					 		    . $first_visit . ")";

	echo $rand_cust . "\n";

	try {
		$stmt = $db->prepare($query);
		$stmt->execute();
		echo "Statement executed\n";
	} catch (Exception $e) {
		echo "Query not executed\n";
		echo $e;
		exit;
	}


}
?>