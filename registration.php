	<?php
	session_start();
	if(($_SESSION['typ']!=0)||(!isset($_SESSION['typ']))){
		header('Location: start');
		exit();
	}
	if(isset($_POST['email'])){
	$flagar=true;
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	if((filter_var($email, FILTER_VALIDATE_EMAIL)==false) || ($email!=$_POST['email'])){
		$flagar=false;
		$_SESSION['e_email']='Niepoprawny adres E-mail!';
	}
	require_once "connect.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	mysqli_query($polaczenie, "SET CHARSET utf8");
	mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	if($polaczenie->connect_errno!=0){
		echo "ERROR: ".$polaczenie->connect_errno;
	}
	else{
		$ile_maili= $polaczenie->query("SELECT id FROM users WHERE email='$email'");
		$polaczenie->close();
		if($ile_maili->num_rows>0){
		$flagar=false;
		$_SESSION['e_email']='Ten adres E-mail jest już w użytku!';
		}
	}
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
		if (isset($_POST['zmiana'])){
		$ban=2;
		}
		$imie = htmlentities($_POST['imie'], ENT_QUOTES, "UTF-8");
		$nazwisko = htmlentities($_POST['nazwisko'], ENT_QUOTES, "UTF-8");
		$typ = $_POST['typ'];
		$hash = password_hash($_POST['haslo1'], PASSWORD_DEFAULT);
		$polaczenie->query("INSERT INTO users VALUES (NULL,'$email','$imie','$nazwisko','$typ','$hash','$ban')");
		$polaczenie->close();
		$_SESSION['flagarc']=true;
		header('Location: udana-rejestracja');
	}}
	else{header('Location: rejestracja');}
	}
	else{header('Location: rejestracja');}
	?>
