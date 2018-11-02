<?php

session_start();

if(!isset($_SESSION["name"]))
{
    header("Location: ../home.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    define('acc', TRUE);
    require_once "../php/db_conn.php";
    require_once "../php/functions.php";

    $nome = trim(strip_tags($_POST['nome']));
    $prezzo_audioguida = trim($_POST['prezzo_audioguida']);
    $prezzo = trim($_POST['prezzo']);

    $_SESSION['error'] = null;

    if(!$nome)
    {
        if(!$_SESSION['error'])
        {
            $_SESSION['error'] = '<ul>';
        }
        $_SESSION['error'] = $_SESSION['error'] . "<li>Nome non inserito.</li>";
    }
    else
    {
        if(!validName($nome, 2, 32))
        {
            if(!$_SESSION['error'])
            {
                $_SESSION['error'] = '<ul>';
            }
            $_SESSION['error'] = $_SESSION['error'] . "<li>Il nome può contenere solo caratteri dell'alfabeto, numeri e spazi.</li>";
        }
    }

    if(!$prezzo)
    {
        if(!$_SESSION['error'])
        {
            $_SESSION['error'] = '<ul>';
        }
        $_SESSION['error'] = $_SESSION['error'] . "<li>Prezzo non inserito.</li>";
    }
    else
    {
        if(!isDecimal($prezzo,3))
        {
            if(!$_SESSION['error'])
            {
                $_SESSION['error'] = '<ul>';
            }
            $_SESSION['error'] = $_SESSION['error'] . "<li>Prezzo inserito non valido.</li>";
        }
    }

    if(!$prezzo_audioguida)
    {
        if(!$_SESSION['error'])
        {
            $_SESSION['error'] = '<ul>';
        }
        $_SESSION['error'] = $_SESSION['error'] . "<li>Prezzo audioguida non inserito.</li>";
    }
    else
    {
        if(!isDecimal($prezzo_audioguida,3))
        {
            if(!$_SESSION['error'])
            {
                $_SESSION['error'] = '<ul>';
            }
            $_SESSION['error'] = $_SESSION['error'] . "<li>Prezzo audioguida non valido.</li>";
        }
    }

    if($_SESSION['error'])
    {
        mysqli_close($conn);
        header("Location: ../admin/tipologie.php");
        exit();
    }

    $sql = "UPDATE Prezzi SET
    descrizione='" . $nome . "',
    prezzo='" . $prezzo . "',
    prezzo_audioguida='". $prezzo_audioguida . "'
    WHERE id='" . $_POST['id'] . "'";

    if (mysqli_query($conn, $sql))
    {
        mysqli_close($conn);
        $_SESSION['msg'] = "Modifica eseguita con successo.";
    	header("Location: ../admin/tipologie.php");
        exit();
    }
    else
    {
        mysqli_close($conn);
        $_SESSION['error'] = "Si è verificato un problema con il database";
        header("Location: ../admin/tipologie.php");
        exit();
    }
}

?>
