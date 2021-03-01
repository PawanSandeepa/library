<?php session_start(); ?>
<?php require_once('../connection/tempconn.php'); ?>
<?php require_once('external.php'); ?>

<?php
  //check form submition
  $go=NULL;
  if (isset($_GET['page'])) {
    $go=$_GET['page'];
    //echo $go;
  }else{
    $go="../index";
  }

  if(isset($_POST['submit'])){
    //echo $go;
    $error=array();
    //check if the id and password has been entered
    if(!isset($_POST['id']) || strlen(trim($_POST['id'])) < 1){
      $error[] ="id is missing or invalid";
    }if(!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1){
      $error[] ="password is missing or invalid";
    }
    //check if there are any errors in the form
    if(empty($error)){
      //save id and password into variables
      $id = mysqli_real_escape_string($temp_conn,$_POST['id']);

      $password = mysqli_real_escape_string($temp_conn,$_POST['password']);
      $hashed_password=sha1($password);
      //prepare database quary
      $subid=substr($id,0,2);
      //echo $subid;
      if($subid=='st'){
        $quary="select id,l_name,job_position from staff where id = '{$id}' and spassword='{$hashed_password}'limit 1";     

        $result_set=mysqli_query($temp_conn,$quary);

        if($result_set){
          //echo "result_setis ok";
          if(mysqli_num_rows($result_set)==1){
            while($detail=mysqli_fetch_assoc($result_set)){
              $id=$detail['id'];
              $l_name=$detail['l_name'];
              $job_position=$detail['job_position'];
            }
            //echo $id.$l_name.$job_position;
            $_SESSION['id']=$id;
            $_SESSION['l_name']=$l_name;
            $_SESSION['job_position']=$job_position;

            header('Location:'.$go.'.php');
            
            
          }else{
            $error[] ='invalid id or password';
          }
        }
      }elseif($subid=='mb'){
        $quary="select id,l_name from members where id = '{$id}' and mpassword='{$hashed_password}' limit 1";
        

        $result_set=mysqli_query($temp_conn,$quary);

        if($result_set){

          if(mysqli_num_rows($result_set)==1){
             while($detail=mysqli_fetch_assoc($result_set)){
              $id=$detail['id'];
              $l_name=$detail['l_name'];

            }
            $_SESSION['id']=$id;
            $_SESSION['l_name']=$l_name;
            $_SESSION['job_position']="member";
            header('Location:../index.php');
          }else{
            $error[] ='invalid id or password';
          }
        }else{
          $error[] ='invalid id or password';
        }
      
      }else{
        $error[] ="wrong id";
      }
       
      if(!isset($quary)){
        header('Location:login.php');
      }




    }else{
      $error[]='database query failed';
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>login</title>
  <link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
  <div>
    <?php require_once('header.php'); ?>
    <?php require_once('banner.php'); ?>
  </div>
  
  <div class="login" style="background-color: white">
    
    <form action="login.php?page=<?php echo $go ?>" method="post">
      
      <fieldset>
        <legend><h1>Loging form</h1></legend>
        
          
          <?php 
            
            if(isset($error) && !empty($error)){
              echo "<div class=\"error\">";
              foreach ($error as $value) {
                echo $value."<br>";
              }
              echo "</div>";
            } 
            
          ?>
        
        
        
        <p class="log"><label>Input ID :</label><input class="logtxt" type="text" name="id" placeholder="enter id"></p>
        <p class="log"><label>Input Password :</label><input class="logtxt" type="password" name="password" placeholder="enter password"></p>
        <p><button class="logadd" type="submit" name="submit">Login</button>
        <button class="logadd" type="submit" name="submit">Login</button></p>

        

      </fieldset>

    </form>

  </div>
  <div class="includeone">
    <?php require_once('footer.php') ?>
  </div>
</body>
</html>

<?php mysqli_close($temp_conn); ?>