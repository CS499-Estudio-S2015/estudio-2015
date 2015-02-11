<!DOCTYPE HTML>
<html>

<head>
<title>eStudio  - Staff Login</title>
<link rel="stylesheet" type="text/css" href="estudiostyle.css">

<script>
	<!--function to do basic validation of logins -->
	function validateLogin()
	{
		var valid = true;
		var x = document.forms["StaffLogin"]["email"].value;
		var y = document.forms["StaffLogin"]["password"].value;
		if( x == null || x == "" || y == null || y == "" )
		{
			document.getElementById("loginerror").innerHTML = "Email and password required!";
			valid = false;
		}
		else
		{
			document.getElementById("loginerror").innerHTML = "";
		}

		return valid;
	}

</script>

</head>

<body>

	<!-- HEADER / LOGO -->
	<div id="headerbox"> 
		<div id="headerbuttonholderleft">
			<a href="index.php" class="headerbutton" >  <img src="myhome.png" style="height: 20px; width:20px; position: relative; top:2px; display:inline; "/>  Home </a>
			<!-- <a href="estudioDirectBooking1.html" class="headerbutton" >  Make an appointment </a> -->
		</div>
		<div id="headerbuttonholderright">
			<!-- <a href="#" class="headerbutton" > Login </a> -->
		</div>
		<!-- Add a 4th button here for Login portal, should there be two separate buttons for staff login and client login? I don't think so. --> 

	</div>
        <!-- CONTENT BOX -->
	<div id="contentholder">
		<div id="hiddenpositioner" style="width:600px; height: 500px; position: relative; left: 50%; margin-left: -300px;">
			<img src="estudioLogo.JPG" style="width: 350px; position: relative; left: 50%; margin-left: -175px;">
			<font style="position:relative; top:50px; left: 30px; font-family:Tahoma; font-weight: 600; font-size: 18pt; color:#003470;"> Staff Login Portal </font>
		<!-- Staff login stuff here. -->

			<FORM name="StaffLogin" action="StaffLogin.php" onsubmit="return validateLogin()" method="post">
				<div style="position:absolute; left: 50%; top:300px; width: 100px; margin-left: -150px; line-height:40px; font-family: Tahoma; font-size:14pt;">
					Email: <br> Password:
				</div>
				<div style="position:absolute; left: 50%; top: 300px; width: 100px; margin-left: -50px; line-height: 40px;">
					<INPUT type ="textbox" name="email" value=""><br>
					<INPUT type ="password" name="password" value="">
				</div>
				<br><br>
				<input type="submit" value="Login" class="bodybutton" style="position: absolute; bottom: 50px; left: 50%; width: 200px; margin-left: -100px;" />

				<div id="loginerror" style="position:absolute; bottom: 10px; left: 50%; color:red; font-size: 14pt; margin-left: -110px;">
				<?php
					if( isset( $_GET['loginerror'] ) )
					{
						echo 'Invalid email or password.';
					}
				?>
				</div>
			</FORM>
		</div>

	</div>


</body>

</html>
