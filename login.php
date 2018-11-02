<?php

session_start();

define('acc', TRUE);
require_once "php/print_functions.php";
$contenuto = "";

if(isset($_SESSION["name"]))
{
    $msg = '<div class="descrizione"><p>Hai già eseguito l\'accesso come '. $_SESSION["username"] . ' (' . $_SESSION["name"].').</p>
    <p>Prosegui nell\'<a id="special_link" href="admin/index.php">area di amministrazione '.$_SESSION["name"].'</a>.</p></div>';
    $contenuto = $contenuto . printMsg($msg);
    $contenuto = $contenuto . printLogoutForm("button");
}
else
{
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
    $contenuto = $contenuto . printLoginForm();
}

$script = '<script type="text/javascript" src="js/check_form_amministrazione.js"></script>';

printPage("Accesso", "Accesso amministrazione", "Accesso amministrazione", $contenuto, $script);

?>
