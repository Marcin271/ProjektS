	<?php
	session_start();
	if (!isset($_SESSION['typ'])){
	header('Location: start');
	exit();
	}
	if(!isset($_POST['tytul'])){
	header('Location: edycja-wpisu');
	exit();
	}
	$flagar=true;
	if($_POST['tytul']==""){
		$flagar=false;
		$_SESSION['e_tytul']='Wpisz tytul!';
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
		$tytul = htmlentities($_POST['tytul'], ENT_QUOTES, "UTF-8");
		$kategoria=$_POST['kategoria'];
		$id=$_SESSION['idpliku'];
		if($_SESSION['typ']==2){$public=0;}
		else{$public=1;}
		$polaczenie->query("UPDATE wpisy SET tytul='$tytul',kategoria='$kategoria',datam=CURRENT_TIMESTAMP,public='$public' WHERE id='$id'");
		$polaczenie->close();
		$nazwa="wpisy/".$id.".txt";
		$dane=$_POST['wpis'];
		$plik = fopen($nazwa, "w");
		fputs($plik, $dane);
		fclose($plik);
		header('Location: start');
	}}
	else{$idpliku=$_SESSION['idpliku'];header("Location: edycja-wpisu?idpliku=$idpliku");}
	?>
