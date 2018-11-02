<?php

define('acc', TRUE);
require_once "php/functions.php";
require_once "php/print_functions.php";

$toursList = searchTour(null);

$contenuto = printToursInfo($toursList);

printPage("Tours", "<span id=\"dove\" xml:lang=\"fr\">Tours</span>", "<span xml:lang=\"fr\">Tours</span>", $contenuto, "", "", "tours");

?>
