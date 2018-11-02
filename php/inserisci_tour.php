<?php

session_start();

if(!isset($_SESSION["name"]))
{
    header("Location: ../home.html");
    exit();
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['aggiungi'])))
{
    define('acc', TRUE);
    require_once "db_conn.php";
    require_once "functions.php";

    $nome = stripslashes(strip_tags(trim($_POST['nome'])));
    $desc = stripslashes(strip_tags(trim($_POST['descrizione'])));
    $prezzo = trim($_POST['prezzo']);
    $guida = $_POST['guida'];

    $_SESSION['error'] = null;

    if(!$nome)
    {
        if(!$_SESSION['error'])
        {
            $_SESSION['error'] = "<ul>";
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


    if(!$desc)
    {
        if(!$_SESSION['error'])
        {
            $_SESSION['error'] = '<ul>';
        }
        $_SESSION['error'] = $_SESSION['error'] . "<li>Descrizione non inserita.</li>";
    }
    {
        if(strlen($desc) > 255)
        {
            if(!$_SESSION['error'])
            {
                $_SESSION['error'] = '<ul>';
            }
            $_SESSION['error'] = $_SESSION['error'] . "<li>La descrizione può contenere al massimo 255 caratteri. Ne sono stati usati ".strlen($desc)."</li>";
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

    if($_SESSION['error'])
    {
        mysqli_close($conn);
        $_SESSION['error'] = $_SESSION['error'] . "</ul>";
        header("Location: ../admin/aggiungi_tour.php");
        exit();
    }

    $cdesc = mysqli_real_escape_string($conn, $desc);

    $sql_ins = "INSERT INTO Tours (nome, descrizione, prezzo, id_guida) VALUES ('$nome', '$cdesc', '$prezzo', '$guida')";
    if (mysqli_query($conn, $sql_ins))
    {
		mysqli_close($conn);
        $_SESSION['msg'] = "<span xml:lang=\"fr\">Tour</span> aggiunto con successo.";
		header("Location: ../admin/aggiungi_tour.php");
        exit();
	}
    else
    {
        mysqli_close($conn);
		$_SESSION['error'] = "Si è verificato un problema con il database";
        header("Location: ../admin/aggiungi_tour.php");
        exit();
	}
}
else
{
    header("Location: ../admin/aggiungi_tour.php");
    exit();
}
?>
