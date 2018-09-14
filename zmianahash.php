<?php
	session_start();
	if(!isset($_SESSION['zmianahash'])){
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
<form action="changehash.php" method="post">
	Nowe hasło: <br>
	<input type="password" name="haslo1" placeholder="Nowe hasło"><br>
	Powtórz nowe hasło: <br>
	<input type="password" name="haslo2" placeholder="Powtórz nowe hasło"><br>	
	<?php
	if(isset($_SESSION['e_haslo'])){
		echo '<p>'.$_SESSION['e_haslo'].'</p>';
		unset($_SESSION['e_haslo']);
	}?><br>
	<input type="submit" value="Wyślij!">
	</form>
</body>
</html>
