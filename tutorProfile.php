<?php
	/*  ------------------------------------------------------------------------------------------------------
		-- tutorProfile.php --
		Purpose:       This file handles both the front end and back end for what tutors see after logging in.
		Precondition:  A tutor has logged in from staffLogin.php
		Notes:	       The HTML sets up the layout of the page, and css tabs are used for the content box.
				       Currently, there is only one tab used to display upcoming appointments for the tutor.
				       Additionally, the table simply selects all appointments for the given tutor, which needs
				       to be narrowed down in the future to just future appointments (or even just for the
				       current day).
		------------------------------------------------------------------------------------------------------
	*/
  session_start();
  include_once("Config.php");

?>

<!DOCTYPE HTML>
<html>

<head>
	<title>eStudio - Staff</title>
<link rel="stylesheet" type="text/css" href="estudiostyle.css">
</head>

<body>

	<!-- HEADER / LOGO -->
    <div id="headerbox"> 

		<div id="headerbuttonholderleft">
			<font size="5" face="Tahoma" style="position:relative; top:-4px;"> eStudio </font>
		</div>
		<div id="headerbuttonholderright">
			<!--<FONT size="3" face="Tahoma">search:&nbsp&nbsp<input type="text" name="search" value=""></FONT>-->
			<form action="LogOut.php" method="post">
                <input class="headerbutton" type="submit" value="Log Out" />
            </form>
		</div>
	</div>

	<!-- CONTENT BOX -->
	<!-- This will show the tutor's upcoming appointments. -->
	<div id="contentholder">
        <div class=tabs>
        		<div id=tab1> <a href="#tab1"> Upcoming Appointments</a>
                    <div>
						<!-- The following div stores the upcoming appointments and handles overflow of the table -->
						<div style="max-width:510px;max-height: 350px; overflow: auto; box-shadow: 1px 1px 10px 1px #232323;">
                    	<?php
							$result = $mysqli->query("SELECT * FROM Appointment INNER JOIN Tutor ON Appointment.tutorID = Tutor.id WHERE Tutor.email='".$_SESSION['staff']."' AND Appointment.startTime >= CURDATE()");
							if( $result->num_rows > 0 )
							{
								// print out their appointments
								echo '<table class="upcomingtable"> <th> Date </th> <th> Time </th> <th> Tutor </th> ';
								while( $obj = $result->fetch_object() )
								{
									echo '<tr>';
									echo '<td> '.$obj->startTime.'</td>';
									echo '<td> '.$obj->startTime.'</td>';
									echo '<td> '.$obj->email.'</td>';
									echo '</tr>';
								}
								echo '</table>';

							}
							else  // if no appointments were found for this user...
							{
								// display "No upcoming appointments found"
								echo '<br><br> <p style="font-size:18pt; color:red; weight:bold;" > No upcoming appointments found. </p>';
							}
						?>
						</div>
					</div>
                </div>
        </div>
	</div>

</body>

</html>
