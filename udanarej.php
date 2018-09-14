<?php
session_start();
if(!isset($_SESSION['flagarc'])){
header('Location: rejestracja');
exit();
}
else{unset($_SESSION['flagarc']);}
?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<title>Tytuł</title>
</head>
<body>
Rejestracja przebiegła pomyślnie!<br>
<a href='rejestracja'>Rejestracja!</a><br>
<a href='start'>Start!</a>
</body>
</html>
