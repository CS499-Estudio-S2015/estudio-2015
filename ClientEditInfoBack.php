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
$select = $mysqli->query("SELECT EXISTS(SELECT * FROM Client WHERE email = '" . $email . "')");
if ($select->fetch_row()[0] == 0) {
	$update = $mysqli->query("UPDATE Client SET major='".$major."', year='".$year."', email='".$email."' WHERE id='".$studentID."'");
} else {
	echo 'Insert failed, client email in use. Please press "Back" and try again.';
}


// redirect to the client info page, displaying the updated information
header( 'Location: '.$pathPrefix.'clientInfo.php#tab1' ); exit;
?>
