<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('external.php'); ?>


<?php 

	$error=array();
	$lenth_error=array();
	$ok=array();
	//echo "in php";

	$id='';
	$f_name='';
	$l_name='';
	$address='';
	$mobile_number='';
	$e_mail='';
	$nic='';
	$job_position='';
	$spassword='';

	$user_id='';
	if (isset($_SESSION['job_position'])) {
		$current_job_position=$_SESSION['job_position'];
		if ($current_job_position=="admin") {
			if (isset($_GET['id'])) {
				$user_id=$_GET['id'];
			}
		}elseif ($job_position=="assistant") {
			header('Location:staff_interface?error=can\'t accses that page');
		}else{
			header('Location:../index.php');
		}
	}

	$query="SELECT id,f_name,l_name,address,mobile_number,e_mail,nic,job_position from staff where id='{$user_id}'";
	$rquery=mysqli_query($admin_conn,$query);
	if ($rquery) {
		while ($detail=mysqli_fetch_assoc($rquery)) {
			$id=$detail['id'];
			$f_name=$detail['f_name'];
			$l_name=$detail['l_name'];
			$address=$detail['address'];
			$mobile_number=$detail['mobile_number'];
			$e_mail=$detail['e_mail'];
			$nic=$detail['nic'];
			$this_job_position=$detail['job_position'];

		}
		

	}
	if(isset($_POST['submit'])){

		//check empty fild......

		$req_field = array('id','f_name','l_name','address','mobile_number','nic','this_job_position','spassword');


		$error=array_merge($error, check_empty($req_field));

		//check lenth ..........

		$max_length = array('id'=>7,'f_name'=>20,'l_name'=>30,'address'=>100,'mobile_number'=>11,'e_mail'=>50,'nic'=>10,'spassword'=>10);

		$lenth_error=array_merge($lenth_error, check_length($max_length));


		//$id=mysqli_real_escape_string($admin_conn,$_POST['id']);
		$f_name=mysqli_real_escape_string($admin_conn,$_POST['f_name']);
		$l_name=mysqli_real_escape_string($admin_conn,$_POST['l_name']);
		$address=mysqli_real_escape_string($admin_conn,$_POST['address']);
		$mobile_number=mysqli_real_escape_string($admin_conn,$_POST['mobile_number']);
		$e_mail=mysqli_real_escape_string($admin_conn,$_POST['e_mail']);
		$nic=mysqli_real_escape_string($admin_conn,$_POST['nic']);
		$this_job_position=mysqli_real_escape_string($admin_conn,$_POST['this_job_position']);
		//$spassword=mysqli_real_escape_string($admin_conn,$_POST['spassword']);


		//echo $gender;
		

		if(empty($error) && empty($lenth_error)){
			//echo "doing code";
			$query="UPDATE staff SET";
			$query.="id='{$id}',f_name='{$f_name}',l_name='{$l_name}',address='{$address}',mobile_number='{$mobile_number}',e_mail='{$e_mail}',nic='{$nic}',job_position='{$this_job_position}')";
			$query.="WHERE id='{$id}'";

			$query_result=mysqli_query($admin_conn,$query);

			if($query_result){

				$ok[]="updated recodes..";

				$id='';
				$f_name='';
				$l_name='';
				$address='';
				$mobile_number='';
				$e_mail='';
				$nic='';
				$job_position='';
				$spassword='';
				//header('Location :register_members.php?recode was updated');
			}else{
				$error[]="recodes aren't updated";
			}
		}//without error...

	}//submit..............


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>staff register</title>
	<link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>

	<div class="register" style="background-color: white">
		<form action="register_staff.php" method="post">
			<fieldset>
				<legend><h1>staff register form</h1></legend>
				
					<!--print error masseges...-->
					<?php 
						print_error($error,$lenth_error);
						print_ok($ok);

					?>
				
				
				<p><label>new id</label><input class="txt" type="text" name="id" <?php echo 'value="'.$id.'"';?>disabled></p>
				<p><label>first name</label><input class="txt" type="text" name="f_name" <?php echo 'value="'.$f_name.'"';?>></p>
				<p><label>last name</label><input class="txt" type="text" name="l_name" <?php echo 'value="'.$l_name.'"';?>></p>
				<p><label>address</label><input class="txt" type="text" name="address" <?php echo 'value="'.$address.'"';?>></p>

				<p><label>mobile_number</label><input class="txt" type="text" name="mobile_number" <?php echo 'value="'.$mobile_number.'"';?>></p>
				<p><label>e_mail</label><input class="txt" type="text" name="e_mail" <?php echo 'value="'.$e_mail.'"';?>></p>
				<p><label>nic</label><input class="txt" type="text" name="nic" <?php echo 'value="'.$nic.'"';?>></p>
				<p><label>job_position</label>
					<select name="this_job_position">
						<option value="assistant"<?php if($this_job_position == 'assistant'): ?> selected="selected"<?php endif; ?>>assistant</option>
						<option value="admin"<?php if($this_job_position == 'admin'): ?> selected="selected"<?php endif; ?>>admin</option>
					</select>
				
				<p><label>&nbsp;</label><button class="add" type="submit" name="submit">update</button></p>

			</fieldset>
		</form>
	</div><!--register div-->
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>
<?php mysqli_close($admin_conn) ?>


