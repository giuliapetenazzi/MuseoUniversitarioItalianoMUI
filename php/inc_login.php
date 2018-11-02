<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();

define('acc', TRUE);
if(isset($_SESSION["name"]))
{
	if (($_SERVER["REQUEST_METHOD"] == "POST") and ($_POST["logout"]))
	{
		session_destroy();
        header("Location: ../home.html");
        exit();
	}
	else
	{
		header("Location: ../login.php");
        exit();
	}
}

else
{
	if (($_SERVER["REQUEST_METHOD"] == "POST") and ($_POST["username"]) and ($_POST["password"]) )
	{
        require_once "../php/functions.php";

		$clogin = checkLogin($_POST["username"], md5($_POST["password"]));

		if ($clogin["err"] == false)
		{
            $_SESSION["name"] = $clogin["ruolo"];
            $_SESSION["username"] = $clogin["username"];

            header("Location: ../admin/index.php");
            exit();
		}
		else
		{
            $_SESSION['error'] = "Nome utente o password errati.";
            header("Location: ../login.php");
            exit();
		}
	}
	else
	{
		header("Location: ../home.html");
        exit();
	}
}

?>
