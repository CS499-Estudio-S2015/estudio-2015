<?php
include('Config.php');
include('reportingQueries.php');
?>

<html>
<head>
	<title>Reporting Interface</title>
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
			<a href="reporting.php" class="headerbutton" style="position:relative; top:-4px;"> Reporting </a>
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
		<div class="report-grid">
			<?php getAllApptByYear(); ?>
		</div>
		<div class="report-grid">
			<?php getApptFromMajorByMonth(); ?>
		</div>
	</div>

</body>

</html>

