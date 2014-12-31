<?php
session_start();

if (isset($_GET["action"]) && $_GET["action"] != ""){
	if ($_GET["action"] == "c"){
		if (isset($_SESSION["pseudo"])){
			echo $_SESSION["pseudo"];
		}else{
			echo "0";
		}
	}else if ($_GET["action"] == "d"){
		session_destroy();
	}
}else{
	header("HTTP/1.0 400 Bad Request");
}
?>