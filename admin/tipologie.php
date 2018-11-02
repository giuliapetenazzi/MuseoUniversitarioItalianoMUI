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

        $ticketlist = ticketList();
        if(!empty($ticketlist))
        {
            $i = 0;
            foreach ($ticketlist as $ticket)
            {
                $contenuto = $contenuto . printTicketTypes($ticket['id'], $ticket['descrizione'], $ticket['prezzo'], $ticket['prezzo_audioguida'], $i);
                $i++;
            }
        }
        else
        {
            $contenuto = $contenuto . printError("Nessuna tipologia di biglietto trovata");
        }
    }
    if($sez == "guide")
    {
        $contenuto = printError("Non hai accesso a questa sezione. Torna all'<a href=\"index.php\">area di amministrazione ".$_SESSION["name"]."</a>.");
    }

    $utente = $_SESSION["username"] . " (" . $_SESSION["name"].")";
    $logout = '<span class="rightfoot">Sei autenticato come: ' .$utente. '</span>'. printLogoutForm("text");
    $script = '<script type="text/javascript" src="../js/check_form_tipologie.js"></script>';

    $path = '<a href="../login.php">Accesso amministrazione</a> > <a href="../admin/index.php">Amministrazione ' .$sez . '</a> > Modifica biglietti';

    printPage("Modifica biglietti", "Modifica biglietti ", $path, $contenuto, $logout . $script, "../");
}
?>
