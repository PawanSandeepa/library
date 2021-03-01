<?php session_start(); ?>

<?php
	$navi='';
	if (isset($_SESSION['job_position']) and isset($_SESSION['id'])) {
		//echo $_SESSION['job_position'];
		if ($_SESSION['job_position']=="assistant" or $_SESSION['job_position']=="admin" ){
			
		}else{
			header('Location:../php/login.php?you_can_not_access');
		}
		
		$job_position=$_SESSION['job_position'];
		//$user_id=$_SESSION['id'];
		if ($job_position=='admin') {
			$navi="<li><a href=\"survey_list.php\" id=\"survey_list\">List Of Survey</a></li>";
			$navi.="<li><a href=\"add_book_survey.php\" id=\"add_book_survey\">Add Book For Survey</a></li>";
			$navi.="<li><a href=\"remove_book_survey.php\" id=\"remove_book_survey\">Remove Book From Survey</a></li>";
			$navi.="<li><a href=\"current_input.php\" id=\"current_input\">Current Input</a></li>";
			
			//$navi.="<li><a href=\"current_report.php\" id=\"current_report\">Current Report</a></li>";
			$navi.="<li><a href=\"get_report.php\" target=\"_blank\" id=\"get_report\">Get Survey Report</a></li>";
		}elseif ($job_position=='assistant') {
			$navi="<li><a href=\"survey_list.php\" id=\"survey_list\">List Of Survey</a></li>";
			$navi.="<li><a href=\"add_book_survey.php\" id=\"add_book_survey\">Add Book For Survey</a></li>";
			$navi.="<li><a href=\"current_input.php\" id=\"current_input\">Current Input</a></li>";
			
			//$navi.="<li><a href=\"current_report.php\" id=\"current_report\">Current Report</a></li>";
			
		}else{
			header('Location:../php/login.php?can_not_access');
		}
	}else{
		header('Location:../php/login.php?have_not_job_position');

	}
	

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>
	<div class="menunavi" id="test">
		<nav class="menu">
			<ul class="menu">
				<?php echo $navi; ?>
			</ul>
			
		</nav>
	</div>

	<div class="includeone">
		<?php //require_once('footer.php') ?>
	</div>
</body>
</html>