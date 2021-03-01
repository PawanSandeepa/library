<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('../connection/tempconn.php'); ?>
<?php require_once('external.php'); ?>

<?php
	$error=array();
	$lenth_error=array();
	$ok=array();

	if (isset($_GET['id'])) {
		$id=$_GET['id'];
		//echo "in get<br>";
		$get_book_detail="SELECT id,name,category_number,writer,statu,printed_date,price,reference FROM book where id='{$id}'";
		$rget_book_detail=mysqli_query($admin_conn,$get_book_detail);
		if ($rget_book_detail) {
			while ($detail=mysqli_fetch_assoc($rget_book_detail)) {
				$id=$detail['id'];
				$name=$detail['name'];
				$category_number=$detail['category_number'];
				$writer=$detail['writer'];
				$statu=$detail['statu'];
				$printed_date=$detail['printed_date'];
				$price=$detail['price'];
				$reference=$detail['reference'];

				$check_id="select id from deleted_book where id='{$id}'";

				$check_id_result=mysqli_query($admin_conn,$check_id);
				//echo "got the detail<br>";
				if ($check_id_result) {
					if (mysqli_num_rows($check_id_result)>=1) {
						$error[]='this book is already deleted';
					}
				}

				if(empty($error) && empty($lenth_error)){
					echo "not error in first check<br>";
					$day=date('Y-m-d');
					$query="INSERT INTO deleted_book";
					$query.="(id,name,category_number,writer,statu,printed_date,price,reference,deleted_date)";
					$query.="VALUES('{$id}','{$name}','{$category_number}','{$writer}','{$statu}','{$printed_date}','{$price}','{$reference}','{$day}')";

					$query_result=mysqli_query($admin_conn,$query);

					if($query_result){

						$delete_recode="DELETE FROM book WHERE id='{$id}' limit 1";
						$delete_trance="DELETE FROM transactions WHERE book_id='{$id}' limit 1";
						$delete_survey="DELETE FROM survey_book WHERE id='{$id}' limit 1";

						$rdelete_recode=mysqli_query($admin_conn,$delete_recode);
						$rdelete_trance=mysqli_query($admin_conn,$delete_trance);
						$rdelete_survey=mysqli_query($admin_conn,$delete_survey);
						if ($rdelete_recode AND $rdelete_trance AND $rdelete_survey) {
							$ok[]="recodes added delete table..";
							//echo"recodes added delete table..<br>";

							$id='';
							$name='';
							$category_number='';
							$writer='';
							$statu='';
							$printed_date='';
							$price='';
							$reference='';

							header('Location:book_list.php?recode was delete');
						}
						
					}else{
						$error[]="recodes can't add to delete table";
					}
				}//without error...
			}
		}
	}else{
		$error[]="didn't passed id";
	}




?>