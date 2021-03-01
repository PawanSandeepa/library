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

	$list='';

	//geting the list of books...
	//$query="SELECT id,f_name,l_name,address,phone_mobile,email FROM members ORDER BY f_name";

	$dir = "last_surveys/";

			if ($job_position=="admin" or $job_position=="assistant") {
				$list.="<h1>survey list</h1>";
				$list.="<div class=\"titlelist\">";
					
				// Open a directory, and read its contents
				if (is_dir($dir)){
				  if ($dh = opendir($dir)){
				    while (($file = readdir($dh)) !== false){
				    	$get_ex=explode('.',$file);
				        $get_last=end($get_ex);
				        $file_ext=strtolower($get_last);
				      if ($file_ext=="pdf")
				      	$list.="<li><a href=\"last_surveys/{$file}\" target=\"_blank\">{$file}</a></li>";
				    }
				    closedir($dh);
				  }
				}
				$list.="</div>";
			}else{
				$error[]="can't get book details";
			}

			
		



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>survey list</title>
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
	<div class="menunavi" id="test">
		<nav class="menu">
			<ul class="menu">
				<?php echo $list; ?>
			</ul>	
		</nav>
	</div>	
		

		
	</main>
	<div class="includeone">
		<?php //require_once('footer.php') ?>
	</div>
</body>
</html>