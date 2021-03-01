<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('../connection/tempconn.php'); ?>
<?php require_once('external.php'); ?>
<?php
	$c_list='';
	$get_c=NULL;
	$query='';
	if (!empty($get_c) or $get_c!='') {
		$query="SELECT category_number,category_name FROM category where category_number LIKE '%{$get_c}%' or category_name LIKE '%{$get_c}%'";
	}else{
		$query="SELECT category_number,category_name FROM category";
	}
	
	$rquery=mysqli_query($member1_conn,$query);
	if ($rquery) {
		$c_list.='<div class="container">';
			while ($detail=mysqli_fetch_assoc($rquery)) {
				$category_number=$detail['category_number'];
				$category_name=$detail['category_name'];
				$book_detail="SELECT id FROM book where category_number='{$category_number}'";
				$rbook_detail=mysqli_query($member1_conn,$book_detail);
				if ($rbook_detail){
					$book_count=mysqli_num_rows($rbook_detail);
					$c_list.='<div class="card">';
						$c_list.='<div class="face">';
							$c_list.='<div class="content1">';
								$c_list.='<a href="../index.php?category='.$category_number.'">';
							    $c_list.='<h3><b>'.$category_number.'</b></h3>';
							    $c_list.='<h3><b>'.$category_name.'</b></h3>';
							$c_list.='</div>';
							$c_list.='<div class="content2">';
							    $c_list.='<p>'.$book_count.' books have<br>';
							    $c_list.='under the this category</a></p>';
				    		$c_list.='</div>';
						$c_list.='</div>';
				    $c_list.='</div>';
				}
			}
		$c_list.='</div>';
	}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>category</title>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>
	<div class="top-bar-search">
		<form method="post" action="category.php">
			<input class="get" type="text" placeholder="Search category" name="get_c" size="30" style="border-style: solid; border-color:blue;">
			<button type="submit" name="submit"></button>
		</form>
	</div>
	<?php echo $c_list ?>
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>