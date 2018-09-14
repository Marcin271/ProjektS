	<?php
	session_start();
	if(!isset($_SESSION['typ'])){
	header('Location: start');
	exit();
	}
	if(isset($_GET['idpliku'])){
	require_once "connect.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	mysqli_query($polaczenie, "SET CHARSET utf8");
	mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	if($polaczenie->connect_errno!=0){
		echo "ERROR: ".$polaczenie->connect_errno;
	}
	else{
		$id=$_GET['idpliku'];
		$rezultat = $polaczenie->query("
		select 
			id,tytul,kategoria,ida
		from 
			wpisy
		where 
			id=$id");
		$wpis = $rezultat->fetch_assoc();
		if($_SESSION['typ']!=0){
		if($wpis['ida']!=$_SESSION['id']){
			header('Location: moje-wpisy');
			exit();
		}}
		$tytul=$wpis['tytul'];
		$_SESSION['idpliku']=$wpis['id'];
echo<<<END
<script src="ckeditor/ckeditor.js"></script>
<form action="editor.php" method="post">
	Tytuł: <br>
	<input type="text" name="tytul" value="$tytul"><br>
END;
	if(isset($_SESSION['e_tytul'])){
		echo '<p>'.$_SESSION['e_tytul'].'</p>';
		unset($_SESSION['e_tytul']);
	}
echo<<<END
	Kategoria: <br>
	<select name="kategoria">
END;
	echo "<option value='Ogólne'";
	if ($wpis['kategoria']=="Ogólne"){echo "selected";}
	echo ">Ogólne</option>";
	echo "<option value='Aktualności'";
	if ($wpis['kategoria']=="Aktualności"){echo "selected";}
	echo ">Aktualności</option>";
	echo "<option value='E-Sport'";
	if ($wpis['kategoria']=="E-Sport"){echo "selected";}
	echo ">E-Sport</option>";
	echo "<option value='Biblioteka'";
	if ($wpis['kategoria']=="Biblioteka"){echo "selected";}
	echo ">Biblioteka</option></select><br>";
	$plik="wpisy/".$wpis['id'].".txt";
	echo "<textarea name='wpis' id='wpis'>".fread(fopen($plik, "r"), filesize($plik))."</textarea>";
echo<<<END
	<script>
	CKEDITOR.replace( 'wpis',{
	customConfig: 'custom/users.js'});
	</script>
	<input type="submit" value="Wyślij!">
	</form>
END;
	}
	}
	else{header('Location: moje-wpisy');
	}
	?>
