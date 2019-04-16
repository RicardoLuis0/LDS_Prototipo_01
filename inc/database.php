<?php
if(!isset($_SESSION["mock_db"])){
	$_SESSION["mock_db"]=[
		"users"=>[
			"admin"=>[
				"name"=>"Administrador",
				"pass_hash"=>password_hash("admin",PASSWORD_DEFAULT),
				"is_admin"=>true,
			],
		],
		"projects"=>[],
	];
}
function login($user,$pass){
	if(isset($_SESSION["mock_db"]["users"][$user])){
		$user_data=$_SESSION["mock_db"]["users"][$user];
		if(password_verify($pass,$user_data["pass_hash"])){
			$_SESSION["logged"]=true;
			$_SESSION["is_admin"]=$user_data["is_admin"];
			$_SESSION["name"]=$user_data["name"];
		}else{
			$_SESSION["login_error"]="wrong_pass";
		}
	}else{
		$_SESSION["login_error"]="wrong_user";
	}
}

function register($user,$name,$pass){
	if(!isset($_SESSION["mock_db"]["users"][$user])){
		$_SESSION["mock_db"]["users"][$user]=[
			"name"=>$name,
			"pass_hash"=>password_hash($pass,PASSWORD_DEFAULT),
			"is_admin"=>false,
		];
		return true;
	}else{
		$_SESSION["register_error"]="duplicate_user";
	}
	return false;
}
?>