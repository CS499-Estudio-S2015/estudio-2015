<?php

session_start();
include_once("Config.php");

?>

<!-- This is the code to register the tutor's and put all of their information into the database. It connects to the admin
addTutors.html page -->

<?php
// $current_url = base64_encode("http://".$SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$lastName = $_POST['lastname'];
$firstName = $_POST['firstname'];
$email = $_POST['email'];
$password = $_POST['password'];
$adminboolean = 0; //for setting admin privilege   
$isAdmin = $_POST['isAdmin'];
if( $isAdmin == "Yes" ) { $adminboolean = 1; }

//        echo 'Last Name:  '.$lastName.'  .<br>';
//        echo 'First Name:  '.$firstName.'  .<br>';
//        echo 'email:  '.$email.'  .<br>';
//        echo 'password:  '.$password.'  .<br>';
//        echo 'isAdmin:  '.$isAdmin.'  .<br>';


$select = $mysqli->query("SELECT EXISTS(SELECT * FROM Tutor WHERE email = '" . $email . "')");
if ($select->fetch_row()[0] == 0) 
{
	$select->close();
	$results = $mysqli->query("INSERT INTO Tutor (lastName, firstName, email, isAdmin, password)
    	VALUES ('".$lastName."','".$firstName."','".$email."','".$adminboolean."','".$password."')");
	header( 'Location: '.$pathPrefix.'adminHelp.html' ); exit;
} else {
	echo 'Insert failed, tutor email in use. Please press "Back" and try again.';
}

// $results = $mysqli->query("INSERT INTO Tutor (lastName, firstName, email, isAdmin, password)
//     VALUES ('".$lastName."','".$firstName."','".$email."','".$adminboolean."','".$password."')");

// if( $results )
// {
//     header( 'Location: '.$pathPrefix.'adminHelp.html' ); exit;
// } else {
//     echo 'Insert failed, tutor email in use. Please press "Back" and try again.';
// }
?>
