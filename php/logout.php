<?php session_start(); ?>
<?php
	$_SESSION['id']=NULL;
    $_SESSION['l_name']=NULL;
    $_SESSION['job_position']=NULL;

    header('Location:../index.php');

?>