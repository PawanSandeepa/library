<?php session_start(); ?>

<?php
	$navi='';
	if (isset($_SESSION['job_position']) and isset($_SESSION['id'])) {
		//echo $_SESSION['job_position'];
		if ($_SESSION['job_position']!="assistant" AND $_SESSION['job_position']!="admin" ){
			header('Location:login.php?can_not_access');
		}
		
		$job_position=$_SESSION['job_position'];
		$user_id=$_SESSION['id'];
		if ($job_position=='admin') {

			$navi="<li><a href=\"#\" id=\"home\">Home</a></li>";
			$navi.="<li><a href=\"book_issue.php\" id=\"book_issue\">Issue Book</a></li>";
			$navi.="<li><a href=\"book_return.php\" id=\"book_return\">Return Book</a></li>";
			$navi.="<li><a href=\"add_book.php\" id=\"add_book\">Add Book</a></li>";
			$navi.="<li><a href=\"register_member.php\" id=\"register_member\">Register Member</a></li>";
			$navi.="<li><a href=\"register_staff.php\" id=\"register_staff\">Register Staff</a></li>";
			$navi.="<li><a href=\"member_list.php\" id=\"member_list\">Members List</a></li>";
			$navi.="<li><a href=\"book_list.php\" id=\"book_list\">Book List</a></li>";
			$navi.="<li><a href=\"deleted_book_list.php\" id=\"deleted_book_list\">Deleted Book List</a></li>";
			$navi.="<li><a href=\"edit_book.php\" id=\"edit_book\">Edit Book</a></li>";
			$navi.="<li><a href=\"edit_member.php\" id=\"edit_member\">Edit member</a></li>";
			$navi.="<li><a href=\"staff_profile.php\" id=\"staff_ownprofile\">Profile</a></li>";
			$navi.="<li><a href=\"edit_staff.php?id={$user_id}\" id=\"staff_edit_ownprofile\">Edit Profile</a></li>";
			$navi.="<li><a href=\"staff_list.php\" id=\"staff_list\">Staff  List</a></li>";
			$navi.="<li><a href=\"../survey_of_goods/survey_interface.php\" id=\"survey_interface\">Survey Interface</a></li>";
			$navi.="<li><a href=\"logout.php\" id=\"logout\"><font color=\"red\">Log Out</font></a></li>";
		}elseif ($job_position=='assistant') {

			$navi="<li><a href=\"#\" id=\"home\">Home</a></li>";
			$navi.="<li><a href=\"book_issue.php\" id=\"book_issue\">Issue Book</a></li>";
			$navi.="<li><a href=\"book_return.php\" id=\"book_return\">Return Book</a></li>";
			$navi.="<li><a href=\"add_book.php\" id=\"add_book\">Add Book</a></li>";
			$navi.="<li><a href=\"register_member.php\" id=\"register_member\">Register Member</a></li>";
			$navi.="<li><a href=\"member_list.php\" id=\"member_list\">Members List</a></li>";
			$navi.="<li><a href=\"book_list.php\" id=\"book_list\">Book List</a></li>";
			$navi.="<li><a href=\"edit_book.php\" id=\"edit_book\">Edit Book</a></li>";
			$navi.="<li><a href=\"edit_member.php\" id=\"edit_member\">Edit member</a></li>";
			$navi.="<li><a href=\"staff_profile.php\" id=\"staff_profile\">Profile</a></li>";
			$navi.="<li><a href=\"../survey_of_goods/survey_interface.php\" id=\"survey_interface\">Survey Interface</a></li>";
			$navi.="<li><a href=\"logout.php\" id=\"logout\"><font color=\"red\">Log Out</font></a></li>";
		}else{
			header('Location:login.php?can_not_access');
		}
	}else{
		header('Location:login.php?have_not_job_position');

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
<!--
	<script>
		window.onscroll = function() {myFunction()};

		function myFunction() {
		  if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
		    document.getElementById("test").className = "nmenunavi";
		  } else {
		    document.getElementById("test").className = "menunavi";
		  }
		}
	</script>
-->
	<div>
		<?php //require_once('footer.php') ?>
	</div>
</body>
</html>