<?php
include('Config.php');
include('reportQueries.php');
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
			<h2>Overall Performance</h2>
			<form action="" name="overall" method="post">
				<?php //getCurrentOverall(); ?>
			</form>
		</div>
		<div class="report-grid">
			<h2>Service</h2>
			<form action="" name="service" method="post">
				<?php 
					getHistoricService($_POST['service']); 
					if(isset($_POST['service'])) {
						// echo "The button you have selected is " . $_POST['service'];
						$servMonthCheck = ($_POST['service'] == "month") ? " checked" : "";
						$servSemCheck = ($_POST['service'] == "semester") ? " checked" : "";
						$servYearCheck = ($_POST['service'] == "year") ? " checked" : "";

						echo "\t\t\t\t<br />\n";
						echo "\t\t\t\t<input type='radio' name='service' onclick='javascript: submit()' value='month'" . $servMonthCheck . ">Monthly\n";
						echo '<input type="radio" name="service" onclick="javascript: submit()" value="semester"' . $servSemCheck . '>Semester';
						echo '<input type="radio" name="service" onclick="javascript: submit()" value="year"' . $servYearCheck . '>Yearly';
					}
				?>				
			</form>
		</div>
		<div class="report-grid">
			<h2>Academic Year</h2>
			<?php //getCurrentYear(); ?>
		</div>
		<div class="report-grid">
			<h2>Major</h2>
			<?php //getCurrentMajor(); ?>
		</div>
		<div class="report-grid">
			<h2>First Visit</h2>
			<?php //getCurrentFirstVisit(); ?>
		</div>
		<div class="report-grid">
			<h2>English as Second Language</h2>
			<?php //getCurrentEnglish(); ?>
		</div>
		<div class="report-grid">
			<?php 
				// TODO:
				// getCurrentRequired(); 
			?>
		</div>
	</div>

</body>

</html>