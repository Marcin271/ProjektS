	<?php
	session_start();
    if (!isset($_SESSION['typ'])){
	header('Location: start');
	exit();
	}
	if(isset($_POST['tytul'])){
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
		$ida=$_SESSION['id'];
		$kategoria=$_POST['kategoria'];
		if($_SESSION['typ']==2){$public=0;}
		else{if(isset($_POST['public'])){$public=1;}else{$public=0;}}
		$polaczenie->query("INSERT INTO wpisy VALUES
		(NULL,'$ida','$tytul',CURRENT_TIME(),CURRENT_TIMESTAMP,'$kategoria','$public')");
		$nazwa = $polaczenie->insert_id;
		$polaczenie->close();
		$nazwa="wpisy/".$nazwa.".txt";
		$dane=$_POST['wpis'];
		$plik = fopen($nazwa, "w");
		fputs($plik, $dane);
		fclose($plik);
		$_SESSION['flagarc']=true;
		header('Location: start');
	}}
	else{header('Location: dodanie-wpisu');}
	}
	else{header('Location: dodanie-wpisu');}
	?>
