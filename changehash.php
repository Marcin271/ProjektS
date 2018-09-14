	<?php
	if(isset($_POST['haslo1'])){
	session_start();
	$flagar=true;
	if(strlen($_POST['haslo1'])<8 || strlen($_POST['haslo1'])>20){
		$flagar=false;
		$_SESSION['e_haslo']='Hasła muszą mieć od 8 do 20 znaków!';
	}
	if($_POST['haslo1']!=$_POST['haslo2']){
		$flagar=false;
		$_SESSION['e_haslo']='Hasła muszą być takie same!';
	}
	if($flagar==true){
	require_once "connect.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	mysqli_query($polaczenie, "SET CHARSET utf8");
	mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	if($polaczenie->connect_errno!=0){
		echo "ERROR: ".$polaczenie->connect_errno;
	}
	else{
		$hash = password_hash($_POST['haslo1'], PASSWORD_DEFAULT);
		$id = $_SESSION['id'];
		$polaczenie->query("UPDATE users SET hash='$hash',ban='0' WHERE id='$id'");
		$polaczenie->close();
		header('Location: start');
	}}
	else{header('Location: zmiana-hasla');}
	}
	else{header('Location: zmiana-hasla');;
	}
	?>
