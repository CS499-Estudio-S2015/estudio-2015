<?php
function randomTable($legend, $head, $rows, $cols, $min, $max) {
	echo "<table>\n";
	for ($i = 0; $i < $rows; $i++) {
		echo "<tr>";
		for ($j = 0; $j < $cols; $j++) {
			if ($i == 0) {
				echo "<td>" . $head[$j] . "</td>";
			} else {
				if ($j == 0) {
					echo "<td>" . $legend[$i] . "</td>";
				} else {
					echo "<td>" . rand($min,$max) . "</td>";
				}
			}
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
}

$head = array('', 'Feb', 'Jan', 'Dec', 'Nov', 'Oct', 'Sept');
$sem = array('', 'Spring 2015', 'Fall 2014', 'Spring 2014', 'Fall 2013', 'Spring 2013');
$byyear = array('', '2014 - 2015', '2013 - 2014', '2012 - 2013');

?>

<html>
	<head>
		<title>eStudio Mockup Reporting Interface</title>
		<link rel="stylesheet" type="text/css" href="estudiostyle.css">
	</head>

	<body>

		<div id="headerbox"> 
			<div id="headerbuttonholderleft">
				<font size="5" face="Tahoma" style="position:relative; top:-4px;"> eStudio </font>
				<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Upcoming </a>
				<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Tutors </a>
				<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Schedule </a>
				<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Reporting </a>
				<a href="#" class="headerbutton" style="position:relative; top:-4px; opacity:0.3;"> Disable </a>
				<a href="#" class="headerbutton" style="position:relative; top:-4px;"> Help </a>
			</div>
			<div id="headerbuttonholderright">
				<a href="index.php" class="headerbutton">Log Out</a>
			</div>
		</div>

		<div id="contentholder">
			<div class="report-select">
				<div class="report-select-item"><a href="mockup.php"><img src="img/current.png"></a></div>
				<div class="report-select-item"><img src="img/history-active.png"></div>
				<div class="report-select-item"><a href="mockup-b.php"><img src="img/charts.png"></a></div>
			</div>

			<div class="report-grid">
				<h2>Overall Performance</h2>
				<div class="report-table">
					<?php
						$overall = array('', 'Num. of Appointments', 'Num. of Participants', 'Newly Registered Clients');

						randomTable($overall, $head, 4, 7, 5, 45);
					?>
				</div>
				<br />
				<div style="display: inline-block; margin-left: 32px; margin-top: 8px;">
					<input type="radio" checked>By Month
					<input type="radio">By Semester
					<input type="radio">By Academic Year
				</div>
			</div>
			<div class="report-grid">
				<h2>Service</h2>
				<div class="report-table">
					<?php
						$service = array('', 'Writing Help', 'Writing Help for ESL Student', 'Oral Presentation Help', 'Digital Media Help', 'Thesis or Dissertation Help', 'EGR201 Help', 'Other');

						randomTable($service, $sem, 8, 6, 1, 15);
					?>
				</div>
				<br />
				<div style="display: inline-block; margin-left: 32px; margin-top: 8px;">
					<input type="radio">By Month
					<input type="radio" checked>By Semester
					<input type="radio">By Academic Year
				</div>
			</div>
			<div class="report-grid">
				<h2>Student Year</h2>
				<div class="report-table">
					<?php
						$year = array('', 'Freshman', 'Sophomore', 'Junior', 'Senior', 'Graduate', 'Staff', 'Other');

						randomTable($year, $byyear, 8, 4, 1, 15);
					?>
				</div>
				<br />
				<div style="display: inline-block; margin-left: 32px; margin-top: 8px;">
					<input type="radio">By Month
					<input type="radio">By Semester
					<input type="radio" checked>By Academic Year
				</div>
			</div>
			<div class="report-grid">
				<h2>Major</h2>
				<div class="report-table">
					<?php
						$major = array('', 'Biosystems & Agricultural Engineering', 'Chemical Engineering', 'Civil Engineering', 'Computer Engineering', 'Computer Science', 'Other');

						randomTable($major, $byyear, 7, 4, 1, 15);
					?>
				</div>
				<br />
				<div style="display: inline-block; margin-left: 32px; margin-top: 8px;">
					<input type="radio">By Month
					<input type="radio">By Semester
					<input type="radio" checked>By Academic Year
				</div>
			</div>
			<div class="report-grid">
				<h2>Required Visit</h2>
				<div class="report-table">
					<?php
						$required = array('', 'Yes', 'No');

						randomTable($required, $head, 3, 7, 1, 15);
					?>
				</div>
				<br />
				<div style="display: inline-block; margin-left: 32px; margin-top: 8px;">
					<input type="radio" checked>By Month
					<input type="radio">By Semester
					<input type="radio">By Academic Year
				</div>
			</div>
			<div class="report-grid">
				<h2>First Visit</h2>
				<div class="report-table">
					<?php
						$first = array('', 'Yes', 'No');

						randomTable($first, $sem, 3, 6, 1, 15);
					?>
				</div>
				<br />
				<div style="display: inline-block; margin-left: 32px; margin-top: 8px;">
					<input type="radio">By Month
					<input type="radio" checked>By Semester
					<input type="radio">By Academic Year
				</div>
			</div>
			<div class="report-grid">
				<h2>English Second Language</h2>
				<div class="report-table">
					<?php
						$esl = array('', 'Yes', 'No');

						randomTable($esl, $head, 3, 7, 1, 15);
					?>
				</div>
				<br />
				<div style="display: inline-block; margin-left: 32px; margin-top: 8px;">
					<input type="radio" checked>By Month
					<input type="radio">By Semester
					<input type="radio">By Academic Year
				</div>
			</div>
		</div>


	</body>
</html>