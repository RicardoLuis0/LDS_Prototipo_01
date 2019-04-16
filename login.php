<?php
include("inc/session_setup.php");

if($_SESSION["logged"])header("Location:index.php");

if(isset($_POST["proccess"])&&$_POST["proccess"]){
	include("inc/database.php");
	if(isset($_POST["user"])){
		if(isset($_POST["pass"])){
			login($_POST["user"],$_POST["pass"]);
		}else{
			$_SESSION['login_error']="missing_pass";
		}
	}else{
		$_SESSION['login_error']="missing_user";
	}
	header("Location:login.php");
	exit();
}else{
	$id="login";
	$title_name="Login";
	include("inc/top.php");
	include("inc/nav_generic.php");
	if(isset($_SESSION['login_error'])){
		echo "<h1 class=error>";
		switch($_SESSION['login_error']){
			case "wrong_pass":
				echo "Senha Incorreta";
				break;
			case "wrong_user":
				echo "Usuário Inexistente";
				break;
			case "missing_user":
			case "missing_pass":
				echo "Favor Preencher todos campos";
				break;
			default:
				echo "Erro em Login";
				break;
		}
		echo "</h1>";
		unset($_SESSION['login_error']);
	}
	echo '<div class=formwrapper>
	<form action=login.php method=POST>
		<input type="hidden" name="proccess" value="true">
		<p><label for="user">Usuário: </label><input type="text" id="user" name="user"></p>
		<p><label for="pass">Senha: </label><input type="password" id="pass" name="pass"></p>
		<input type="submit" value="Logar">
	</form></div>';
	include("inc/bottom.php");
}
?>
