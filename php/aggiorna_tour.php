<?php

session_start();

if(!isset($_SESSION["name"]))
{
    header("Location: ../home.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST['modifica']))
    {
        define('acc', TRUE);
        require_once "../php/db_conn.php";
        require_once "../php/functions.php";

        $nome = stripslashes(strip_tags(trim($_POST['nome'])));
        $desc = stripslashes(strip_tags(trim($_POST['descrizione'])));
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

        if(!$desc)
        {
            if(!$_SESSION['error'])
            {
                $_SESSION['error'] = '<ul>';
            }
            $_SESSION['error'] = $_SESSION['error'] . "<li>Descrizione non inserita.</li>";
        }
        else
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

        if($_SESSION['error'])
        {
            mysqli_close($conn);
            $_SESSION['error'] = $_SESSION['error'] . '</ul>';
            header("Location: ../admin/tours.php");
            exit();
        }

        $cdesc = mysqli_real_escape_string($conn, $desc);

        $sql = "UPDATE Tours SET
        nome='" . $nome . "',
        descrizione='". $cdesc . "',
        prezzo='" . $prezzo . "',
        id_guida='" . $_POST['guida'] . "'
        WHERE id='" . $_POST['id_tour'] . "'";

        if (mysqli_query($conn, $sql))
        {
            mysqli_close($conn);
            $_SESSION['msg'] = "Modifica eseguita con successo.";
        	header("Location: ../admin/tours.php");
            exit();
        }
        else
        {
            $_SESSION['error'] = "Si è verificato un problema con il database";
            mysqli_close($conn);
            header("Location: ../admin/tours.php");
            exit();
        }
    }
    else
    {
        if(isset($_POST['elimina']))
        {
            if(isset($_POST['conferma']))
            {
                define('acc', TRUE);
                require_once "../php/db_conn.php";

                $sql = "DELETE FROM Tours WHERE id='" . $_POST['id_tour'] . "'";

                if (mysqli_query($conn, $sql))
                {
                    mysqli_close($conn);
                    $_SESSION['msg'] = "Eliminazione eseguita con successo";
                	header("Location: ../admin/tours.php");
                    exit();
                }
                else
                {
                    $_SESSION['error'] = "Si è verificato un problema con il database";
                    mysqli_close($conn);
                    header("Location: ../admin/tours.php");
                    exit();
                }
            }
            else
            {
                $_SESSION['error'] = "Eliminazione non confermata attraverso la spunta appropriata. ";
                header("Location: ../admin/tours.php");
                exit();
            }
        }
        else
        {
        	header("Location: ../admin/tours.php");
            exit();
        }
    }
}

?>
