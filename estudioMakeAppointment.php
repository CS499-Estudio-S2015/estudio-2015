<!DOCTYPE HTML>
<html>

<head>
<title>eStudio  - Make Appointment</title>
<link rel="stylesheet" type="text/css" href="estudiostyle.css">
<script src="jquery-1.11.0.min.js"></script>
<script type="text/javascript">

 $( document ).ready(
        function() {
            /*FUNCTION CALLED WHEN DATE IS CLICKED*/
			/* -- used to display the available appointment times on the day clicked */
            $('.calendarbutton').click(
                function( e ) {
                    e.preventDefault();
                    $.get(
                    	'https://localhost/estudio-2015/Calendar.php'
//                        'https://scheduling.engr.uky.edu/~beta/public_html/Calendar.php',
                        {
                            calendarday: $(this).val()
                        },
                        function( data, textStatus, jqXHR ) {
                            $( '#appPerDay' ).html( data );
                        },
                        'html'
                    );
                }
            );

		}

  );


  /* FUNCTION VALIDATES THE clientBooking FORM FIELDS */
  // -- ensures that all of the fields have been selected.
  function validateBooking()
  {
	var timeSelected = false;
	var valid = true; //  returned true if the all of the form fields are valid, false if not.
	var valueToValidate = document.forms["clientBooking"]["firstVisit"].value;
	if( valueToValidate == "Select" )
	{
		valid = false;
		document.getElementById("firstVisitError").innerHTML = "*";
	}
	else
	{
		document.getElementById("firstVisitError").innerHTML = "";
	}

	valueToValidate = document.forms["clientBooking"]["quantity"].value;
	if( valueToValidate == "Select" )
	{
		valid = false;
		document.getElementById("quantityError").innerHTML = "*";
    }
    else
    {
        document.getElementById("quantityError").innerHTML = "";
    }

	valueToValidate = document.forms["clientBooking"]["service"].value;
	if( valueToValidate == "Select" )
	{
		valid = false;
        document.getElementById("serviceError").innerHTML = "*";
    }
    else
    {
        document.getElementById("serviceError").innerHTML = "";
    }

	valueToValidate = document.forms["clientBooking"]["duration"].value;
	if( valueToValidate == "Select" )
	{
		valid = false;
        document.getElementById("durationError").innerHTML = "*";
    }
    else
    {
        document.getElementById("durationError").innerHTML = "";
    }

	// determine if one of the time radio buttons is selected.
	var timeSlots = document.getElementsByName( "startTime" );
	var length = timeSlots.length;
	for( i = 0; i < length; i++ )
	{
		if( timeSlots[i].checked )
		{
			timeSelected = true;
			// assign the value of the date selected to the hidden input in the clientBooking form.
			document.forms["clientBooking"]["time"].value = timeSlots[i].value;
		}
	}

	// assemble the error message
	var errorMessage = "";
	if( !valid ) { errorMessage = "Please make selections for all of the fields.  The ones you missed are marked."; }
	if( !timeSelected )
	{
		errorMessage = errorMessage + "<br>Select a date and time from the calendar to proceed.";
		valid = false;  // set valid to false here to cancel the submit.
	}

	// display the error message
	document.getElementById("validationError").innerHTML = errorMessage;
	return valid;

  }



</script>


</head>

<body>

	<!-- HEADER / LOGO -->
	<div id="headerbox" style="min-width: 1700px;">  <!-- inline style to make the header bar on this page extend
													even with scrolling -->
		<div id="headerbuttonholderleft">
			<a href="clientInfo.php#tab1" class="headerbutton" > <img src="backArrowW.png" style="height: 20px; width:20px; position: relative; top:2px; display:inline; "/>  Back </a>
		</div>
		<div id="headerbuttonholderright">

		</div>

	</div>
	<!-- CONTENT BOX -->

	<div id="contentholder" style="min-width: 1500px;">
		<P align="center">
			<FONT style="font-size: 22pt" name="WelcomeDirections" color="#003470">
				<b>Please fill out the following to make an appointment.</b>
			</FONT>
		</P>

		<div id="registrationholder" style="position:relative; left: 30px; top: 30px; text-align:center; padding-left: 10px; width: 300px;"  >
			<P>
			<form action="ClientBooking.php" name="clientBooking" onsubmit="return validateBooking()" method="post">
			  	<font size="3" face="Tahoma">
					<br>
					<font id="firstVisitError" class="validation"></font>
					Is this your first visit to the eStudio? <br>
					<select name="firstVisit" style="margin-top:10px;">
						<option value="Select">Select</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>

					</select>

						<br>
						<br>
					<font id="quantityError" class="validation" style="left:10px;"></font>
					How many members will be in your group? <br>
					<select name="quantity" style="margin-top:10px;">
						<option value="Select">Select</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5+">5+</option>
					</select>
					<br>
					<br>

					<font id="serviceError" class="validation"></font>
					What do you need help with?
					<select name="service" style="margin-top:10px;">
							<option value="Select">Select</option>
							<option value="Writing Help">Writing Help</option>
							<option value="Writing Help for ESL Student">Writing Help for ESL Student</option>
							<option value="Oral Presentation Help">Oral Presentation Help</option>
							<option value="Digital Media Help">Digital Media Help</option>
							<option value="Thesis or Dissertation Help">Thesis or Dissertation Help</option>
							<option value="EGR-201 Help">EGR-201 Help</option>
							<option value="Other">Other</option>
					</select>

					<br>
					<br>

					<font id="durationError" class="validation"></font>
					How much time will you need? <br>
					<select name="duration" style="margin-top:10px;">
							<option value="Select">Select</option>
							<option value="15">15 minutes</option>
							<option value="30">30 minutes</option>
							<option value="45">45 minutes</option>
							<option value="60">60 minutes</option>
					</select>

					<input type="hidden" name="time" value="" />

					<br>
					<br>
					Comments/Notes <br>
					<textarea rows="4" name="comment" form="clientBooking" maxlength="120" placeholder="Enter comment here..." style="width: 300px; resize: none; margin-top:10px;"></textarea>
					<br>
					<br>

					<!-- This question might better be suited to the appointment page -->

					<br>
				</font>
				<!--Click here to go to the booking page.-->
				<input type="submit" value="Make Appointment" class="bodybutton">

			</form>

			<div id="validationError" style="margin-top:20px; color: red;"> </div>
			<?php
				// this php is here to display an error message if the appointment that the user tried to make
				// collides with another appointment.  This can happen if the duration runs into another
				// appointment.
				if( isset( $_GET['conflict'] ) )
				{
					echo '<div style="margin-top:20px; color: red;"> The duration you selected will not work with the selected time.  Sorry for the inconvenience. </div>';
				}
			?>
			</P>
		</div>

		<div id="registrationholder" style="position:relative; left: 100px; top: 30px; width: 900px; height:523px;" >
			<!-- div for calendar. -->


			<?php
				// Populate an array of Month Names for the Calendar.
				$monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
									"August", "September", "October", "November", "December");
			?>
			<?php
				// get the current month and year.
				if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
				if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
			?>
			<?php
				// Initialize variables and set up wrap-arounds for prev and next years.
				$cMonth = $_REQUEST["month"];
				$cYear = $_REQUEST["year"];

				$prev_year = $cYear;
				$next_year = $cYear;
				$prev_month = $cMonth-1;
				$next_month = $cMonth+1;

				if ($prev_month == 0 ) {
					$prev_month = 12;
					$prev_year = $cYear - 1;
				}
				if ($next_month == 13 ) {
					$next_month = 1;
					$next_year = $cYear + 1;
				}
			?>

			<table width="200" style="border: 1px outset black; border-radius: 5px 5px 0px 0px; background:#cdcdcd; box-shadow: 0px 1px 3px 1px #360858; position: absolute; top: 30px; font-family: Tahoma; right: 30px;">
			<tr align="center">
			<td bgcolor="#562878" style="border-radius: 5px 5px 0px 0px; padding: 5px; font-family: Tahoma; color:#FFFFFF">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td width="50%" align="left">  <a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>" style="color:#FFFFFF">Previous</a></td>
			<td width="50%" align="right"><a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>" style="color:#FFFFFF">Next</a>  </td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td align="center">
			<table width="100%" border="0" cellpadding="2" cellspacing="2">
			<tr align="center">
				<td colspan="7" bgcolor="#6F5A83" style="color:#FFFFFF">
					<strong><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></strong>
				</td>
			</tr>
			<tr>
			<td align="center" bgcolor="#6F5A83" style="color:#FFFFFF"><strong>S</strong></td>
			<td align="center" bgcolor="#6E5A82" style="color:#FFFFFF"><strong>M</strong></td>
			<td align="center" bgcolor="#6E5A82" style="color:#FFFFFF"><strong>T</strong></td>
			<td align="center" bgcolor="#6E5A82" style="color:#FFFFFF"><strong>W</strong></td>
			<td align="center" bgcolor="#6E5A82" style="color:#FFFFFF"><strong>T</strong></td>
			<td align="center" bgcolor="#6E5A82" style="color:#FFFFFF"><strong>F</strong></td>
			<td align="center" bgcolor="#6E5A82" style="color:#FFFFFF"><strong>S</strong></td>
			</tr>

			<?php
			// Draw the days of the calendar.
			$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
			$maxday = date("t",$timestamp);
			$thismonth = getdate ($timestamp);
			$startday = $thismonth['wday'];
			for ($i=0; $i<($maxday+$startday); $i++) {
				if(($i % 7) == 0 ) echo "<tr>";
				if($i < $startday) echo "<td></td>";
				// each day is a submit button with name='calendarday' and a value of the date of the
				// button in yyyy-mm-dd format.
				else echo "<td align='center' valign='middle' height='20px' style='background:#9382A5; color:#fff;
						   box-shadow: inset 0px 0px 5px 0px #562878; border-radius: 5px 5px 0px 0px;'><button style='color: #FFFFFF;' id='calendarday' name='calendarday' value='".$cYear."-".str_pad($cMonth,2,'0',STR_PAD_LEFT)."-".str_pad(($i - $startday + 1),2,'0',STR_PAD_LEFT)."' class='calendarbutton'>".($i - $startday + 1)."</button></td>";
				if(($i % 7) == 6 ) echo "</tr>";
			}

			?>
			</table>
			</td>
			</tr>
			</table>
			<div 
			<div id="appPerDay" style="position: absolute; left: 30px; top: 30px; width: 650px; height: 450px; background: #cdcdcd; border: 1px solid black; box-shadow: 0px 1px 3px 0px #360858; border-radius: 5px; padding: 5px; overflow: auto;">
			</div>

			</div>

		<div style="position: absolute; bottom: 10px; left: 50%; margin-left: -250px; margin-top: 60px;">
            <P align="center" style="margin-top: 50px;">
                <FONT size = "3" face ="Tahoma">
                    <br> The eStudio is located in room 108 <a href="http://maps.uky.edu/campusmap/" style="color: #017338">RGAN</a>.
                    <br> eStudio hours are Monday-Thursday, 10:00 A.M. - 6:00 P.M.
                    <br> For more information go to:<a href="https://www.engr.uky.edu/students/estudio/"  style="color: #017338"> https://www.engr.uky.edu/students/estudio/
                </FONT>
            </P>
	    </div>


		</div>


</body>

</html>
