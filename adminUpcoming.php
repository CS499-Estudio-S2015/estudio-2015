<?php
  session_start();
  include_once("Config.php");

?>

<!DOCTYPE HTML>
<html>

<!-- This is the upcoming appointments page for the administration side. -->

<head>
<title>eStudio  - Upcoming</title>
<link rel="stylesheet" type="text/css" href="estudiostyle.css">
</head>

<body>

	<!-- HEADER / LOGO -->
	<div id="headerbox">
		<div id="headerbuttonholderleft">
			<font size="5" face="Tahoma" style="position:relative; top:-4px;"> eStudio </font>
			<a href="adminUpcoming.php" class="headerbutton" style="position:relative; top:-4px;"> Upcoming </a>
			<a href="addTutorInfo.html" class="headerbutton" style="position:relative; top:-4px;"> Tutors </a>
			<a href="scheduleTutor.html" class="headerbutton" style="position:relative; top:-4px;"> Schedule </a>
			<a href="Reports.php" class="headerbutton" style="position:relative; top:-4px;"> Reports </a>
			<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Disable </a>
			<a href="adminHelp.html" class="headerbutton" style="position:relative; top:-4px;"> Help </a>
		</div>
		
		<div id="headerbuttonholderright">
			<form action="LogOut.php" method="post">
				<input class="headerbutton" type="submit" value="Log Out" />
			</form>
		</div>

    </div>
	<!-- CONTENT BOX -->

	<div id="contentholder">   
		<div>
						<?php
							$result = $mysqli->query("SELECT * FROM Appointment ");
							if( $result->num_rows > 0 )
							{
								// print out their appointments in a table
								echo '<P align="center">';
								echo '<br><FONT style="font-size:25pt; color: #003470; font-family: Tahoma;"> All upcoming appointments: </FONT><br><br>';
								echo '<table align="center" class="upcomingtable"> <th> Date </th> <th> Time </th> <th> Tutor </th> ';
								while( $obj = $result->fetch_object() )
								{
									echo '<tr>';
									echo '<td> '.$obj->StartTime.'</td>';
									echo '<td> '.$obj->StartTime.'</td>';
									echo '<td> '.$obj->Email.'</td>';
									echo '</tr>';
								}
								echo '</table>';
								echo '</P>';

							}
							else  // if no appointments were found for this user...
							{
								echo '<br><br> <p style="font-size:18pt; color:red; weight:bold;" > No upcoming appointments found. </p>';
							}
						?>
		</div>
	</div>

</body>

</html>
