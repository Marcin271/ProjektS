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
<form action="registration.php" method="post">
	E-mail: <br>
	<input type="email" name="email" placeholder="E-mail"><br>
	<?php
	if(isset($_SESSION['e_email'])){
		echo '<p>'.$_SESSION['e_email'].'</p>';
		unset($_SESSION['e_email']);
	}
	?>
	Imię: <br>
	<input type="text" name="imie" placeholder="Imię"><br>
	Nazwisko: <br>
	<input type="text" name="nazwisko" placeholder="Nazwisko"><br>
	Hasło: <br>
	<input type="password" name="haslo1" placeholder="Hasło"><br>
	<?php
	if(isset($_SESSION['e_haslo'])){
		echo '<p>'.$_SESSION['e_haslo'].'</p>';
		unset($_SESSION['e_haslo']);
	}
	?>
	Powtórz hasło: <br>
	<input type="password" name="haslo2" placeholder="Powtórz hasło"><br>
	Uprawnienia: <br>
	<label><input type="radio" name="typ" value="2" checked>Autor do sprawdzenia<br></label>
	<label><input type="radio" name="typ" value="1">Autor<br></label>
	<label><input type="radio" name="typ" value="0">Admin<br></label><br>
	<label><input type="checkbox" name="zmiana">Wymagana zmiana hasła po pierwszym zalogowaniu!<br></label><br>
	<input type="submit" value="Wyślij!">
	</form>
</body>
</html>
