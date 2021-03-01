<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('../php/external.php'); ?>

<?php
	$error=array();
	$lenth_error=array();
	$ok=array();

	$job_position='';

	if(isset($_SESSION['job_position'])){
		$job_position=$_SESSION['job_position'];
	}

	$missing_list='';
	$transaction_list='';
	$lt_list='';
	$total_count=0;
	if ($job_position=="admin" or $job_position=="assistant"){
		//geting the list of missing books...
		$query="SELECT id,model,state,description FROM survey_book WHERE state='missing'ORDER BY id";
		$rquery=mysqli_query($admin_conn,$query);
		if($rquery){
			if (mysqli_num_rows($rquery)>0) {
				$list_count=mysqli_num_rows($rquery);
				$total_count=$total_count+$list_count;
				//missing list table create...
				$missing_list.="<h1>missing list ({$list_count})</h1>";
				$missing_list.="<div style=\"overflow-x:auto;\">";
				$missing_list.="<table class=\"userlist\">";
				$missing_list.="<tr><th>id</th><th>model</th><th>state</th><th>description</th><th>edit</th></tr>";
				while($detail=mysqli_fetch_assoc($rquery)){	
					$book_id=$detail['id'];
					$missing_list.="<tr>";
						$missing_list.="<td><a href=\"../php/book_profile.php?id={$detail['id']}\" target=\"_blank\">{$detail['id']}</a></td>";
						$missing_list.="<td>{$detail['model']}</td>";
						$missing_list.="<td>{$detail['state']}</td>";
						$query="SELECT name,price FROM book WHERE id='{$detail['id']}' limit 1";
						$result_query=mysqli_query($admin_conn,$query);
						$name='';
						$price='';
						if ($result_query) {
							while ($book_detail=mysqli_fetch_assoc($result_query)) {
								$name=$book_detail['name'];
								$price=$book_detail['price'];
							}
						}
						$missing_list.="<td>{$detail['description']}, <b>book name:</b> {$name}, <b>price:</b> {$price}</td>";
						$missing_list.="<td><a href=\"edit_survey.php?id={$detail['id']}\" target=\"_blank\">edit</a></td>";
					$missing_list.="</tr>";
				}
				//end missing table...
				$missing_list.="</table>";
				$missing_list.="</div>";	
			}
		}else{
			$missing_list="no missing book";
		}

		//geting transaction book...
		$query="SELECT id,model,state,description FROM survey_book WHERE state='transaction'ORDER BY id";
		$rquery=mysqli_query($admin_conn,$query);

		if ($rquery) {
			if (mysqli_num_rows($rquery)>0) {
				$list_count=mysqli_num_rows($rquery);
				$total_count=$total_count+$list_count;
				//transaction list table create...
				$transaction_list.="<h1>transaction list ({$list_count})</h1>";
				$transaction_list.="<div style=\"overflow-x:auto;\">";
				$transaction_list.="<table class=\"userlist\">";
				$transaction_list.="<tr><th>id</th><th>model</th><th>state</th><th>description</th><th>edit</th></tr>";//transaction list of long time transaction table create...
				$lt_list.="<h2>long time transaction list</h2>";
				$lt_list.="<div style=\"overflow-x:auto;\">";
				$lt_list.="<table class=\"userlist\">";
				$lt_list.="<tr><th>id</th><th>model</th><th>state</th><th>description</th><th>edit</th></tr>";
				//while loop...
				while ($detail=mysqli_fetch_assoc($rquery)) {
					$book_id=$detail['id'];
					$trance="SELECT member_id,due_date from transactions where book_id='{$book_id}'";
					$rtrance=mysqli_query($admin_conn,$trance);
					if ($rtrance) {
						while ($get=mysqli_fetch_assoc($rtrance)) {
							$member_id=$get['member_id'];
							$sdue_date=$get['due_date'];
							$stoday=date('Y-m-d');
							$today=date_create($stoday);
							$due_date=date_create($sdue_date);
							$diff=date_diff($due_date,$today);
							//echo $diff->format("%R%a days");
							if ($diff->format("%R%a")>365) {
								$lt_list.="<tr>";
									$lt_list.="<td><a href=\"../php/book_profile.php?id={$detail['id']}\" target=\"_blank\">{$detail['id']}</a></td>";
									$lt_list.="<td>{$detail['model']}</td>";
									$lt_list.="<td>{$detail['state']}</td>";
									$lt_list.="<td>{$detail['description']}</td>";
									$lt_list.="<td><a href=\"edit_survey.php?id={$detail['id']}\" target=\"_blank\">edit</a></td>";
								$lt_list.="</tr>";
							}else{
								$transaction_list.="<tr>";
									$transaction_list.="<td><a href=\"../php/book_profile.php?id={$detail['id']}\" target=\"_blank\">{$detail['id']}</a></td>";
									$transaction_list.="<td>{$detail['model']}</td>";
									$transaction_list.="<td>{$detail['state']}</td>";
									$transaction_list.="<td>{$detail['description']}</td>";
									$transaction_list.="<td><a href=\"edit_survey.php?id={$detail['id']}\" target=\"_blank\">edit</a></td>";
								$transaction_list.="</tr>";
							}
						}
					}
					
				}
				//end transaction table...
				$transaction_list.="</table>";
				$transaction_list.="</div>";
				//end long time transaction table...
				$lt_list.="</table>";
				$lt_list.="</div>";
			}
			
		}

		$here_list='';
		$query="SELECT id,model,state,description FROM survey_book WHERE state='here' ORDER BY id";
		$rquery=mysqli_query($admin_conn,$query);
		if ($rquery) {
			$list_count=mysqli_num_rows($rquery);
			$total_count=$total_count+$list_count;
			//here list table create...
			$here_list.="<h1>in librrary list ({$list_count})</h1>";
			$here_list.="<div style=\"overflow-x:auto;\">";
			$here_list.="<table class=\"userlist\">";
			$here_list.="<tr><th>id</th><th>model</th><th>state</th><th>description</th><th>edit</th></tr>";
			while ($detail=mysqli_fetch_assoc($rquery)) {
				$here_list.="<tr>";
				$here_list.="<td><a href=\"../php/book_profile.php?id={$detail['id']}\" target=\"_blank\">{$detail['id']}</a></td>";
				$here_list.="<td>{$detail['model']}</td>";
				$here_list.="<td>{$detail['state']}</td>";
				
				$here_list.="<td>{$detail['description']}</td>";
				$here_list.="<td><a href=\"edit_survey.php?id={$detail['id']}\" target=\"_blank\">edit</a></td>";
				$here_list.="</tr>";
			}
			$here_list.="</table>";
			$here_list.="</div>";
		}

	}

	


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>current list</title>
	<link rel="stylesheet" href="../css/list.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>
	<main>
		<?php 
			print_error($error,$lenth_error);					
			print_ok($ok);
		?>
		
		<?php echo $missing_list; ?>

		
		<?php echo $transaction_list; ?>
		<?php echo $lt_list; ?>
		<br>
		<?php echo $here_list; ?>

		<br>
		<h1>Total book count is: <?php echo $total_count; ?></h1>
	</main>
	
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>