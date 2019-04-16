<?php
include("inc/session_setup.php");

if($_SESSION["logged"])header("Location:index.php");

if(isset($_POST["proccess"])&&$_POST["proccess"]){
	include("inc/database.php");
	if(isset($_POST["user"])){
		if(isset($_POST["name"])){
			if(isset($_POST["pass"])){
				if(register($_POST["user"],$_POST["name"],$_POST["pass"])){
					header("Location:login.php");
					exit();
				}
			}else{
				$_SESSION['register_error']="missing_pass";
			}
		}else{
			$_SESSION['register_error']="missing_name";
		}
	}else{
		$_SESSION['register_error']="missing_user";
	}
	header("Location:register.php");
	exit();
}else{
	$id="register";
	$title_name="Registro";
	include("inc/top.php");
	include("inc/nav_generic.php");
	if(isset($_SESSION['register_error'])){
		echo "<h1 class=error>";
		switch($_SESSION['register_error']){
			case "duplicate_user";
				echo "Usuário já Existente";
				break;
			case "missing_user":
			case "missing_name":
			case "missing_pass":
				echo "Favor Preencher todos campos";
				break;
			default:
				echo "Erro em Registro";
				break;
		}
		echo "</h1>";
		unset($_SESSION['register_error']);
	}
	echo '<div class=formwrapper>
	<form action=register.php method=POST>
		<input type="hidden" name="proccess" value="true">
		<p><label for="user">Usuário: </label><input type="text" id="user" name="user"></p>
		<p><label for="user">Nome: </label><input type="text" id="name" name="name"></p>
		<p><label for="pass">Senha: </label><input type="password" id="pass" name="pass"></p>
		<input type="submit" value="Registrar">
	</form></div>';
	include("inc/bottom.php");
}
?>
