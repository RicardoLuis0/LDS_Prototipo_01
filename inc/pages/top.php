<?php
	require_once("inc/session_setup.php");
	if(!isset($body_class)||gettype($body_class)!=="string")$body_class="";
	if(!isset($title_name)||gettype($title_name)!=="string")$title_name="";
	if(!isset($css_files)||!is_array($css_files))$css_files=array();
	array_push($css_files,"css/styles.css");
	if(Session::isLoggedIn()&&Session::getUserData()->getAccountType()=="Admin")array_push($css_files,"css/admin_styles.css");
?>
<html>
	<head>
		<title><?=($title_name==""?"Sistema TCC IF":$title_name." - Sistema TCC IF")?></title>
		<?php
			foreach($css_files as $css){
				echo '<link rel="stylesheet" type="text/css" href="'.$css.'">';
			}
		?>
	</head>
	<body <?=$body_class==""?"":" class=".$body_class?>>