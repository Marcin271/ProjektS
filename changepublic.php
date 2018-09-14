	<?php
	session_start();
	if(($_SESSION['typ']!=0)||(!isset($_SESSION['typ']))){
	header('Location: start');
	exit();
	}
	if(isset($_GET['idpliku'])){
	session_start();
	require_once "connect.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	mysqli_query($polaczenie, "SET CHARSET utf8");
	mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	if($polaczenie->connect_errno!=0){
		echo "ERROR: ".$polaczenie->connect_errno;
	}
	else{
		$id = $_GET['idpliku'];
		$public=$_GET['public'];
		$polaczenie->query("UPDATE wpisy SET public='$public' WHERE id='$id'");
		$polaczenie->close();
		if($public==1){
		header('Location: zatwierdzanie-wpisu');}else{header('Location: blokowanie-wpisu');}
	}
	}
	else{header('Location: start');}
	?>
