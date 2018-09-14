<?php
	session_start();
    if (isset($_SESSION['typ'])){
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
<form action="login.php" method="post">
	E-mail: <br>
	<input type="email" name="email" placeholder="E-mail"><br>
	Hasło: <br>
	<input type="password" name="haslo" placeholder="Hasło"><br>
	<?php
	if(isset($_SESSION['blad'])){
		echo '<p>'.$_SESSION['blad'].'</p>';
		unset($_SESSION['blad']);
	}
	?>
	<input type="submit" value="Wyślij!">
	</form>
</body>
</html>
