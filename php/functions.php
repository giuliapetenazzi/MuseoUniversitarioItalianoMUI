<?php

if(!defined('acc'))
{
   header("Location: ../notfound.html");
   exit();
}

function checkLogin($name, $pass)
{
    require "db_conn.php";

    $retval["err"] = false;
    $sql = "SELECT * FROM Utenti WHERE username = '".$name."'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) <= 0)
    {
        $retval["err"] = true;
        $retval["err_msg"] = "Nome utente non trovato";
    }
    else
    {
        $row = mysqli_fetch_assoc($result);
        if($pass == md5($row["password"]))
        {
            $retval["nome"] = $row["nome"];
            $retval["username"] = $row["username"];
            $retval["ruolo"] = $row["ruolo"];
            $retval["id"] = $row["id"];
        }
        else
        {
            $retval["err"] = true;
            $retval["err_msg"] = "Password errata";
        }
    }
    mysqli_close($conn);
    return $retval;
}

function checkData($d, $m, $y)
{
    if(checkdate($m, $d, $y))
    {
        $date = $y . "-" . sprintf("%02d", $m) . "-" . sprintf("%02d", $d);
    }
    else
    {
        $date = false;
    }

    return $date;
}

function isNumber($n,$max=1)
{
    if($max > 1)
    {
        $regexp = '/^[1-9]{0,'.($max-1).'}\d$/';
        if((preg_match($regexp, $n)) === 1)
        {
            return true;
        }
    }
    else
    {
        if((preg_match("/\d/", $n)) === 1)
        {
            return true;
        }
    }
    return false;
}

function isDecimal($n,$max=1)
{
    if($max > 1)
    {
        $regexp = '/^\d{1,'.($max-1).'}(\.\d{1,2})?$/';
        if((preg_match($regexp, $n)) === 1)
        {
            return true;
        }
    }
    else
    {
        $regexp = '/^\d(\.\d{1,2})?$/';
        if((preg_match($regexp, $n)) === 1)
        {
            return true;
        }
    }
    return false;
}

function validName($s, $min=1, $max=null)
{
    if(isset($max))
    {
        $regexp = '/^[a-zA-Zòàùèéì\s\d]{'.$min.','.$max.'}$/';
        if(preg_match($regexp, $s) === 0)
        {
            return false;
        }
    }
    else
    {
        $regexp = '/^[a-zA-Zòàùèéì\s\d]+$/';
        if(preg_match($regexp, $s) === 0)
        {
            return false;
        }
    }

    return true;
}


function searchTicket($datainizio, $datafine)
{
    require "db_conn.php";

    $result = array();
    $sql="SELECT * FROM Biglietti WHERE data >= '$datainizio' AND data <= '$datafine'";
    $ris = mysqli_query($conn, $sql);
    if (mysqli_num_rows($ris) > 0)
    {
        while ($row=mysqli_fetch_assoc($ris))
        {
            $biglietto = array('nominativo' => $row['nominativo'], 'data' => $row['data'], 'prezzo_totale' => $row['prezzo_totale'], 'id_tour' => $row['id_tour'], 'id' => $row['id']);
            array_push($result, $biglietto);
        }
    }
    mysqli_close($conn);
    return $result;
}

function getTicket($id)
{
    require "db_conn.php";

    $result = array();
    $sql="SELECT * FROM Biglietti WHERE id = '$id'";
    $ris = mysqli_query($conn, $sql);
    if (mysqli_num_rows($ris) > 0)
    {
        if ($row=mysqli_fetch_assoc($ris))
        {
            $biglietto = array('nominativo' => $row['nominativo'], 'data' => $row['data'], 'prezzo_totale' => $row['prezzo_totale'], 'id_tour' => $row['id_tour'], 'id' => $row['id']);
        }
    }
    mysqli_close($conn);
    return $biglietto;
}

function searchTour($tour)
{
    require "db_conn.php";

    if($tour != null)
    {
        $result = null;
    	$sql_tour="SELECT * FROM Tours WHERE id = '$tour'";
    	$ris_tour = mysqli_query($conn, $sql_tour);
    	if (mysqli_num_rows($ris_tour) > 0)
        {
    		if ($row_tour=mysqli_fetch_assoc($ris_tour))
            {
                $result = $row_tour['nome'];
    		}
    	}
    }
    if($tour == null)
    {
        $result = array();
        $sql_tour="SELECT Tours.*, Utenti.nome AS guida FROM Tours, Utenti WHERE Tours.id_guida = Utenti.id AND Tours.id <> '1'";
    	$ris_tour = mysqli_query($conn, $sql_tour);
    	if (mysqli_num_rows($ris_tour) > 0)
        {
    		while ($row_tour=mysqli_fetch_assoc($ris_tour))
            {
                $tour = array('id' => $row_tour['id'], 'nome' => $row_tour['nome'], 'descrizione' => $row_tour['descrizione'], 'prezzo' => $row_tour['prezzo'], 'guida' => $row_tour['guida']);
                array_push($result, $tour);
    		}
    	}
    }
    mysqli_close($conn);
    return $result;
}

function searchDetails($tipo)
{
    require "db_conn.php";

    $result = array();
	$sql_int="SELECT * FROM AssPrezzi, Prezzi WHERE Prezzi.id = AssPrezzi.prezzo AND AssPrezzi.biglietto = '$tipo'";
	$ris_int = mysqli_query($conn, $sql_int);
	if (mysqli_num_rows($ris_int) > 0)
    {
		while ($row_int=mysqli_fetch_assoc($ris_int))
        {
			if ($row_int['quantita'])
            {
                $det = array('quantita' => $row_int['quantita'], 'descrizione' => $row_int['descrizione']);
                array_push($result, $det);
			}
		}
	}
    mysqli_close($conn);
    return $result;
}

function guideList($id)
{
    require "db_conn.php";

    $result = array();
    $sql_int = "SELECT nome FROM Utenti WHERE id ='$id'";
    $ris_int = mysqli_query($conn, $sql_int);

    if ($row=mysqli_fetch_assoc($ris_int))
    {
        $guida = array("id" => $id, "nome" => $row['nome']);
        array_push($result, $guida);
    }

    $sql_not_int = "SELECT nome, id FROM Utenti WHERE ruolo='guide' AND id <> '" . $id . "'";
    $result_not_int = mysqli_query($conn, $sql_not_int);

    while($row_not_int = mysqli_fetch_assoc($result_not_int))
    {
        $guida = array("id" => $row_not_int['id'], "nome" => $row_not_int['nome']);
        array_push($result, $guida);
    }
    mysqli_close($conn);
    return $result;
}

function ticketList()
{
    require "db_conn.php";

    $result = array();
    $sql = "SELECT * FROM Prezzi";
	$ris_list = mysqli_query($conn, $sql);
    if (mysqli_num_rows($ris_list) > 0)
    {
		while ($row_list=mysqli_fetch_assoc($ris_list))
        {
                $ticket = array('id' => $row_list['id'], 'descrizione' => $row_list['descrizione'], 'prezzo' => $row_list['prezzo'], 'prezzo_audioguida' => $row_list['prezzo_audioguida']);
                array_push($result, $ticket);
		}
	}
    mysqli_close($conn);
    return $result;
}

function tourList()
{
    require "db_conn.php";

    $result = array();
    $sql = 'SELECT * FROM Tours';
	$ris_list = mysqli_query($conn, $sql);
    if (mysqli_num_rows($ris_list) > 0)
    {
		while ($row_list=mysqli_fetch_assoc($ris_list))
        {
            if($row_list['id'] != 1)
            {
                $tour = array('id' => $row_list['id'], 'nome' => $row_list['nome'], 'descrizione' => $row_list['descrizione'], 'prezzo' => $row_list['prezzo'], 'id_guida' => $row_list['id_guida']);
                array_push($result, $tour);
            }
		}
	}
    mysqli_close($conn);
    return $result;
}

?>
