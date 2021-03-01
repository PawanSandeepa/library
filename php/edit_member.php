<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('external.php'); ?>


<?php 

	$error=array();
	$lenth_error=array();
	//echo "in php";
	if (isset($_GET['id'])) {
		$member_id=$_GET['id'];
	}else{
		header('Location:member_list.php');
        $error[]="didn't get member id";
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

	$get_detail="SELECT id,f_name,l_name,initials,address,dob,gender,phone_mobile,phone_home,nic,address_of_working,working_place,grade,email,registered_date,caretaker_name,caretaker_address,caretaker_nic,guarantor_name,guarantor_address,guarantor_post,
guarantor_working_place FROM members where id='{$member_id}' limit 1";
	$resut_get_detail=mysqli_query($admin_conn,$get_detail);
	if (!$resut_get_detail) {
		echo '<script type="text/javascript">';
			echo 'alert("can\'t get member details")';
		echo '</script>';
	}
	while ($detail=mysqli_fetch_assoc($resut_get_detail)) {
		$id=$detail['id'];
		$f_name=$detail['f_name'];
		$l_name=$detail['l_name'];
		$initials=$detail['initials'];
		$address=$detail['address'];
		$dob=$detail['dob'];
		$gender=$detail['gender'];
		$phone_mobile=$detail['phone_mobile'];
		$phone_home=$detail['phone_home'];
		$nic=$detail['nic'];
		$address_of_working=$detail['address_of_working'];
		$working_place=$detail['working_place'];
		$grade=$detail['grade'];
		$email=$detail['email'];
		$registered_date=$detail['registered_date'];
		$caretaker_name=$detail['caretaker_name'];
		$caretaker_address=$detail['caretaker_address'];
		$caretaker_nic=$detail['caretaker_nic'];
		$guarantor_name=$detail['guarantor_name'];
		$guarantor_address=$detail['guarantor_address'];
		$guarantor_post=$detail['guarantor_post'];
		$guarantor_working_place=$detail['guarantor_working_place'];
	}


	if(isset($_POST['edit'])){

		//check empty fild......

		$req_field = array('id','f_name','l_name','address');


		$error=array_merge($error, check_empty($req_field));

		//check lenth ..........

		$max_length = array('id'=>7,'f_name'=>20,'l_name'=>30,'initials'=>15,'address'=>100,'gender'=>6,'phone_mobile'=>11,'phone_home'=>11,'nic'=>10,'address_of_working'=>100,'working_place'=>100,'grade'=>20,'email'=>50,'caretaker_name'=>50,'caretaker_address'=>100,'caretaker_nic'=>10,'guarantor_name'=>50,'guarantor_address'=>100,'guarantor_post'=>20,'guarantor_working_place'=>100);

		$lenth_error=array_merge($lenth_error, check_length($max_length));


		//$id=mysqli_real_escape_string($admin_conn,$_POST['id']);
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
		

		if(empty($error) && empty($lenth_error)){

			$query="UPDATE members SET ";
			$query.="f_name='{$f_name}',l_name='{$l_name}',initials='{$initials}',address='{$address}',dob='{$dob}',gender='{$gender}',phone_mobile='{$phone_mobile}',phone_home='{$phone_home}',nic='{$nic}',address_of_working='{$address_of_working}',working_place='{$working_place}',grade='{$grade}',email='{$email}',registered_date='{$registered_date}',caretaker_name='{$caretaker_name}',caretaker_address='{$caretaker_address}',caretaker_nic='{$caretaker_nic}',guarantor_name='{$guarantor_name}',guarantor_address='{$guarantor_address}',guarantor_post'{$guarantor_post}',guarantor_working_place='{$guarantor_working_place}'";
			$query.="WHERE id='{$member_id}' LIMIT 1";

			$query_result=mysqli_query($admin_conn,$query);

			if($query_result){

				phpalert("recodes are edited");
				//header('Location:upload_pic.php');

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
				//$mpassword='';
				header('Location :member_profile.php?id='.$id.'');
			}else{
				phpalert("recodes can't update");
			}
		}//without error...

	}//submit..............


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>edit register details</title>
	<link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>

	<div class="register" style="background-color: white">
		<form action="edit_member.php" method="post">
			<fieldset>
				<legend><h1>members register form</h1></legend>
				
					<!--print error masseges...-->
					<?php 
						print_error($error,$lenth_error);

					?>
				
				
				<p><label>member id</label><input class="txt" type="text" name="id" <?php echo 'value="'.$id.'"';?> disabled></p>
				<p><label>first name</label><input class="txt" type="text" name="f_name" <?php echo 'value="'.$f_name.'"';?>></p>
				<p><label>last name</label><input class="txt" type="text" name="l_name" <?php echo 'value="'.$l_name.'"';?>></p>
				<p><label>initials</label><input class="txt" type="text" name="initials" <?php echo 'value="'.$initials.'"';?>></p>
				<p><label>address</label><input class="txt" type="text" name="address" <?php echo 'value="'.$address.'"';?>></p>
				<p><label>dob</label><input class="txt" type="date" name="dob"></p>
				<p><label>gender</label>
					<select name="gender">
						<option value="male"<?php if($gender == 'male'): ?> selected="selected"<?php endif; ?>>male</option>
						<option value="female"<?php if($gender == 'female'): ?> selected="selected"<?php endif; ?>>female</option>
					</select>
				<p><label>phone_mobile</label><input class="txt" type="text" name="phone_mobile" <?php echo 'value="'.$phone_mobile.'"';?>></p>
				<p><label>phone_home</label><input class="txt" type="text" name="phone_home" <?php echo 'value="'.$phone_home.'"';?>></p>
				<p><label>nic</label><input class="txt" type="text" name="nic" <?php echo 'value="'.$nic.'"';?>></p>
				<p><label>address_of_working</label><input type="text" name="address_of_working" <?php echo 'value="'.$address_of_working.'"';?>></p>
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
				
				<p><label>&nbsp;</label><button class="add" type="submit" name="edit">update</button></p>

			</fieldset>
		</form>
	</div><!--register div-->
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>
<?php mysqli_close($admin_conn) ?>


