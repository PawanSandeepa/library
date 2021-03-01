<?php
	session_start();
?>
<?php require_once('connection/tempconn.php'); ?>
<?php require_once('php/external.php'); ?>


<?php
	$search='';
	$display='';
	$job_position='';

	if (isset($_SESSION['job_position'])) {
		$job_position=$_SESSION['job_position'];
	}

	//-------------------------------------------------
	if (!isset($_POST['submit']) or !isset($_GET['category'])) {
		$query="SELECT book_id from transactions ORDER BY count_of_transactions DESC limit 20";
		$rquery=mysqli_query($member1_conn,$query);
		if ($rquery) {
			$display.="<h2><b>The most commonly used books</b></h2>";
			$display.='<div class="container">';
			while ($detail=mysqli_fetch_assoc($rquery)) {
				$c_id=$detail['book_id'];
				$query="SELECT id,name,category_number,writer,printed_date from book where id='{$c_id}' limit 1";
				$bquery=mysqli_query($member1_conn,$query);
				if ($bquery) {
					
					while ($b_detail=mysqli_fetch_assoc($bquery)) {
						$display.='<div class="card">';
							$display.='<div class="face">';
								$display.='<div class="content1">';
									$id=$b_detail['id'];
									$display.='<a href="php/book_profile.php?id='.$id.'">';
									//put the img link....
									$display.='<img src="img/profile_book.png">';
									
								    $display.='<h3><b>Id : '.$id.'</b></h3>';
								    $display.='<h3><b>name : '.$b_detail['name'].'</b></h3>';
								$display.='</div>';
								$display.='<div class="content2">'; 
								    $display.='<p>category number : '.$b_detail['category_number'].'</p>';
								    $display.='<p>writer : '.$b_detail['writer'].'</p>';
								    $display.='<p>printed date : '.$b_detail['printed_date'].'</a></p>';
					    		$display.='</div>';
							$display.='</div>';
					    $display.='</div>';
					}
					
				}
			}
			$display.='</div>';
		}
	}

	if ($job_position=='assistant' or $job_position=='admin') {
		$query="SELECT id,f_name,l_name,address,phone_mobile from members ORDER BY count_of_transactions DESC LIMIT 20";
		$rquery=mysqli_query($member1_conn,$query);
		if ($rquery) {
			$display.="<h2><b>Mostly library users</b></h2>";
			$display.='<div class="container">';
			while($detail=mysqli_fetch_assoc($rquery)){
				$display.='<div class="card">';
					$display.='<div class="face">';
						$display.='<div class="content1">';
							$id=$detail['id'];
							$display.='<a href="php/member_profile.php?id='.$id.'">';
							//put the img link...
							$display.='<img src="img/member/profilepic/'.$id.'.jpg">';
							
						    $display.='<h3><b>Id : '.$id.'</b></h3>';
						    $display.='<h3><b>First name : '.$detail['f_name'].'</b></h3>';
						$display.='</div>';
						$display.='<div class="content2">';
						    $display.='<p>Last name : '.$detail['l_name'].'</p>';
						    $display.='<p>Address : '.$detail['address'].'</p>';
						    $display.='<p>Mobile number : '.$detail['phone_mobile'].'</a></p>';
			    		$display.='</div>';
			    	$display.='</div>';
			    $display.='</div>';

		    }
		    $display.='</div>';
		}
		
	}


	//----------------------------------------------------------------------
	if(isset($_POST['submit'])){
		
		$get='';
		$get_result='';

		
		$search=mysqli_real_escape_string($member1_conn,$_POST['search']);
		//echo $search;
		//echo $job_position;
		if ($job_position=='assistant' or $job_position=='admin') {
			$display.="<h2><b>About members</b></h2>";
			$display.='<div class="container">';

			$get="SELECT id,f_name,l_name,address,phone_mobile from members where id LIKE '%{$search}%' or f_name LIKE '%{$search}%' or l_name LIKE '%{$search}%' or address LIKE '%{$search}%' or nic LIKE '%{$search}%' ORDER BY id";

			$get_result=mysqli_query($member1_conn,$get);


			while($detail=mysqli_fetch_assoc($get_result)){
				$display.='<div class="card">';
					$display.='<div class="face">';
						$display.='<div class="content1">';
							$id=$detail['id'];
							$display.='<a href="php/member_profile.php?id='.$id.'">';
							//put the img link...
							$display.='<img src="img/member/profilepic/'.$id.'.jpg">';
							
						    $display.='<h3><b>Id : '.$id.'</b></h3>';
						    $display.='<h3><b>First name : '.$detail['f_name'].'</b></h3>';
						$display.='</div>';
						$display.='<div class="content2">';
						    $display.='<p>Last name : '.$detail['l_name'].'</p>';
						    $display.='<p>Address : '.$detail['address'].'</p>';
						    $display.='<p>Mobile number : '.$detail['phone_mobile'].'</a></p>';
			    		$display.='</div>';
			    	$display.='</div>';
			    $display.='</div>';

		    }
		    $display.='</div>';

		}
		$display.="<h2><b>About book</b></h2>";
		$get="SELECT id,name,category_number,writer,printed_date from book where id LIKE '%{$search}%' or name LIKE '%{$search}%' or category_number  LIKE '%{$search}%' or writer LIKE '%{$search}%' or printed_date LIKE '%{$search}%'";
		$get_result=mysqli_query($member1_conn,$get);
		$display.='<div class="container">';
			while($detail=mysqli_fetch_assoc($get_result)){
				$display.='<div class="card">';
					$display.='<div class="face">';
						$display.='<div class="content1">';
							$id=$detail['id'];
							$display.='<a href="php/book_profile.php?id='.$id.'">';
							//put the img link....
							$display.='<img src="img/profile_book.png">';
							
						    $display.='<h3><b>Id : '.$id.'</b></h3>';
						    $display.='<h3><b>name : '.$detail['name'].'</b></h3>';
						$display.='</div>';
						$display.='<div class="content2">'; 
						    $display.='<p>category number : '.$detail['category_number'].'</p>';
						    $display.='<p>writer : '.$detail['writer'].'</p>';
						    $display.='<p>printed date : '.$detail['printed_date'].'</a></p>';
			    		$display.='</div>';
					$display.='</div>';
			    $display.='</div>';

		    }
		    $display.='</div>';
	}

	if (isset($_GET['category'])) {
		$c_number=$_GET['category'];
		$display.="<h2><b>Book of under the ".$c_number."</b></h2>";
		$get="SELECT id,name,category_number,writer,printed_date from book where category_number='{$c_number}'";
		$get_result=mysqli_query($member1_conn,$get);
		$display.='<div class="container">';
			while($detail=mysqli_fetch_assoc($get_result)){
				$display.='<div class="card">';
					$display.='<div class="face">';
						$display.='<div class="content1">';
							$id=$detail['id'];
							$display.='<a href="php/book_profile.php?id='.$id.'">';
							//put the img link....
							$display.='<img src="img/profile_book.png">';
							
						    $display.='<h3><b>Id : '.$id.'</b></h3>';
						    $display.='<h3><b>name : '.$detail['name'].'</b></h3>';
						$display.='</div>';
						$display.='<div class="content2">'; 
						    $display.='<p>category number : '.$detail['category_number'].'</p>';
						    $display.='<p>writer : '.$detail['writer'].'</p>';
						    $display.='<p>printed date : '.$detail['printed_date'].'</a></p>';
			    		$display.='</div>';
					$display.='</div>';
			    $display.='</div>';

		    }
		    $display.='</div>';
	}


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pitabeddara public library</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<!--
	<div class="wrapper">
		<div class="top-bar clearfix">
			<div class="top-bar-links">
				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="#">catogory</a></li>
					<li><a href="#">about us</a></li>
					<li><a href="php/login.php">login</a></li>
				</ul>

			</div>
			<div class="top-bar-search">
				<form method="post" action="index.php">
					<input type="text" placeholder="Search..." name="search" size="35" <?php //echo 'value="'.$search.'"';?>>
					<button type="submit" name="submit"></button>
				</form>

			</div>
		</div>
	</div>
-->
	<div class="includeone">
		<?php require_once('header.php') ?>
		<?php require_once('banner.php') ?>
		<?php //require_once('footer.php') ?>
	</div>

	
	<div class="container" style="margin: 0;padding: 0;margin-top: -10px;">
	  <div id="myCarousel" class="carousel slide" data-ride="carousel">
	    <!-- Indicators -->
	    <ol class="carousel-indicators">
	      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	      <li data-target="#myCarousel" data-slide-to="1"></li>
	      <li data-target="#myCarousel" data-slide-to="2"></li>
	      <li data-target="#myCarousel" data-slide-to="3"></li>
	    </ol>

	    <!-- Wrapper for slides -->
	    <div class="carousel-inner">

	      <div class="item active">
	        <img src="img/carousel/staff_table.jpg" alt="library" style="background-color: #051223; color: #fff; height: 500px; width: 100%;">
	        <div class="carousel-caption">
	          <h3>staff table</h3>
	          <p>Pitabeddara public library</p>
	        </div>
	      </div>

	      <div class="item">
	        <img src="img/carousel/table.jpg" alt="library" style="background-color: #051223; color: #fff; height: 500px; width: 100%;">
	        <div class="carousel-caption">
	          <h3>tables</h3>
	          <p>Pitabeddara public library</p>
	        </div>
	      </div>
	    
	      <div class="item">
	        <img src="img/carousel/cupboard.jpg" alt="library" style="background-color: #051223; color: #fff; height: 500px; width: 100%;">
	        <div class="carousel-caption">
	          <h3>cupboard</h3>
	          <p>Pitabeddara public library</p>
	        </div>
	      </div>

	      <div class="item">
	        <img src="img/carousel/full_view.jpg" alt="library" style="background-color: #051223; color: #fff; height: 500px; width: 100%;">
	        <div class="carousel-caption">
	          <h3>full view</h3>
	          <p>Pitabeddara public library</p>
	        </div>
	      </div>
	  
	    </div>

	    <!-- Left and right controls -->
	    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
	      <span class="glyphicon glyphicon-chevron-left"></span>
	      <span class="sr-only">Previous</span>
	    </a>
	    <a class="right carousel-control" href="#myCarousel" data-slide="next">
	      <span class="glyphicon glyphicon-chevron-right"></span>
	      <span class="sr-only">Next</span>
	    </a>
	  </div>
	</div>

	<?php echo $display; ?>
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>