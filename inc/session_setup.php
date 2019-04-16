<?php
session_start();
if(!isset($_SESSION['logged']))$_SESSION['logged']=false;
if(!isset($_SESSION['is_admin']))$_SESSION['is_admin']=false;
if(!isset($_SESSION['name']))$_SESSION['name']="";
?>