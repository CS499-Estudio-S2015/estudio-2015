<?php
function randomTable($legend, $head, $rows, $cols, $min, $max) {
	echo "<table>\n";
	for ($i = 0; $i < $rows; $i++) {
		echo "<tr>";
		$random1 = (float)rand($min, $max);
		$random2 = (float)rand($min, $max);
		for ($j = 0; $j < $cols; $j++) {
			if ($i == 0) {
				echo "<td>" . $head[$j] . "</td>";
			} else {
				switch ($j) {
				case 0:
					echo "<td>" . $legend[$i] . "</td>";
					break;
				case 1:
					echo "<td>" . $random1 . "</td>";
					break;
				case 2:
					echo "<td>" . $random2 . "</td>";
					break;
				case 3:
					$change = (float)($random2 - $random1) / $random1 * 100;
					echo "<td>" . number_format($change, 2, '.', '') . "%</td>";
					break;
				default:
					break;
				}
			}
		}

		echo "</tr>\n";
	}

	echo "</table>\n";
}

$head = array('', 'Last Month', 'This Month', '% Change');

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
				<div class="report-select-item"><img src="img/current-active.png"></div>
				<div class="report-select-item"><a href="mockup-a.php"><img src="img/history.png"></a></div>
				<div class="report-select-item"><a href="mockup-b.php
					"><img src="img/charts.png"></a></div>
			</div>

			<div class="report-grid">
				<h2>Overall Performance</h2>
				<div class="report-table">
					<?php
						$overall = array('', 'Num. of Appointments', 'Num. of Participants', 'Newly Registered Clients');

						randomTable($overall, $head, 4, 4, 5, 45, true);
					?>
				</div>
			</div>
			<div class="report-grid">
				<h2>Service</h2>
				<div class="report-table">
					<?php
						$service = array('', 'Writing Help', 'Writing Help for ESL Student', 'Oral Presentation Help', 'Digital Media Help', 'Thesis or Dissertation Help', 'EGR201 Help', 'Other');

						randomTable($service, $head, 8, 4, 1, 15, true);
					?>
				</div>
			</div>
			<div class="report-grid">
				<h2>Academic Year</h2>
				<div class="report-table">
					<?php
						$year = array('', 'Freshman', 'Sophomore', 'Junior', 'Senior', 'Graduate', 'Staff', 'Other');

						randomTable($year, $head, 8, 4, 1, 15, true);
					?>
				</div>
			</div>
			<div class="report-grid">
				<h2>By Major</h2>
				<div class="report-table">
					<?php
						$major = array('', 'Biosystems & Agricultural Engineering', 'Chemical Engineering', 'Civil Engineering', 'Computer Engineering', 'Computer Science', 'Other');

						randomTable($major, $head, 7, 4, 1, 15, true);
					?>
				</div>
			</div>
			<div class="report-grid">
				<h2>Required Visit</h2>
				<div class="report-table">
					<?php
						$required = array('', 'Yes', 'No');

						randomTable($required, $head, 3, 4, 1, 15, true);
					?>
				</div>
			</div>
			<div class="report-grid">
				<h2>First Visit</h2>
				<div class="report-table">
					<?php
						$first = array('', 'Yes', 'No');

						randomTable($first, $head, 3, 4, 1, 15, true);
					?>
				</div>
			</div>
			<div class="report-grid">
				<h2>English Second Language</h2>
				<div class="report-table">
					<?php
						$esl = array('', 'Yes', 'No');

						randomTable($esl, $head, 3, 4, 1, 15, true);
					?>
				</div>
			</div>
		</div>


	</body>
</html>