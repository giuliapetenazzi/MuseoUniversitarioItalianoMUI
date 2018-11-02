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

    $tourlist = tourList();
    if(!empty($tourlist))
    {
        $i = 0;
        foreach ($tourlist as $tour)
        {
            $contenuto = $contenuto . printTours($tour['id'], $tour['nome'], $tour['descrizione'], $tour['prezzo']);
            $glist = guideList($tour['id_guida']);
            $contenuto = $contenuto . printGuide($glist, $i);
            $i++;
        }
    }

    $utente = $_SESSION["username"] . " (" . $_SESSION["name"].")";
    $logout = '<span class="rightfoot">Sei autenticato come: ' .$utente. '</span>'. printLogoutForm("text");
    $script = '<script type="text/javascript" src="../js/check_form_modifica_tour.js"></script>';

    $path = '<a href="../login.php">Accesso amministrazione</a> > <a href="../admin/index.php">Amministrazione ' .$sez . '</a> > Modifica <span xml:lang="fr">Tours</span>';

    printPage("Modifica Tours", "Modifica Tours", $path, $contenuto, $logout . $script, "../");
}
?>
