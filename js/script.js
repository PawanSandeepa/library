/*
$(document).ready(function(){
	var $canvas = $('#canvas'),
	context = $canvas.get(0).getContext('2d');
	$('#img_file').on('change',function(){
		if (this.files && this.files[0]) {
			if (this.files[0].type.match(/^image\//) ) {

				$('#file_name').attr('value',this.files[0].name);
			var reader =  new FileReader();
			reader.onload=function(e){
				var img = new Image();
				img.onload=function(){
					context.canvas.width = img.width;
					context.canvas.height = img.height;
					context.drawImage(img, 0, 0);

					var cropper = $canvas.cropper({
						aspectRatio:1
					});
				};
				img.src = e.target.result;
			};

			$('#crop').click(function(){
				var croppedImage=$canvas.cropper('getCroppedCanvas').toDataURL('image/jpg');
				$('#result').append($('<img>').attr('src',croppedImage));
				$('#cropped_img').attr('value',croppedImage);
				$('#upload_img').removeAttr('disabled');
			});
			reader.readAsDataURL(this.file[0]);
			}else{
				alert('invaid file type');
			}
		}else{
			alert('please select a file..');
		}
	});
});

*/


$(document).ready(function(){
	$('home').load('admin_home.php');
	//checking the id of the link...
	$('a').click(function(){
		var clicked_link = $(this).attr('id');
		$('.content').load(clicked_link+'.php');
	});
});