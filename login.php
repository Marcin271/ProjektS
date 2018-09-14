<?php
	session_start();
    if ((!isset($_POST['email']))||(!isset($_POST['haslo']))){
		header('Location: start');
		exit();
	}
	require_once "connect.php";
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	@mysqli_query($polaczenie, "SET CHARSET utf8");
	@mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    if ($polaczenie->connect_errno!=0){
    echo "ERROR: ".$polaczenie->connect_errno;
    }
    else{
        $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
        if ($rezultat = @$polaczenie->query("SELECT * FROM users WHERE email='$email'")){
            $ile = $rezultat->num_rows;
            if($ile>0){
				$wiersz = $rezultat->fetch_assoc();
				if($wiersz['ban']!=1){
				if(password_verify($_POST['haslo'], $wiersz['hash'])){
				if($wiersz['ban']==2){
				$_SESSION['zmianahash']=true;
				$_SESSION['id']=$wiersz['id'];
				$_SESSION['email']=$wiersz['email'];
				$_SESSION['imie']=$wiersz['imie'];
				$_SESSION['nazwisko']=$wiersz['nazwisko'];
				$_SESSION['typ']=$wiersz['typ'];
				$_SESSION['ban']=$wiersz['ban'];
				unset($_SESSION['blad']);
				$rezultat->free_result();
				header('Location: zmiana-hasla');
				}else{
				$_SESSION['id']=$wiersz['id'];
				$_SESSION['email']=$wiersz['email'];
				$_SESSION['imie']=$wiersz['imie'];
				$_SESSION['nazwisko']=$wiersz['nazwisko'];
				$_SESSION['typ']=$wiersz['typ'];
				$_SESSION['ban']=$wiersz['ban'];
                unset($_SESSION['blad']);
                $rezultat->free_result();
                header('Location: start');}
				}else{
				$_SESSION['blad'] = 'Nieprawidłowe hasło!';
                header('Location: zaloguj-sie');}}
				
				else{
				$_SESSION['blad'] = 'Twoje konto zostało zablokowane!';
                header('Location: zaloguj-sie');}
            } else {
                $_SESSION['blad'] = 'Nieprawidłowy E-mail!';
                header('Location: zaloguj-sie');
            }
        }
        $polaczenie->close();
    }
?>
