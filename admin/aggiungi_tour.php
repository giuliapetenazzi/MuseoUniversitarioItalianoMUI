<?php

session_start();

if(!isset($_SESSION["name"]))
{
    header("Location: ../home.html");
    exit();
}
else
{
    define('acc', TRUE);
    require_once "../php/functions.php";
    require_once "../php/print_functions.php";

    $sez = $_SESSION["name"];
    $contenuto = "";

    if($sez == "segreteria")
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

        $glist = guideList(0);

        $contenuto = $contenuto . printFormTour($glist);
    }

    if($sez == "guide")
    {
        $contenuto = printError("Non hai accesso a questa sezione. Torna all'<a href=\"index.php\">area di amministrazione ".$_SESSION["name"]."</a>.");
    }

    $utente = $_SESSION["username"] . " (" . $_SESSION["name"].")";
    $logout = '<span class="rightfoot">Sei autenticato come: ' .$utente. '</span>'. printLogoutForm("text");
    $script = '<script type="text/javascript" src="../js/check_form_tour.js"></script>';
    $path = '<a href="../login.php">Accesso amministrazione</a> > <a href="../admin/index.php">Amministrazione ' .$sez . '</a> > Aggiunta <span xml:lang="fr">Tour</span>';

    printPage("Aggiunta Tour", "Aggiunta <span xml:lang=\"fr\">Tours</span>", $path, $contenuto, $logout . $script, "../");
}
