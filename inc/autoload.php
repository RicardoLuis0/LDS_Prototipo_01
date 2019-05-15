<?php
//define('AUTOLOAD_DEBUG',true);
spl_autoload_register(function($class) {
	$file='inc/'.str_replace('\\', '/', $class).'.php';
	if(defined('AUTOLOAD_DEBUG')&&AUTOLOAD_DEBUG===true){
		echo "<h2>Autoload</h2><p>Backtrace: </p><pre>";
		debug_print_backtrace();
		echo "</pre>";
		echo "<p>Trying to Load: ".$file."</p>";
	}
	include_once($file);
});