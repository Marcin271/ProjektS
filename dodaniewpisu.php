<?php
	session_start();
	if(!isset($_SESSION['typ'])){
		header('Location: start');
		exit();
	}
	?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<title>Tytuł</title>
</head>
<body>
<form action="addwpis.php" method="post">
	Tytuł: <br>
	<input type="text" name="tytul" placeholder="Tytuł"><br>
	<?php
	if(isset($_SESSION['e_tytul'])){
		echo '<p>'.$_SESSION['e_tytul'].'</p>';
		unset($_SESSION['e_tytul']);
	}
	?>
	Kategoria: <br>
	<select name="kategoria">	
	<option value="Ogólne" selected>Ogólne</option>
	<option value="Aktualności">Aktualności</option>
	<option value="E-Sport">E-Sport</option>
	<option value="Biblioteka">Biblioteka</option>
	</select><br>
	<?php
	if($_SESSION['typ']!=2){echo "<label><input type='checkbox' name='public' checked>Publiczny!</label>";}
	?>
	<textarea name='wpis' id='wpis'></textarea>
<script>
CKEDITOR.replace( 'wpis',{
	<?php
	if($_SESSION['typ']==0){echo "customConfig: 'custom/admins.js'});";}else{echo "customConfig: 'custom/users.js'});";}
	?>
</script>
	<input type="submit" value="Wyślij!">
</form>
</body>
</html>
