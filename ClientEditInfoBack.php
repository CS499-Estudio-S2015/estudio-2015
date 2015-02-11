<?php
  session_start();
  include_once("Config.php");
  if( !isset( $_SESSION['user'] ) )
	header( 'Location: '.$pathPrefix.'index.php' );

?>

<?php
//This is the backend code which is used when redirecting to the client profile with updated information
$current_url = base64_encode("http://".$SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);


		// get all of the info from the post array
		$major = $_POST['major'];
		$year = $_POST['year'];
		$email = $_POST['email'];

		// get the student id to be used in the query
		$studentID = $_SESSION['user'];

		// update client information in the Client table
		$results = $mysqli->query("UPDATE Client SET major='".$major."', year='".$year."', emailaddress='".$email."' WHERE studentID='".$studentID."'");

		// redirect to the client info page, displaying the updated information
		header( 'Location: '.$pathPrefix.'clientInfo.php#tab1' ); exit;
?>
