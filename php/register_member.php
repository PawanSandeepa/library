<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('external.php'); ?>


<?php 

	if (isset($_SESSION['job_position'])) {
		$job_position=$_SESSION['job_position'];
		if ($job_position!="admin" and $job_position!="assistant") {
			header('Location:../index.php');
		}
	}else{
		header('Location:login.php?page=register_member');
	}

	$error=array();
	$lenth_error=array();
	$ok=array();
	//echo "in php";

	if (isset($_GET['$msg'])) {
		$msg=$_GET['$msg'];
		echo '<script type="text/javascript">';
            echo 'alert('.$msg.')';
        echo '</script>';
	}

	$id='';
	$f_name='';
	$l_name='';
	$initials='';
	$address='';
	$dob='';
	$gender='';
	$phone_mobile='';
	$phone_home='';
	$nic='';
	$address_of_working='';
	$working_place='';
	$grade='';
	$email='';
	$registered_date='';
	$caretaker_name='';
	$caretaker_address='';
	$caretaker_nic='';
	$guarantor_name='';
	$guarantor_address='';
	$guarantor_post='';
	$guarantor_working_place='';
	$mpassword='';


	if(isset($_POST['submit'])){

		//check empty fild......

		$req_field = array('id','f_name','l_name','address');


		$error=array_merge($error, check_empty($req_field));

		//check lenth ..........

		$max_length = array('id'=>7,'f_name'=>20,'l_name'=>30,'initials'=>15,'address'=>100,'gender'=>6,'phone_mobile'=>11,'phone_home'=>11,'nic'=>10,'address_of_working'=>100,'working_place'=>100,'grade'=>20,'email'=>50,'caretaker_name'=>50,'caretaker_address'=>100,'caretaker_nic'=>10,'guarantor_name'=>50,'guarantor_address'=>100,'guarantor_post'=>20,'guarantor_working_place'=>100);

		$lenth_error=array_merge($lenth_error, check_length($max_length));


		$id=mysqli_real_escape_string($admin_conn,$_POST['id']);
		$f_name=mysqli_real_escape_string($admin_conn,$_POST['f_name']);
		$l_name=mysqli_real_escape_string($admin_conn,$_POST['l_name']);
		$initials=mysqli_real_escape_string($admin_conn,$_POST['initials']);
		$address=mysqli_real_escape_string($admin_conn,$_POST['address']);
		$dob=mysqli_real_escape_string($admin_conn,$_POST['dob']);
		$gender=mysqli_real_escape_string($admin_conn,$_POST['gender']);
		$phone_mobile=mysqli_real_escape_string($admin_conn,$_POST['phone_mobile']);
		$phone_home=mysqli_real_escape_string($admin_conn,$_POST['phone_home']);
		$nic=mysqli_real_escape_string($admin_conn,$_POST['nic']);
		$address_of_working=mysqli_real_escape_string($admin_conn,$_POST['address_of_working']);
		$working_place=mysqli_real_escape_string($admin_conn,$_POST['working_place']);
		$grade=mysqli_real_escape_string($admin_conn,$_POST['grade']);
		$email=mysqli_real_escape_string($admin_conn,$_POST['email']);
		$registered_date=mysqli_real_escape_string($admin_conn,$_POST['registered_date']);
		$caretaker_name=mysqli_real_escape_string($admin_conn,$_POST['caretaker_name']);
		$caretaker_address=mysqli_real_escape_string($admin_conn,$_POST['caretaker_address']);
		$caretaker_nic=mysqli_real_escape_string($admin_conn,$_POST['caretaker_nic']);
		$guarantor_name=mysqli_real_escape_string($admin_conn,$_POST['guarantor_name']);
		$guarantor_address=mysqli_real_escape_string($admin_conn,$_POST['guarantor_address']);
		$guarantor_post=mysqli_real_escape_string($admin_conn,$_POST['guarantor_post']);
		$guarantor_working_place=mysqli_real_escape_string($admin_conn,$_POST['guarantor_working_place']);
		//$mpassword=mysqli_real_escape_string($admin_conn,$_POST['mpassword']);


		//echo $gender;
		

		$hash_mpassword=sha1("12345");

		$check_id="select id from members where id='{$id}'";

		$check_id_result=mysqli_query($admin_conn,$check_id);

		if ($check_id_result) {
			if (mysqli_num_rows($check_id_result)>=1) {
				$error[]='id is already exixts';
			}
		}

		if(empty($error) && empty($lenth_error)){

			$query="INSERT INTO members";
			$query.="(id,f_name,l_name,initials,address,dob,gender,phone_mobile,phone_home,nic,address_of_working,working_place,grade,email,registered_date,caretaker_name,caretaker_address,caretaker_nic,guarantor_name,guarantor_address,guarantor_post,guarantor_working_place,mpassword)";
			$query.="VALUES('{$id}','{$f_name}','{$l_name}','{$initials}','{$address}','{$dob}','{$gender}','{$phone_mobile}','{$phone_home}','{$nic}','{$address_of_working}','{$working_place}','{$grade}','{$email}','{$registered_date}','{$caretaker_name}','{$caretaker_address}','{$caretaker_nic}','{$guarantor_name}','{$guarantor_address}','{$guarantor_post}','{$guarantor_working_place}','{$hash_mpassword}')";

			$query_result=mysqli_query($admin_conn,$query);

			if($query_result){

				$ok[]="added recodes..";

				//$id='';
				$f_name='';
				$l_name='';
				$initials='';
				$address='';
				$dob='';
				$gender='';
				$phone_mobile='';
				$phone_home='';
				$nic='';
				$address_of_working='';
				$working_place='';
				$grade='';
				$email='';
				$registered_date='';
				$caretaker_name='';
				$caretaker_address='';
				$caretaker_nic='';
				$guarantor_name='';
				$guarantor_address='';
				$guarantor_post='';
				$guarantor_working_place='';
				$mpassword='';
				header('Location:upload.php?id='.$id.'');
			}else{
				$error[]="recodes aren't added";
			}
		}//without error...

	}//submit..............


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>members register</title>
	<link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
	<div>
		<?php include('header.php'); ?>
		<?php include('banner.php'); ?>
	</div>

	<div class="register" style="background-color: white">
		<form action="register_member.php" method="post">
			<fieldset>
				<legend><h1>members register form</h1></legend>
				
					<!--print error masseges...-->
					<?php 
						print_error($error,$lenth_error);
						print_ok($ok);

					?>
				
				
				<p><label>member id</label><input class="txt" type="text" name="id" <?php echo 'value="'.$id.'"';?>></p>
				<p><label>first name</label><input class="txt" type="text" name="f_name" <?php echo 'value="'.$f_name.'"';?>></p>
				<p><label>last name</label><input class="txt" type="text" name="l_name" <?php echo 'value="'.$l_name.'"';?>></p>
				<p><label>initials</label><input class="txt" type="text" name="initials" <?php echo 'value="'.$initials.'"';?>></p>
				<p><label>address</label><input class="txt" type="text" name="address" <?php echo 'value="'.$address.'"';?>></p>
				<p><label>dob</label><input class="txt" type="date" name="dob"></p>
				<p><label>gender</label>
					<select name="gender">
						<option value="male">male</option>
						<option value="female">female</option>
					</select>
				</p>
				<p><label>phone_mobile</label><input class="txt" type="text" name="phone_mobile" <?php echo 'value="'.$phone_mobile.'"';?>></p>
				<p><label>phone_home</label><input class="txt" type="text" name="phone_home" <?php echo 'value="'.$phone_home.'"';?>></p>
				<p><label>nic</label><input class="txt" type="text" name="nic" <?php echo 'value="'.$nic.'"';?>></p>
				<p><label>address_of_working</label><input class="txt" type="text" name="address_of_working" <?php echo 'value="'.$address_of_working.'"';?>></p>
				<p><label>working_place</label><input class="txt" type="text" name="working_place" <?php echo 'value="'.$working_place.'"';?>></p>
				<p><label>grade</label><input class="txt" type="text" name="grade" <?php echo 'value="'.$grade.'"';?>></p>
				<p><label>email</label><input class="txt" type="text" name="email" <?php echo 'value="'.$email.'"';?>></p>
				<p><label>registered_date</label><input class="txt" type="date" name="registered_date" <?php echo 'value="'.$registered_date.'"';?>></p>
				<p><label>caretaker_name</label><input class="txt" type="text" name="caretaker_name" <?php echo 'value="'.$caretaker_name.'"';?>></p>
				<p><label>caretaker_address</label><input class="txt" type="text" name="caretaker_address" <?php echo 'value="'.$caretaker_address.'"';?>></p>
				<p><label>caretaker_nic</label><input class="txt" type="text" name="caretaker_nic" <?php echo 'value="'.$caretaker_nic.'"';?>></p>
				<p><label>guarantor_name</label><input class="txt" type="text" name="guarantor_name" <?php echo 'value="'.$guarantor_name.'"';?>></p>
				<p><label>guarantor_address</label><input class="txt" type="text" name="guarantor_address" <?php echo 'value="'.$guarantor_address.'"';?>></p>
				<p><label>guarantor_post</label><input class="txt" type="text" name="guarantor_post" <?php echo 'value="'.$guarantor_post.'"';?>></p>
				<p><label>guarantor_working_place</label><input class="txt" type="text" name="guarantor_working_place" <?php echo 'value="'.$guarantor_working_place.'"';?>></p>
				<p><label>mpassword</label><input class="txt" type="text" name="mpassword" value="12345" <?php echo 'value="'.$mpassword.'"';?> disabled></p>
				<p><label>&nbsp;</label><button class="add" type="submit" name="submit">add</button></p>

			</fieldset>
		</form>
	</div><!--register div-->


	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>
<?php mysqli_close($admin_conn) ?>


