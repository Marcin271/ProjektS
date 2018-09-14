<?php
	session_start();
	if(($_SESSION['typ']!=0)||(!isset($_SESSION['typ']))){
		header('Location: start');
		exit();
	}
	?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<title>Tytuł</title>
</head>
<body>
<?php
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
			w.ida=u.id and w.public=0 
		order by
			datau desc 
		limit 10");
		echo "<a href='start'>Wróć!</a><br><br>";
		$ile = $rezultat->num_rows;
        if($ile==0){echo "Brak wpisów do zatwierdzania!<br>";}else{
		while($wpis = $rezultat->fetch_assoc()){
		echo "Tytuł: ".$wpis['tytul']."<br>Autor: ".$wpis['imie']." ".$wpis['nazwisko']."<br>";
		echo "Data dodania: ".$wpis['datau']."<br>Data modyfikacji: ".$wpis['datam']."<br>Kategoria: ".$wpis['kategoria']."<br>";
		$plik="./wpisy/".$wpis['id'].".txt";
		echo "Treść:<br>".fread(fopen($plik, "r"), filesize($plik))."<br>";
		$idpliku=$wpis['id'];
		echo "............................................................<a href='changepublic.php?idpliku=$idpliku&public=1'>Zatwierdz!</a><br><br>";
		}}
	$polaczenie->close();}
?>
</body>
</html>
