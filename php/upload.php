<?php session_start(); ?>
<?php require_once('external.php'); ?>
<?php

    $error=array();
    $lenth_error=array();
    $ok=array();
    $member_id='';
    if (isset($_SESSION['job_position'])) {
        $job_position=$_SESSION['job_position'];
        if ($job_position=="admin" or $job_position=="assistant") {
            if (isset($_GET['id'])) {
                $member_id=$_GET['id'];
                //echo $member_id;
            }else{
                
                echo '<script type="text/javascript">';
                    echo 'alert("member id can\'t identify..!!")';
                echo '</script>';
                //exit;
                
                
            }
        }
    }else{
        header('Location:login.php?page=upload');
    }

    //onclick="window.location.href = \'upload.php?id='.$id.'\'"

    if (isset($_POST['submit'])) {
        if(isset($_FILES['image'])){
 
          $file_name = $_FILES['image']['name'];
          $file_size = $_FILES['image']['size'];
          $file_tmp = $_FILES['image']['tmp_name'];
          $file_type = $_FILES['image']['type'];
          $get_ex=explode('.',$_FILES['image']['name']);
          $get_last=end($get_ex);
          $file_ext=strtolower($get_last);
          //$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
          
          $extensions= array("jpg");
          
          if(in_array($file_ext,$extensions)=== false){
             $error[]="extension not allowed, please choose a JPG file.";
          }
          
          if($file_size > 2097152) {
             $error[]='File size must be excately 2 MB';
          }
          
          if(empty($error)==true) {
            $subid=substr($id,0,2);
            if ($subid=='mb') {
                move_uploaded_file($file_tmp,"../img/member/profilepic/".$member_id.$file_ext);
                $ok[]="Success";
            }elseif ($subid=='st') {
                move_uploaded_file($file_tmp,"../img/staff/profilepic/".$member_id.$file_ext);
                $ok[]="Success";
            }
             
          }else{
             $error[]="can't upload file";
          }
       }
    }
   
?>
<html>
    <style type="text/css">
        .button a{
            text-decoration: none;
        }
    </style>
   <body>
        <?php
            print_error($error,$lenth_error);
            print_ok($ok);

        ?>
      <button class="button"><a href="register_member.php">skip</a></button>
      <form action = "upload.php?id={$member_id}" method = "post" enctype = "multipart/form-data">
         <input type = "file" name = "image" />
         <input type = "submit"/>
         <!--   
         <ul>
            <li>Sent file: <?php //echo $_FILES['image']['name'];  ?>
            <li>File size: <?php //echo $_FILES['image']['size'];  ?>
            <li>File type: <?php //echo $_FILES['image']['type'] ?>
         </ul>
         -->   
      </form>
      
    <div class="includeone">
      <?php require_once('footer.php') ?>
    </div>
  </body>
</html>