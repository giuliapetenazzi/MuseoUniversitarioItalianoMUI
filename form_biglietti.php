<?php

session_start();

define('acc', TRUE);
require_once "php/functions.php";
require_once "php/print_functions.php";

$contenuto = "";

if(isset($_SESSION['error']))
{
    $contenuto = $contenuto . printError($_SESSION['error']);
    $_SESSION['error'] = null;
}

if(isset($_SESSION['msg']))
{
    $contenuto = $contenuto . printMsg($_SESSION['msg']);
    $_SESSION['msg'] = null;
}

$toursList = searchTour(null);
$typesList = ticketList();

$contenuto = $contenuto . printFormAcquisto($toursList, $typesList);

$path = '<a href="biglietti.php">Biglietti</a> > Acquista biglietti';

$script = '<script type="text/javascript" src="../js/check_form_biglietti.js"></script>';


printPage("Acquista biglietti", "Acquista biglietti", $path, $contenuto, $script);

?>
