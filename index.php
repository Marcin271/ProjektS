<?php session_start(); ?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<title>Tytuł</title>
</head>
<body><?php
    if (isset($_SESSION['typ'])){
	$imie=$_SESSION['imie'];
	$nazwisko=$_SESSION['nazwisko'];
	$email=$_SESSION['email'];
echo<<<END
	<p>Imię: $imie </p>
	<p>Nazwisko: $nazwisko </p>
	<p>E-mail: $email </p>
END;
	echo "Typ konta: ";
	if($_SESSION['typ']==0){
echo<<<END
	Admin<br><br>
	<a href="rejestracja">Rejestracja!</a><br>
	<a href="moje-wpisy">Wpisy!</a><br>
	<a href="dodanie-wpisu">Dodanie wpisu!</a><br>
	<a href="blokowanie-wpisu">Blokowanie wpisu!</a><br>
	<a href="zatwierdzanie-wpisu">Zatwierdzanie wpisu!</a><br>
END;
	}
	else if($_SESSION['typ']==1){echo "Autor<br><br><a href='dodanie-wpisu'>Dodanie wpisu!</a><br><a href='moje-wpisy'>Moje wpisy!</a><br>";}
	else{echo "Autor do sprawdzenia<br><br><a href='dodanie-wpisu'>Dodanie wpisu!</a><br><a href='moje-wpisy'>Moje wpisy!</a><br>";}
echo "<a href='wyloguj'>Wyloguj się!</a><br><br>";
	}else{echo "<a href='zaloguj-sie'>Zaloguj się!</a><br><br>";}
	require_once "connect.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	mysqli_query($polaczenie, "SET CHARSET utf8");
	mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	if($polaczenie->connect_errno!=0){
		echo "ERROR: ".$polaczenie->connect_errno;
	}
	else{
		$rezultat = $polaczenie->query("
		select 
			w.id,w.tytul,w.datau,w.datam,w.kategoria,u.imie,u.nazwisko 
		from 
			users as u,wpisy as w 
		where 
			w.ida=u.id and w.public=1 
		order by
			datau desc 
		limit 10");
		while($wpis = $rezultat->fetch_assoc()){
		echo "Tytuł: ".$wpis['tytul']."<br>Autor: ".$wpis['imie']." ".$wpis['nazwisko']."<br>";
		echo "Data dodania: ".$wpis['datau']."<br>Data modyfikacji: ".$wpis['datam']."<br>Kategoria: ".$wpis['kategoria']."<br>";
		$plik="wpisy/".$wpis['id'].".txt";
		echo "Treść:<br>".fread(fopen($plik, "r"), filesize($plik))."<br>";
		echo "............................................................<br><br>";
		}
		$polaczenie->close();
	}
	?>
</body>
</html>
