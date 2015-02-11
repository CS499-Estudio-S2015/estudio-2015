<?php
  session_start();
  include_once("Config.php");
  if( !isset( $_SESSION['user'] ) )
	header( 'Location: '.$pathPrefix.'clientInfo.php' );

?>

<!DOCTYPE HTML>
<html>

<!-- This php file is for the edit client information, linking to the edit profile button on the client side interface myProfile page. 
It is just basic php script to pull client data from the table, allow the client to click and change that data, then save it back to the database. -->

<head>
<title>eStudio  - Edit Profile</title>
<link rel="stylesheet" type="text/css" href="estudiostyle.css">
<script type="text/javascript">

	function validation()
	{
		valid = true;

		var selectedMajor = document.forms["editForm"]["major"].value;
		var selectedYear = document.forms["editForm"]["year"].value;
		var newEmail = document.forms["editForm"]["email"].value;
		var correctEmailFormat = true;

		// check validity of email format
		var atpos = newEmail.indexOf("@");
        var dotpos = newEmail.lastIndexOf(".");
        if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= newEmail.length)
		{
			correctEmailFormat = false;
		}

		// check validity of major selection
		if( selectedMajor == "Select Your Major" )
		{
			valid = false;
			document.getElementById("majorerr").innerHTML = "*";
		} else {
			document.getElementById("majorerr").innerHTML = "";
		}

		// check validity of year selection
		if( selectedYear == "Select Your Year" )
		{
			valid = false;
			document.getElementById("yearerr").innerHTML = "*";
		} else {
            document.getElementById("yearerr").innerHTML = "";
        }

		// check validity of new email provided (if empty or wrong format)
		if( newEmail == "" || correctEmailFormat == false )
		{
			valid = false;
			document.getElementById("emailerr").innerHTML = "*";
			if( !correctEmailFormat )
			{
				document.getElementById("emailerr").innerHTML = "* Fix email format.";

			}
		} else {
            document.getElementById("emailerr").innerHTML = "";
        }

		if( !valid )
		{
			document.getElementById("errormessage").innerHTML = "Please fill out all fields with a red star.";
		}

		return valid;
	}

</script>


</head>

<body>

	<!-- HEADER / LOGO -->
	<div id="headerbox">
		<div id="headerbuttonholderleft">
			<!--<a href="estudioMyProfile.php" class="headerbutton" > 
                <img src="backArrowW.png" style=" height: 20px; width:20px; position: relative; top:2px; display:inline; "/>  Back </a>-->
		</div>
		<div id="headerbuttonholderright">
			<!-- possible future buttons here -->
		</div>
    </div>

    <!-- CONTENT BOX -->

	<div id="contentholder">

            <div class=tabs>
            	<!-- The About Me tab where clients can edit their information -->
                <div id=tab1> <a href="#tab1"> About Me </a>
                    <div>
						<br><br>
						 <FONT style="font-face: Tahoma; font-size: 32pt; color: #003470;" name="AboutEdit" >About:</FONT>
            			<br><br>
           				 <FONT style="font-face: 16pt; color: #003470;" face="Tahoma">
           				 	<FORM name="editForm" action="ClientEditInfoBack.php" method="post" onsubmit="return validation()">
                            <?php
								//query the database to get all of the information for this particular client based upon his/her studentID
                    			$result = $mysqli->query("SELECT * FROM Client WHERE StudentID='".$_SESSION['user']."'");
                    			if( $result->num_rows > 0 )
                    			{
                        			while($obj = $result->fetch_object() )
                        			{
										//echoes fields to the screen with results from the database query
										echo '<div style="line-height: 150%;">';
                            			echo 'Name: '.$obj->FirstName.' '.$obj->LastName;
                            			echo '<br>Student ID: '.$obj->StudentID;
                            			echo '<br>Major: '.$obj->Major;
                            			echo '<select name="major" id="major"> 
											<option style="color: #017338" value="Select Your Major">Select Your Major</option>
											<option style="color: #017338" value="Biosystems and Agricultural Engineering">Biosystems and Agricultural Engineering</option>
											<option style="color: #017338" value="Chemical Engineering">Chemical Engineering</option>
											<option style="color: #017338" value="Civil Engineering">Civil Engineering</option>
											<option style="color: #017338" value="Computer Engineering">Computer Engineering</option>
											<option style="color: #017338" value="Computer Science">Computer Science</option>

											<option style="color: #017338" value="Electrical Engineering">Electrical Engineering</option>
											<option style="color: #017338" value="Masters in Engineering">Masters in Engineering</option>
											<option style="color: #017338" value="Manufacturing Systems Engineering">Manufacturing Systems Engineering</option>
											<option style="color: #017338" value="Materials Science and Engineering">Materials Science and Engineering</option>
											<option style="color: #017338" value="Mechanical Engineering">Mechanical Engineering</option>
											<option style="color: #017338" value="Mining Engineering">Mining Engineering</option>
											<option style="color: #017338" value= "undeclared">Undeclared</option>
											<option style="color: #017338" value="other">Other</option>
											</select>';
										// div for 'major' validation errors -- if found display red star
										echo '<a id="majorerr" style="color:red; margin-left:10px;"></a>';
										// select box for year
                            			echo '<br>Academic Year: '.$obj->Year;
                            			echo '<select name="year" id="year">
											<option style="color: #017338" value="Select Your Year">Select Your Year</option>
											<option style="color: #017338" value="Freshmen">Freshman</option>
											<option style="color: #017338" value="Sophomore">Sophomore</option>
											<option style="color: #017338" value="Junior">Junior</option>
											<option style="color: #017338" value="Senior">Senior</option>
											<option style="color: #017338" value="Graduate Student">Graduate Student</option>
											<option style="color: #017338" value="Faculty">Faculty</option>
											<option style="color: #017338" value="other">Other</option>
											</select>';
										// div for 'year' validation errors -- if found display red star
                                        echo '<a id="yearerr" style="color:red; margin-left:10px;"></a>';


                            			echo '<br>Email Address: '.$obj->EmailAddress;
                            			echo '  <INPUT type ="textbox" name="email" id="email" placeholder="New Address" value="">';
										// div for 'email' validation errors -- if found display red star
                                        echo '<a id="emailerr" style="color:red; margin-left:10px;"></a>';
										echo '</div>';
                        			}
                    			}
            			    ?>
            			    <br>
            			    	<input class="headerbutton" type="submit" value="Save Changes" />
								<?php
									// display the cancel button
									echo '<a href="'.$pathPrefix.'clientInfo.php" class="headerbutton"> Cancel </a>';

									echo '<a id="errormessage" style="color:red; margin-left:20px;"></a>';
								?>
            				</FORM>
			            </FONT>
					</div>
                </div>


            <br><br>
            </div>
	</div>
</body>
</html>
