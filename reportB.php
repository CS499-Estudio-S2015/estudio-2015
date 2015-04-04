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
				<?php 
					if (!isset($_POST['overall'])) {
						$_POST['overall'] = "month";
					}
					getHistoricOverall($_POST['overall']); 
					$overallMonthCheck = ($_POST['overall'] == "month") ? " checked" : "";
					$overallSemCheck = ($_POST['overall'] == "semester") ? " checked" : "";
					$overallYearCheck = ($_POST['overall'] == "year") ? " checked" : "";

					echo "\t\t\t\t<br />\n";
					echo "\t\t\t\t<input type='radio' name='overall' onclick='javascript: submit()' value='month'" . $overallMonthCheck . ">Monthly\n";
					echo "\t\t\t\t<input type='radio' name='overall' onclick='javascript: submit()' value='semester'" . $overallSemCheck . ">Semester\n";
					echo "\t\t\t\t<input type='radio' name='overall' onclick='javascript: submit()' value='year'" . $overallYearCheck . ">Yearly\n";
				?>				
			</form>
		</div>
		<div class="report-grid">
			<h2>Service</h2>
			<form action="" name="service" method="post">
				<?php 
					if (!isset($_POST['service'])) {
						$_POST['service'] = "month";
					}
					getHistoricService($_POST['service']); 
					$servMonthCheck = ($_POST['service'] == "month") ? " checked" : "";
					$servSemCheck = ($_POST['service'] == "semester") ? " checked" : "";
					$servYearCheck = ($_POST['service'] == "year") ? " checked" : "";

					echo "\t\t\t\t<br />\n";
					echo "\t\t\t\t<input type='radio' name='service' onclick='javascript: submit()' value='month'" . $servMonthCheck . ">Monthly\n";
					echo "\t\t\t\t<input type='radio' name='service' onclick='javascript: submit()' value='semester'" . $servSemCheck . ">Semester\n";
					echo "\t\t\t\t<input type='radio' name='service' onclick='javascript: submit()' value='year'" . $servYearCheck . ">Yearly\n";
				?>				
			</form>
		</div>
		<div class="report-grid">
			<h2>Academic Year</h2>
			<form action="" name="year" method="post">
				<?php 
					if(!isset($_POST['year'])) {
						$_POST['year'] = "month";
					}
					getHistoricYear($_POST['year']); 
					
					$yearMonthCheck = ($_POST['year'] == "month") ? " checked" : "";
					$yearSemCheck = ($_POST['year'] == "semester") ? " checked" : "";
					$yearYearCheck = ($_POST['year'] == "year") ? " checked" : "";
					

					echo "\t\t\t\t<br />\n";
					echo "\t\t\t\t<input type='radio' name='year' onclick='javascript: submit()' value='month'" . $yearMonthCheck . ">Monthly\n";
					echo "\t\t\t\t<input type='radio' name='year' onclick='javascript: submit()' value='semester'" . $yearSemCheck . ">Semester\n";
					echo "\t\t\t\t<input type='radio' name='year' onclick='javascript: submit()' value='year'" . $yearYearCheck . ">Yearly\n";
				?>				
			</form>
		</div>
		<div class="report-grid">
			<h2>Major</h2>
			<form action="" name="major" method="post">
				<?php 
					if(!isset($_POST['major'])) {
						$_POST['major'] = "month";
					}
					getHistoricMajor($_POST['major']); 
					
					$majorMonthCheck = ($_POST['major'] == "month") ? " checked" : "";
					$majorSemCheck = ($_POST['major'] == "semester") ? " checked" : "";
					$majorYearCheck = ($_POST['major'] == "year") ? " checked" : "";
					

					echo "\t\t\t\t<br />\n";
					echo "\t\t\t\t<input type='radio' name='major' onclick='javascript: submit()' value='month'" . $majorMonthCheck . ">Monthly\n";
					echo "\t\t\t\t<input type='radio' name='major' onclick='javascript: submit()' value='semester'" . $majorSemCheck . ">Semester\n";
					echo "\t\t\t\t<input type='radio' name='major' onclick='javascript: submit()' value='year'" . $majorYearCheck . ">Yearly\n";
				?>				
			</form>
		</div>
		<div class="report-grid">
			<h2>First Visit</h2>
			<form action="" name="firstVisit" method="post">
				<?php 
					if(!isset($_POST['firstVisit'])) {
						$_POST['firstVisit'] = "month";
					}
					getHistoricFirstVisit($_POST['firstVisit']); 
					
					$firstVisitMonthCheck = ($_POST['firstVisit'] == "month") ? " checked" : "";
					$firstVisitSemCheck = ($_POST['firstVisit'] == "semester") ? " checked" : "";
					$firstVisitYearCheck = ($_POST['firstVisit'] == "year") ? " checked" : "";
					

					echo "\t\t\t\t<br />\n";
					echo "\t\t\t\t<input type='radio' name='firstVisit' onclick='javascript: submit()' value='month'" . $firstVisitMonthCheck . ">Monthly\n";
					echo "\t\t\t\t<input type='radio' name='firstVisit' onclick='javascript: submit()' value='semester'" . $firstVisitSemCheck . ">Semester\n";
					echo "\t\t\t\t<input type='radio' name='firstVisit' onclick='javascript: submit()' value='year'" . $firstVisitYearCheck . ">Yearly\n";
				?>				
			</form>
		</div>
		<div class="report-grid">
			<h2>English as Second Language</h2>
			<form action="" name="english" method="post">
				<?php 
					if(!isset($_POST['english'])) {
						$_POST['english'] = "month";
					}
					getHistoricEnglish($_POST['english']); 
					
					$englishMonthCheck = ($_POST['english'] == "month") ? " checked" : "";
					$englishSemCheck = ($_POST['english'] == "semester") ? " checked" : "";
					$englishYearCheck = ($_POST['english'] == "year") ? " checked" : "";
					

					echo "\t\t\t\t<br />\n";
					echo "\t\t\t\t<input type='radio' name='english' onclick='javascript: submit()' value='month'" . $englishMonthCheck . ">Monthly\n";
					echo "\t\t\t\t<input type='radio' name='english' onclick='javascript: submit()' value='semester'" . $englishSemCheck . ">Semester\n";
					echo "\t\t\t\t<input type='radio' name='english' onclick='javascript: submit()' value='year'" . $englishYearCheck . ">Yearly\n";
				?>				
			</form>
		</div>
		<div class="report-grid">
			<?php 
				// TODO:
				// getHistoricRequired(); 
			?>
		</div>
	</div>

</body>

</html>