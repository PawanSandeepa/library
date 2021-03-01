<?php
	if (isset($_POST['upload_img'])) {
		$file_name = $_POST['file_name'];
		$base64_img = $_POST['cropped_img'];

		$image=explode(',', $base64_img);
		$upload_img=base64_decode($image[1]);
		$file_uploaded=file_put_contents('../img/member/profilepic'.$file_name, $upload_img);
		if (!$file_uploaded) {
			header('Location:upload_pic.php?file_upload_fail');
		}
	}
	header('Location:member_profile.php?file_upload_successful');

?>