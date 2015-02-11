<!DOCTYPE HTML>
<html>

<!-- This was going to be the page the staff saw upon logging in. It's similar to Emily's more advanced
administrative page with fewer features. It could be used as a template for the staff page when future 
enhancements have been made. -->

<head>
	<title>eStudio - Staff</title>
<link rel="stylesheet" type="text/css" href="estudiostyle.css">
</head>

<body>

	<!-- HEADER / LOGO -->
    <div id="headerbox"> 

		<div id="headerbuttonholderleft">
			<a href="estudioHomePage.html" class="headerbutton" > <img src="myhome.png" style="height: 20px; width:20px; position: relative; top:2px; display:inline; "/>  Home </a>
		</div>
		<div id="headerbuttonholderright">
			<!--<FONT size="3" face="Tahoma">search:&nbsp&nbsp<input type="text" name="search" value=""></FONT>-->
			<form action="LogOut.php" method="post">
                <input class="headerbutton" type="submit" value="Log Out" />
            </form>
		</div>

	</div>
	<!-- CONTENT BOX -->
	
	<div id="contentholder">
        <div class=tabs>
        		<div id=tab1> <a href="#tab1"> Profile </a>
                    <div>
						<P align="center">
							<FONT size="15" face="Tahoma" align="center" color="#003470">
								Welcome back!
							</FONT>
						</P>	
					</div>
                </div>
                <div id=tab2> <a href="#tab2"> Upcoming </a>
                    <div>
					</div>
                </div>
                <div id=tab3> <a href="#tab3"> Help </a>
                    <div>
						<P align="center">
							<FONT face="Tahoma" size="5" color="#003470"><b>Below are the options you have.</b></FONT>
							<FONT face="Tahoma" size="4" color="#003470">
								<!-- user options -->  
								<br><br>
								Click on the Profile tab to go to your profile.
								<br><br>
								Click on the Upcoming tab to view upcoming appointments for this week.
								<br><br>
								Use the search box to find a student by their Student ID or Name
								<br><br>
								Click the logout button to logout.
								<br><br>
							</FONT>
						</P>
					</div>
                </div>
	</div>
	<div style="position: absolute; bottom: 10px; left: 50%; margin-left: -250px; margin-top: 300px;">
        <P align="center" style="margin-top: 50px;">
            <FONT size = "3" face ="Tahoma" color="#003470">
                <br> The eStudio is located in room 108 RGAN.
                <br> eStudio hours are Monday-Thursday, 10:00 A.M. - 6:00 P.M.
                <br> For more information go to:<a href="https://www.engr.uky.edu/students/estudio/" style="color: #017338"> https://www.engr.uky.edu/students/estudio/</a>
            </FONT>
        </P>
    </div>


</body>

</html>
