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

    if($sez == "segreteria")
    {
        if(($_SERVER["REQUEST_METHOD"] == "GET") && (isset($_GET["search"])))
        {
            $datainizio = trim($_GET['aaaai']) . "-" . trim($_GET['mmi']) . "-" . trim($_GET['ggi']);
        	$datafine = trim($_GET['aaaaf']) . "-" . trim($_GET['mmf']) . "-" . trim($_GET['ggf']);
            if($datainizio>$datafine)
            {

                $contenuto = printError("La data di fine ricerca deve essere uguale o successiva alla data di inizio");
                $contenuto = $contenuto . printRicercaBiglietti();
            }
            else
            {
                $result = searchTicket($datainizio, $datafine);
                if(empty($result))
                {
                    $contenuto = printError("La ricerca non ha prodotto nessun risultato");
                    $contenuto = $contenuto . printRicercaBiglietti();
                }
                else
                {
                    $contenuto = printRicercaBiglietti();
                    $contenuto = $contenuto . '<h3>Lista biglietti trovati</h3>';
                    foreach ($result as $biglietto)
                    {
                        $res_tour = searchTour($biglietto['id_tour']);
                        $res_details = searchDetails($biglietto['id']);
                        $contenuto = $contenuto . printTicket($biglietto);
                        $contenuto = $contenuto . printTour($res_tour);
                        $contenuto = $contenuto . printDetails($res_details);
                    }
                }
            }
        }
        else
        {
            $contenuto = printRicercaBiglietti();
        }

    }
    if($sez == "guide")
    {
        $contenuto = printError("Non hai accesso a questa sezione");
    }

    $utente = $_SESSION["username"] . " (" . $_SESSION["name"].")";
    $logout = '<span class="rightfoot">Sei autenticato come: ' .$utente. '</span>'. printLogoutForm("text");
    $script = '<script type="text/javascript" src="../js/check_form_mostra_biglietti.js"></script>';
    $path = '<a href="../login.php">Accesso amministrazione</a> > <a href="../admin/index.php">Amministrazione ' .$sez . '</a> > Mostra biglietti';

    printPage("Visualizza biglietti", "Visualizza biglietti ", $path, $contenuto, $logout . $script, "../");
}
