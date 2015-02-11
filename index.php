<!DOCTYPE HTML>
<html>

<!-- The index.php page is the first page that user's will see when navigating to the site. 
	 It contains the registration form for new clients to register and start making appointments with the eStudio. 
	 It also contains a link to the staff portal page for administration and tutor's to login, as well as a returning
	 user login section, for old clients to login and view upcoming appointments or make new ones. -->

<head>
	<title>eStudio - Home</title>
<link rel="stylesheet" type="text/css" href="estudiostyle.css">

<!-- The following are JavaScript functions to validate the login and registration forms -->

<script type="text/javascript">

	function validateLogin()
	{
		var valid = true;
		var x = document.forms["LoginForm"]["studentID"].value;
		var y = document.forms["LoginForm"]["password"].value;
		if( x == null || x == "" || y == null || y == "" )
		{
			document.getElementById("loginerror").innerHTML = "Invalid StudentID or Password";
			valid = false;
		}
		else
		{
			document.getElementById("loginerror").innerHTML = "";
		}
		return valid;
	}

	function validateRegForm()
	{
		var valid = true;   // returned true if the all of the form fields are valid, false if not.
		var idformat = true;
		var emailformat = true;
		var x = document.forms["registerForm"]["firstName"].value;
		if( x == null || x == "" )
		{
			document.getElementById("fnerror").innerHTML = "*";
			valid = false;
		}
		else { document.getElementById("fnerror").innerHTML = ""; }

		x = document.forms["registerForm"]["lastName"].value;
		if( x == null || x == "" )
		{
            document.getElementById("lnerror").innerHTML = "*";
			valid = false;
		}
		else { document.getElementById("lnerror").innerHTML = ""; }

		x = document.forms["registerForm"]["studentID"].value;
		var isNumber =  /^\d+$/.test(x);
		if( x.length != 9 ) { isNumber = false; }
		if( x == null || x == "" )
		{
            document.getElementById("siderror").innerHTML = "*";
			valid = false;
		}
		else {
			if( isNumber )
				document.getElementById("siderror").innerHTML = "";
			else
			{
				document.getElementById("siderror").innerHTML = "*";
				valid = false;
			}
		}

		x = document.forms["registerForm"]["major"].value;
		if( x == "Select Your Major" )
		{
            document.getElementById("merror").innerHTML = "*";
			valid = false;
		}
		else { document.getElementById("merror").innerHTML = ""; }

		x = document.forms["registerForm"]["year"].value;
		if( x == "Select Your Year" )
		{
            document.getElementById("yerror").innerHTML = "*";
			valid = false;
		}
		else { document.getElementById("yerror").innerHTML = ""; }

		x = document.forms["registerForm"]["email"].value;
		var atpos = x.indexOf("@");
    	var dotpos = x.lastIndexOf(".");
    	if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) { emailformat = false; }
		if( x == null || x == "" )
		{
            document.getElementById("emailerror").innerHTML = "*";
			valid = false;
		}
		else {
			document.getElementById("emailerror").innerHTML = "";
			if( emailformat == false ) {
				document.getElementById("emailerror").innerHTML = "*";
				valid = false;
			}
		}

		x = document.forms["registerForm"]["password"].value;
		var temp = x;
		if( x == null || x == "" )
		{
            document.getElementById("perror").innerHTML = "*";
			valid = false;
		}
		else { document.getElementById("perror").innerHTML = ""; }

		x = document.forms["registerForm"]["passwordCfm"].value;
        if( x == null || x == "" )
        {
            document.getElementById("cperror").innerHTML = "*";
            valid = false;
        }
        else {
			document.getElementById("cperror").innerHTML = "";
			if( x !== temp )
			{
				document.getElementById("cperror").innerHTML = "*";
				valid = false;
			}
		}

		if( !valid )
		{
			document.getElementById("errmsg").innerHTML = "Please enter all fields";
		}

		if( !emailformat ) { document.getElementById("errmsg").innerHTML = "Incorrect email format"; }
		if( !isNumber ) { document.getElementById("errmsg").innerHTML = "StudentID must be 9 numeric digits"; }
		if( x !== temp ) { document.getElementById("errmsg").innerHTML = "Passwords do not match"; }
		return valid;
	}


</script>


</head>

<body>

	<!-- HEADER / LOGO -->
	<div id="headerbox"> 
		<div id="headerbuttonholderleft">
			<font size="5" face="Tahoma" style="position:relative; top:-4px;"> eStudio </font>
		</div>
		<div id="headerbuttonholderright">

			<!-- This form is where the returning clients login -->
			<form name="LoginForm" action="ClientLogin.php" onsubmit="return validateLogin()"  method="post">
			<FONT size="4" face="Tahoma">
				Student ID: <input type="text" name="studentID" id="studentID" color="#003470">
				password: <input type="password" name="password" id="password" color="#003470">
			</FONT>
			<input class="headerbutton" type="submit" value="Login" />
			
			</form>
		</div>
		<div id="loginerror" style="position:absolute; right: 300px; top: 70px; color: red; font-weight: 500; font-size: 14pt; text-align: center;">
		<?php
			if( isset( $_GET['loginerror'] ) ) {
				echo 'The Student ID or password was incorrect.';
			}

		?>
		</div>

	</div>
	<!-- CONTENT BOX -->
	
	 <div id="contentholder">
	 			
		<div id="registrationholder"  >
			<!-- This form is for new users to register with the eStudio. -->
			<form name="registerForm" id="registerForm" action="ClientRegister.php" onsubmit="return validateRegForm()" method="post">
			<P align="left">
				<FONT style="font-size:36pt" face="Tahoma" name="Registration" color="#003470">Registration</FONT><br><br>
				<FONT style="font-size:16pt" face="Tahoma" color="#003470">
					<font id="fnerror" color="#003470" class="validation"></font> First Name: <INPUT type ="text" placeholder="First Name" name="firstName" id="firstName" value="" color="#003470"><br><br>
					<font id="lnerror" color="#003470" class="validation"></font> Last Name: <INPUT type ="text" placeholder="Last Name" name="lastName" id="lastName" value="" color="#003470"><br><br>
					<font id="siderror" color="#003470" class="validation"></font> Student ID Number: <INPUT type="text" placeholder="studentID" name="studentID" id="studentID" value="" color="#003470" style="width:175px;"><br><br>
					<font id="merror" color="#003470" class="validation"></font> Major:  <select name="major" id="major"> 
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
						</select><br><br>
					<font id="yerror" color="#003470" class="validation"></font> Academic Year: <select name="year" id="year"> 
						<option style="color: #017338" value="Select Your Year">Select Your Year</option>
						<option style="color: #017338" value="Freshmen">Freshman</option>
						<option style="color: #017338" value="Sophomore">Sophomore</option>
						<option style="color: #017338" value="Junior">Junior</option>
						<option style="color: #017338" value="Senior">Senior</option>
						<option style="color: #017338" value="Graduate Student">Graduate Student</option>
						<option style="color: #017338" value="Faculty">Faculty</option>
						<option style="color: #017338" value="other">Other</option>
						</select><br><br>
					Is English your second language? <select name="english" id="english" style="width:80px;">
						<option style="color: #017338" value="no">No</option>
						<option style="color: #017338" value="yes">Yes</option>
						</select><br><br>
					<font id="emailerror" color="#003470" class="validation"></font> Email Address: <INPUT type ="text" name="email" placeholder="Email Address" id="email" value="" color="#003470"><br><br>
					<font id="perror" color="#003470" class="validation"></font> Password: <INPUT type ="password" name="password" placeholder="Password" id="password" value="" color="#003470"><br><br>
					<font id="cperror" color="#003470" class="validation"></font> Confirm Password: <INPUT type ="password" name="passwordCfm" placeholder="Confirm Password" id="passwordCfm" value="" color="#003470" style="width:200px;"> <br><br>
				</FONT>
				<br>

				<input class="bodybutton" type="submit" style="position: absolute; top:600px; height: 40px; width:120px; font-size: 14pt; line-height:20px; vertical-align:middle;" value="Register" />
				<font id="errmsg" color="#003470" style="position:absolute; left: 200px; top: 600px; color:red"></font>
			</P>
			</form>

		</div>
		
		<img src="estudioLogo.JPG" style="width: 35%; margin-left: 8%; margin-top: 120px; position:absolute; left:450px;top:10%;">
		
		<div id="staffportalholder">
			<br><a href="staffPortal.php" style="color: #017338; font-size:16pt;">Staff Portal</a>
	 	</div>
	
		<div style="position: absolute; bottom: 10px; left: 50%; margin-left: -250px; margin-top: 60px;">
		<P align="center" style="margin-top: 15px;">
			<FONT size = "3" face ="Tahoma" color="#003470">
				<br> The eStudio is located in room 108 <a href="http://maps.uky.edu/campusmap/" style="color: #017338">RGAN</a>.
				<br> eStudio hours are Monday-Thursday, 10:00 A.M. - 6:00 P.M.
				<br> For more information go to:<a href="https://www.engr.uky.edu/students/estudio/" style="color: #017338"> https://www.engr.uky.edu/students/estudio/</a>
			</FONT>
		</P>
		</div>
		
		<!-- Button to take you to the staff portal --> 
		

	 </div>
	 
	 


</body>

</html>
