<?php

session_start();

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['acquista'])))
{
    define('acc', TRUE);
    require_once "../php/db_conn.php";
    require_once "../php/functions.php";
    require_once "../php/print_functions.php";

    $nominativo = stripslashes(strip_tags(trim($_POST['nominativo'])));
    $data = checkData(trim($_POST['gg']), trim($_POST['mm']), trim($_POST['aaaa']));
    $id_tour = trim($_POST['tour']);

    // $_POST['1'] -> Interi
    // $_POST['2'] -> Bambini
    // $_POST['3'] -> Ragazzi
    // $_POST['4'] -> Anziani
    // $_POST['5'] -> Studenti
    // $_POST['6'] -> Disabili

    $_SESSION['error'] = null;

    $err = false;
    for($i = 1; ($i <= 6) && (!$err); $i++)
    {
        if(!isNumber($_POST[$i],2))
        {
            if(!$_SESSION['error'])
            {
                $_SESSION['error'] = '<ul>';
            }
            $_SESSION['error'] = $_SESSION['error'] . "<li>Biglietti richiesti non validi.</li>";
            $err = true;
        }
    }

    $tot_persone = 0;

    if(!$err)
    {
        for($i = 1; $i <= 6; $i++)
        {
            $tot_persone = $tot_persone + $_POST[$i];
        }

        if($tot_persone <= 0)
        {
            if(!$_SESSION['error'])
            {
                $_SESSION['error'] = '<ul>';
            }
            $_SESSION['error'] = $_SESSION['error'] . "<li>Non è stato specificato alcun biglietto.</li>";
        }
    }

    if(!$nominativo)
    {
        if(!$_SESSION['error'])
        {
            $_SESSION['error'] = '<ul>';
        }
        $_SESSION['error'] = $_SESSION['error'] . "<li>Il nominativo non è stato inserito.</li>";
    }
    else
    {
        if(!validName($nominativo, 2, 64))
        {
            if(!$_SESSION['error'])
            {
                $_SESSION['error'] = '<ul>';
            }
            $_SESSION['error'] = $_SESSION['error'] . "<li>Il nominativo può contenere solo caratteri dell'alfabeto, numeri e spazi.</li>";
        }
    }

    if((!$data) || ($data < date('Y-m-d')))
    {
        if(!$_SESSION['error'])
        {
            $_SESSION['error'] = '<ul>';
        }
        $_SESSION['error'] = $_SESSION['error'] . "<li>Data inserita non corretta o già passata.</li>";
    }

    if(isset($_SESSION['error']))
    {
        mysqli_close($conn);
        $_SESSION['error'] = $_SESSION['error'] . '</ul>';
        header("Location: ../form_biglietti.php");
        exit();
    }

    if($id_tour != 1)
    {
        $sql_ptour = "SELECT prezzo FROM Tours WHERE id ='" . $id_tour ."'";
        $ris_ptour = mysqli_query($conn, $sql_ptour);
    	if ($rowp = mysqli_fetch_assoc($ris_ptour))
        {
    		$prezzo_tour = $rowp['prezzo'];
    	}
    }
    else
    {
        $prezzo_tour = 0;
    }

	$tot_prezzo = $tot_persone * $prezzo_tour;

    for($i = 1; $i <= 6; $i++)
    {
        if($_POST[$i] > 0)
        {
            $sql_prezzo = "SELECT prezzo FROM Prezzi WHERE id ='".$i."'";
            $ris_prezzo = mysqli_query($conn, $sql_prezzo);
            $row = mysqli_fetch_assoc($ris_prezzo);
            $prezzo = $row['prezzo'];
            $tot_prezzo = $tot_prezzo + ($prezzo * $_POST[$i]);
        }
    }

    $sql_ins = "INSERT INTO Biglietti (nominativo, data, id_tour, prezzo_totale) VALUES ('$nominativo', '$data', '$id_tour', '$tot_prezzo')";
    if(mysqli_query($conn, $sql_ins))
    {
        $bid = mysqli_insert_id($conn);
        for($i = 1; $i <= 6; $i++)
        {
            if($_POST[$i] > 0)
            {
                $sql_ass = "INSERT INTO AssPrezzi (biglietto, prezzo, quantita) VALUES ('$bid', '$i', '$_POST[$i]')";
                if(!mysqli_query($conn, $sql_ass))
                {
                    $_SESSION['error'] = "Si è verificato un problema con il database";
                    header("Location: ../form_biglietti.php");
                    exit();
                }
            }
        }
        $biglietto = getTicket($bid);
        $res_tour = searchTour($biglietto['id_tour']);
        $res_details = searchDetails($biglietto['id']);
        $_SESSION['msg'] = "Biglietto acquistato con successo. Riepilogo dati:" . printTicket($biglietto) . printTour($res_tour). printDetails($res_details);
        mysqli_close($conn);
    	header("Location: ../form_biglietti.php");
        exit();
    }
    else
    {
        mysqli_close($conn);
        $_SESSION['error'] = "Si è verificato un problema con il database";
        header("Location: ../form_biglietti.php");
        exit();
    }
}
?>
