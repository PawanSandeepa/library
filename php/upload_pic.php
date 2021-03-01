

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>upload profile picture</title>
	<link rel="stylesheet" type="text/css" href="../css/img.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.css">
</head>
<body>
	<div class="container">
		<h2>select file</h2>
		<div class="form">
			<input type="file" name="img_file" id="img_file">
			<button id="crop">crop</button>
		</div>

		<h2>crop</h2>
		<div>
			<canvas id="canvas">
				Your browser deos not support HTML 5 canvas
			</canvas>
		</div>
		<h2>result</h2>
		<div id="result">
			
		</div>
		<h2>upload image</h2>
		<form action="upload_img.php" method="post"></form>
		<input type="hidden" name="file_name" id="file_name">
		<input type="hidden" name="cropped_img" id="cropped_img">
		<button type="submit" id="upload_img" name="upload_img" disabled>upload image</button>
	</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.js"></script>
<script src="../js/script.js"></script>
</body>
</html>