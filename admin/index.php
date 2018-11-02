<?php

session_start();
define('acc', TRUE);
require_once "../php/print_functions.php";

if(!isset($_SESSION["name"]))
{
    header("Location: ../home.html");
    exit();
}
else
{
    $sez = $_SESSION["name"];

    $contenuto = printAdminMenu($sez);

    $utente = $_SESSION["username"] . " (" . $_SESSION["name"].")";

    $logout = '<span class="rightfoot">Sei autenticato come: ' .$utente. '</span>'. printLogoutForm("text");

    $path = '<a href="../login.php">Accesso amministrazione</a> > Amministrazione ';

    printPage("Amministrazione ".$sez, "Amministrazione ".$sez, $path . $sez, $contenuto, $logout, "../");
}
