<?php
$links=[
	"index"=>[
		"url"=>"index.php",
		"name"=>"Home",
		"right"=>false,
	],
	"register"=>[
		"url"=>"register.php",
		"name"=>"Registrar Usuários",
		"right"=>false,
	],
	"manage"=>[
		"url"=>"manage_accounts.php",
		"name"=>"Administrar Usuários",
		"right"=>false,
	],
	"logoff"=>[
		"url"=>"logoff.php",
		"name"=>"Deslogar",
		"right"=>true,
	],
];
include("nav.php");
?>