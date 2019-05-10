<?php
require_once("inc/session_setup.php");

require_once('inc/require_admin.php');

require_once('inc/mail/mail.php');

//if($_SESSION["logged"])header("Location:index.php");

if(isset($_POST["proccess"])&&$_POST["proccess"]){
	include("inc/get_database.php");
	if(isset($_POST["user"])&&strlen($_POST["user"])>0){
		if(isset($_POST['email'])&&strlen($_POST["email"])>0){
			if(isset($_POST["name"])&&strlen($_POST["name"])>0){
				if(isset($_POST["type"])&&strlen($_POST["type"])>0){
					$type=$_POST["type"];
					if($type=="Student"||$type=="Teacher"){
						$login=$_POST["user"];
						$name=$_POST["name"];
						$email=$_POST['email'];
						$db=getDatabase();
						$db->connect();
						$key=$db->registerUser($login,$name,$type,$email);
						if($key!=null){
							Mailer::sendActivation($email,$login,$key);
							header("Location:register.php");
							exit();
						}else if(!isset($_SESSION['register_error'])){
							$_SESSION['register_error']="???";
						}
					}else{
						$_SESSION['register_error']="invalid_type";

					}
				}else{
					$_SESSION['register_error']="missing_type";
				}
			}else{
				$_SESSION['register_error']="missing_name";
			}
		}else{
			$_SESSION['register_error']="missing_email";
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
			case "missing_type":
			case "missing_user":
			case "missing_name":
			case "missing_pass":
			case "missing_email":
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
		<p><label for="name">Nome: </label><input type="text" id="name" name="name"></p>
		<p><label for="email">E-Mail: </label><input type="text" id="email" name="email"></p>
		<p><label for="type">Tipo de Conta: </label><select id="type" name="type">
			<option value="Student">Estudante</option>
			<option value="Teacher">Professor</option>
		</select></p>
		<input type="submit" value="Registrar">
	</form></div>';
	include("inc/bottom.php");
}
?>
