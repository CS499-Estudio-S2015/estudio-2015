

<!DOCTYPE HTML>
<html>

<!-- This is the code for the HTML interface for the administrator to add work schedule information to the tutor's database.
From which available times for appointments will be pulled. The backend for this file is TutorTime.php-->

<head>
    <title>eStudio  - Profile</title>
    <link rel="stylesheet" type="text/css" href="estudiostyle.css">
</head>

<body>

	<!-- HEADER / LOGO -->
    <div id="headerbox"> 

        <div id="headerbuttonholderleft">
        	<font size="5" face="Tahoma" style="position:relative; top:-4px;"> eStudio </font>
			<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Upcoming </a>
			<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Tutors </a>
			<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Schedule </a>
			<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Reports </a>
			<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Disable </a>
			<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Help </a>
		</div>
        <div id="headerbuttonholderright">
            <a href="estudioStaffLoginPage.html" class="headerbutton" > Logout </a>
        </div>
         

    </div>
	<!-- CONTENT BOX -->
		
	<div id="contentholder" style="min-height:650px">

		<FONT face="Tahoma" style="font-size:20pt; color: #003470"><b>Tutor Information:</b> <input type="hidden" name="weekday" value="Monday" /></FONT><br>
			<FONT face="Tahoma" style="font-size:16pt; color: #003470">
			<div style="padding: 10px 10px 10px 10px;">
				Tutor Email:<INPUT type ="textbox" placeholder="tutor email" name="email" value="" style="position: relative; left: 10px;"><br><br>
			</div> 
			<br><br>
		</FONT>

        <div class=tabs>
                <div id=tab1> <a href="#tab1"> Monday </a>
                    <div>

						<form action="TutorTimes.php" name="TutorTimes" method="post">
							<FONT face="Tahoma" style="font-size:18pt; color: #003470; position:relative; top:20px;"> <b>Tutor shift time for Monday:</b>  <input type="hidden" name="weekday" value="Monday" /></FONT><br>
							<FONT face="Tahoma" style="font-size:16pt; color: #003470; position:relative; top:30px">
								<div style="padding: 10px 10px 10px 10px;">
									Start Time:<input type="time" name="start_time" style="position: relative; left: 10px; "> <br>
									End Time:<input type="time" name="end_time" style="position: relative; left: 17px; "> <br>
								</div>
						 </FONT> 
							<input type="submit" value="Submit" class="bodybutton" style="position: absolute; margin-top: 35px; left: 140px; width: 200px; margin-left: -100px;" />
						</form>
					</div>
                </div>
                <div id=tab2> <a href="#tab2"> Tuesday </a>
                    <div>

						<form action="TutorTimes.php" name="TutorTimes" method="post">
							<FONT face="Tahoma" style="font-size:18pt; color: #003470; position:relative; top:20px;"> <b>Tutor shift time for Tuesday:</b>  <input type="hidden" name="weekday" value="Tuesday" /></FONT><br>
							<FONT face="Tahoma" style="font-size:16pt; color: #003470; position:relative; top:30px">
								<div style="padding: 10px 10px 10px 10px;">
									Start Time:<input type="time" name="start_time" style="position: relative; left: 10px; "> <br>
									End Time:<input type="time" name="end_time" style="position: relative; left: 17px; "> <br>
								</div>
						 </FONT> 
							<input type="submit" value="Submit" class="bodybutton" style="position: absolute; margin-top: 35px; left: 140px; width: 200px; margin-left: -100px;" />
						</form>
					</div>
                </div>
                <div id=tab3> <a href="#tab3"> Wednesday </a>
                    <div>

						<form action="TutorTimes.php" name="TutorTimes" method="post">
							<FONT face="Tahoma" style="font-size:18pt; color: #003470; position:relative; top:20px;"> <b>Tutor shift time for Wednesday:</b>  <input type="hidden" name="weekday" value="Wednesday" /></FONT><br>
							<FONT face="Tahoma" style="font-size:16pt; color: #003470; position:relative; top:30px">
								<div style="padding: 10px 10px 10px 10px;">
									Start Time:<input type="time" name="start_time" style="position: relative; left: 10px; "> <br>
									End Time:<input type="time" name="end_time" style="position: relative; left: 17px; "> <br>
								</div>
						 </FONT> 
							<input type="submit" value="Submit" class="bodybutton" style="position: absolute; margin-top: 35px; left: 140px; width: 200px; margin-left: -100px;" />
						</form>
					</div>
                </div>
                <div id=tab4> <a href="#tab4"> Thursday </a>
                    <div>

						<form action="TutorTimes.php" name="TutorTimes" method="post">
							<FONT face="Tahoma" style="font-size:18pt; color: #003470; position:relative; top:20px;"> <b>Tutor shift time for Thursday:</b>  <input type="hidden" name="weekday" value="Thursday" /></FONT><br>
							<FONT face="Tahoma" style="font-size:16pt; color: #003470; position:relative; top:30px">
								<div style="padding: 10px 10px 10px 10px;">
									Start Time:<input type="time" name="start_time" style="position: relative; left: 10px; "> <br>
									End Time:<input type="time" name="end_time" style="position: relative; left: 17px; "> <br>
								</div>
						 </FONT> 
							<input type="submit" value="Submit" class="bodybutton" style="position: absolute; margin-top: 35px; left: 140px; width: 200px; margin-left: -100px;" />
						</form>
					</div>
                </div>
        <br><br>
        </div>
    </div>
</body>
</html>
