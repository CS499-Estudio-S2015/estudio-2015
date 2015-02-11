<?php
  session_start();
  include_once("Config.php");
  if( !isset( $_SESSION['user'] ) )
	header( 'Location: '.$pathPrefix.'index.php' );

?>

<!DOCTYPE HTML>
<html>

<!-- This is basically the client myProfile page. It is what will be displayed after a returning client has logged in, or a new client has registered and 
made an appointment. It displays all of the client information with a tab that queries the database and shows the upcoming appointments for that client. 
As well as a button linked to making the appointment. -->

<head>
<title>eStudio  - Profile</title>
<link rel="stylesheet" type="text/css" href="estudiostyle.css">
</head>

<body>

	<!-- HEADER / LOGO -->
	<div id="headerbox">
		<div id="headerbuttonholderleft">
			<font size="5" face="Tahoma" style="position:relative; top:-4px;"> eStudio </font>
		</div>
		<div id="headerbuttonholderright">
			<form action="LogOut.php" method="post">
				<a href="clientEditInfo.php" class="headerbutton" > Edit Profile</a>
				<input class="headerbutton" type="submit" value="Log Out" />
			</form>
			<!-- <a href="estudioHomePage.html" class="headerbutton" > Log Out </a> -->
		</div>

    </div>
	<!-- CONTENT BOX -->

	<div id="contentholder">

        <div class=tabs>
            <a href="estudioMakeAppointment.php" class="bodybutton" style=" position: absolute; top: 50px; right: 25px; height: 40px; line-height: 40px; vertical-align: middle;"> Make an Appointment </a>
            <div id=tab1> <a href="#tab1"> About Me </a>
                    <div>
						<br><br>
						<FONT  style="font-size:32pt; color: #003470; font-family: Tahoma;" name="About">About:</FONT>
            			<br><br>
           				<FONT style="font-size:16pt; color: #003470;" face="Tahoma">
                            <?php
                    			$result = $mysqli->query("SELECT * FROM Client WHERE StudentID='".$_SESSION['user']."'");
                    			if( $result->num_rows > 0 )
                    			{
                        			while($obj = $result->fetch_object() )
                        			{
										echo '<div style="line-height: 150%;">';
                            			echo 'Name: '.$obj->FirstName.' '.$obj->LastName;
                            			echo '<br>Student ID: '.$obj->StudentID;
                            			echo '<br>Major: '.$obj->Major;
                            			echo '<br>Academic Year: '.$obj->Year;
                            			echo '<br>Email Address: '.$obj->EmailAddress;
										echo '</div>';
                        			}
                    			}
            			    ?>
			            </FONT>
					</div>
            </div>
            <div id=tab2> <a href="#tab2"> Upcoming Appointments </a>
                    <div>
						<?php
							$result = $mysqli->query("SELECT * FROM Appointment WHERE StudentID='".$_SESSION['user']."' AND StartTime >= CURDATE()");
							if( $result->num_rows > 0 )
							{
								// print out their appointments
								echo '<br><FONT style="font-size:25pt; color: #003470; font-family: Tahoma;"> Your upcoming appointments: </FONT><br><br>';
								echo '<div style="max-height: 250px; overflow:auto;">';
								echo '<table class="upcomingtable"> <th> Date </th> <th> Time </th> <th> Tutor </th> <th> Group Size </th> <th> Duration </th> ';
								while( $obj = $result->fetch_object() )
								{
									echo '<tr>';
									echo '<td> '.date("m-d-Y", strtotime($obj->StartTime)).'</td>';

									echo '<td> '.date("h:i A", strtotime($obj->StartTime)).'</td>';
									echo '<td> '.$obj->Email.'</td>';
									echo '<td> '.$obj->GroupSize.'</td>';
									echo '<td> '.$obj->Duration.' minutes </td>';
									echo '</tr>';
								}
								echo '</table>';
								echo '</div>';
							}
							else  // if no appointments were found for this user...
							{
								echo '<br><br> <p style="font-size:18pt; color:red; weight:bold;" > No upcoming appointments found. </p>';
							}
						?>
					</div>
            </div>
        <br><br>
        </div>

        <!--This is the bottom of the page footer, just detailing where the estudio is located, basic information. 2 links, 1 for campus map, 1 for estudio homepage. -->
        <div style="position: absolute; top: 200px; left: 50%; margin-left: -250px; margin-top: 300px;">
                <P align="center" style="margin-top: 50px;">
                    <FONT size = "3" face ="Tahoma" color="#003470">
                        <br> The eStudio is located in room 108 <a href="http://maps.uky.edu/campusmap/" style="color: #017338">RGAN</a>.
                        <br> eStudio hours are Monday-Thursday, 10:00 A.M. - 6:00 P.M.
                        <br> For more information go to:<a href="https://www.engr.uky.edu/students/estudio/" style="color: #017338"> https://www.engr.uky.edu/students/estudio/</a>
                    </FONT>
                </P>
        </div>

	</div>




</body>

</html>
