<?php

define('acc', TRUE);
require_once "php/functions.php";
require_once "php/print_functions.php";

$tlist = ticketList();

$contenuto = printTicketTable($tlist);

$contenuto = $contenuto . printTicketBody();

printPage("Biglietti", "Biglietti", "Biglietti", $contenuto, "", "", "biglietti");

?>
