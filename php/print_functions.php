<?php

if(!defined('acc'))
{
   header("Location: ../notfound.html");
   exit();
}

// $title           -> Tag title
// $tname           -> Titolo del contenuto
// $path            -> Percorso del breadcrump
// $content         -> Contenuto della pagina
// $foot            -> Contenuto AGGIUNTIVO del footer
// $prefix          -> Prefisso che riporta nella cartella root dalla posizione corrente (es. '../', '../../')
// $current_page    -> Indica se deve evidenziare una pagina nel menu di navigazione
// $keywords        -> Indica keywords aggiuntive
function printPage($title, $tname, $path, $content, $foot="", $prefix="", $current_page="", $keywords="")
{
    $page = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="it" lang="it">
        	<head>
        		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        		<meta name="title" content="'.$title.' - MUI" />
        		<meta name="description" content="Museo dedicato alla cultura Universitaria Italiana" />
        		<meta name="keywords" content="'.$keywords.' MUI, Museo Universitario, Museo Italiano, Cultura Italiana, Museo Universitario Italiano, Università, Padova, Prato della Valle, Venezia" />
        		<meta name="author" content="Silvio Meneguzzo, Giovanni Prete, Fabio Vianello, Giulia Petenazzi" />
        		<meta name="language" content="italian it" />
        		<link rel="stylesheet" type="text/css" href="'.$prefix.'css/stylesheet.css" media="screen and (min-width: 768px)" />
        		<link rel="stylesheet" type="text/css" href="'.$prefix.'css/stylesheet_mobile.css" media="screen and (max-width: 768px)" />
        		<link rel="stylesheet" type="text/css" href="'.$prefix.'css/stylesheet_print.css" media="print" />
        		<link rel="shortcut icon" href="'.$prefix.'img/favicon.ico" />
        		<script type="text/javascript" src="'.$prefix.'js/script.js"></script>
        		<title>'.$title.' - MUI</title>
        	</head>
        	<body>
        		<div id="header">
        			<a class="hidden" href="#contenuto">Vai alla storia del Museo</a>
        			<img id="logo" src="'.$prefix.'img/logo/logo_MUI_128x128.png" alt="Museo Universitario Italiano"/>
        			<h1><acronym title="Museo Universitario Italiano">MUI</acronym> - Museo<br />Universitario Italiano</h1>
        		</div>
        		<div id="nav">
        			<ul>
        				<li '.($current_page=='home' ? 'id="current_page"' : '').'><a href="'.$prefix.'home.html">Home</a></li>
        				<li '.($current_page=='orari' ? 'id="current_page"' : '').'><a href="'.$prefix.'orari_e_servizi.html">Orari e servizi</a></li>
        				<li '.($current_page=='biglietti' ? 'id="current_page"' : '').'><a href="'.$prefix.'biglietti.php">Biglietti</a></li>
        				<li '.($current_page=='tours' ? 'id="current_page"' : '').'><a href="'.$prefix.'tours.php"><span xml:lang="fr">Tours</span></a></li>
        				<li '.($current_page=='contati' ? 'id="current_page"' : '').'><a href="'.$prefix.'contatti.html">Contatti</a></li>
        				<li '.($current_page=='dove' ? 'id="current_page"' : '').'><a href="'.$prefix.'dove.html">Dove Siamo</a></li>
        			</ul>
        		</div>
        		<div id="path">Ti trovi in: '.$path.'</div>
        		<div id="content">
        			<h2>'.$tname.'</h2>'.$content.'
                </div>
                <div id="footer">
                        <img src="'.$prefix.'img/css.png" class="valid" alt="CSS Valid!"/>
                        <img src="'.$prefix.'img/xhtml.png" class="valid" alt="XHTML 1.0 Valid!"/>
                        '.$foot.'
                </div>
            </body>
            </html>';

    echo $page;
    exit();
}

function printTicket($b)
{
    $page ='
    <ul class="descrizione">
    <li><em>Nominativo:  </em>'.  $b['nominativo'] . '</li>
    <li><em>Data:  </em>' .$b['data'] . '</li>
    <li><em>Prezzo totale:  </em>'.  $b['prezzo_totale'] . '</li>';

    return $page;
}

function printTour($t)
{
    $page = "";
    if($t)
    {
        $page = $page . '<li><em><span xml:lang="fr"> Tour</span>:  </em>' .  $t . '</li>';
    }
    return $page;
}

function printDetails($d)
{
    $page = '<li><em>Dettagli:  </em> <ul class="dettaglio">';
    foreach ($d as $details)
    {
        $page = $page . '<li>' .  $details['quantita'] . ' - ' . $details['descrizione'] . '</li>';
    }
    return $page . '</ul></li></ul>';
}

function printTicketTypes($id, $desc, $price, $paudio, $index)
{
    $page = '<form action="../php/aggiorna_tipologia.php" method="post" onsubmit="return validazioneForm();">
    <div class="form_group">
		<input class="hidden" name="id" value="' . $id . '"/>
        <label> Nome della tipologia del biglietto: </label>
        <input type="text" name="nome" value="' . $desc . '"/>
    </div>
    <div class="form_group">
        <label> Prezzo del biglietto: </label>
        <input type="text" class="data" name="prezzo" value="' . $price . '"/>
    </div>
    <div class="form_group">
        <label> Prezzo audioguida: </label>
        <input type="text" class="data" name="prezzo_audioguida" value="' . $paudio . '"/>

	   <input type="submit" class="grad" name="change" value="Modifica" />
       <input type="reset" class="grad" name="reset" value="Annulla" />
		<div><p id="err_js' . $index . '"></p></div>
        </div>
    </form>';

    return $page;
}

function printTours($id, $name, $desc, $price)
{
    $page = '<form action="../php/aggiorna_tour.php" method="post" onsubmit="return validazioneForm();">
    <div class="form_group">
		<input class="hidden" name="id_tour" value="' . $id . '"/>
        <label> Nome del <span xml:lang="fr">tour</span>: </label>
        <input type="text" name="nome" value="' . $name . '"/>
    </div>
    <div class="form_group">
        <label> Descrizione: </label>
        <textarea rows="6" cols="25" name="descrizione">' . $desc . '</textarea>
    </div>
    <div class="form_group">
        <label> Prezzo (€): </label>
        <input type="text" class="data" name="prezzo" value="' . $price . '"/>
    </div>';

    return $page;
}

function printGuide($glist, $index)
{
    $page = '<div class="form_group">
    <label>Guida: </label>
    <select name="guida">';

    foreach ($glist as $guida)
    {
        $page = $page . '<option value="' .$guida["id"]. '">' . $guida["nome"] . '</option>';
    }

    $page = $page . '</select>
    </div>
    <div class="form_group">
        Vuoi eliminare il <span xml:lang="fr">Tour</span>?
        <input type="checkbox" name="conferma" value="Conferma" />
    </div>
    <div><p id="err_js' . $index . '"></p></div>
    <div class="form_group">
		<input type="submit" class="grad" name="modifica" value="Modifica" />
		<input type="submit" class="grad" name="elimina" value="Elimina" />
		<input type="reset" class="grad" name="reset" value="Annulla" />
    </div>
    </form>';

    return $page;
}

function printFormTour($glist)
{
    $page = '<form action="../php/inserisci_tour.php" method="post" onsubmit="return validazioneForm();">
    <div class="form_group">
        <label> Nome del <span xml:lang="fr">tour</span>: </label>
        <input type="text" id="nomeTour" name="nome"/>
    </div>
    <div class="form_group">
        <label> Descrizione: </label>
        <textarea rows="6" cols="20" id="descrizioneTour" name="descrizione"></textarea>
    </div>
    <div class="form_group">
        <label> Prezzo (€): </label>
        <input type="text" class="data" id="prezzoTour" name="prezzo" value="2.00"/>
    </div>
    <div class="form_group">
    <label>Guida: </label>
    <select name="guida" id="guida">';

    foreach ($glist as $guida)
    {
        $page = $page . '<option value="' .$guida["id"]. '">' . $guida["nome"] . '</option>';
    }

    $page = $page . '</select>
    <div><p id="err_js"></p></div>
    </div>
    <div class="form_group">
		<input type="submit" class="grad" name="aggiungi" value="Aggiungi" />
		<input type="reset" class="grad" name="reset" value="Annulla" />
    </div>
    </form>';

    return $page;
}

function printError($err)
{
    $page = '<h3>Errore</h3>
    <div class="error">' . $err . '</div>';

    return $page;
}

function printMsg($msg)
{
    $page = '<h3>Avviso</h3>
    <div>' . $msg . '</div>';

    return $page;
}

function printToursInfo($tlist)
{
    $page = '<img src="img/omino.jpg" class = "tours" alt="opera raffigurante un omino stilizzato"/>
    			<img src="img/cane.jpg" class = "tours" alt="ritratto a matita di un cane"/>';

    foreach ($tlist as $tour)
    {
        $page = $page . '<h3>' . $tour["nome"] . '</h3>
            <ul class="descrizione">
            <li>' . $tour["descrizione"] . '</li>
            <li><em>Prezzo:  </em>'. $tour["prezzo"] .'</li>
            <li><em>Guida:  </em>' . $tour["guida"] . '</li>
            </ul>';
    }

    return $page;
}

function printFormAcquisto($tours, $types)
{
    $nowd = date('d');
    $nowm = date('m');
    $nowy = date('Y');
    $page ='<form action="php/acquista_biglietto.php" method="post" onsubmit="return validazioneForm();">
    <div><p id="err_js"></p></div>
    <div class="form_group">
        <label> Nominativo: </label>
        <input type="text" id="nominativo" name="nominativo" maxlength="64" />
    </div>
    <div class="form_group">
        <label>Data della visita <em> (giorno mese anno): </em></label>
        <input type="text" class="data" id="gg" name="gg" value="'.$nowd.'" />
        <input type="text" class="data" id="mm" name="mm" value="'.$nowm.'" />
        <input type="text" class="data" id="aaaa" name="aaaa" value="'.$nowy.'" />
    </div>
    <div class="form_group">';

    if(!empty($tours))
    {
        $page = $page .'
    	<label>Scegliete a quale <span xml:lang="fr">tour</span> partecipare: </label>
    	<select name="tour" id="tour">';
        $page = $page . '<option value="1">Nessun tour selezionato</option>';
        foreach ($tours as $tour)
        {
            $page = $page . '<option value="' . $tour["id"] . '">'. $tour["nome"] .'</option>';
        }
        $page = $page . '</select></div>';

    }
    if(!empty($types))
    {
        $page = $page . '<fieldset><legend>Specifica il numero di biglietti <em>(0-99)</em></legend>';

        foreach ($types as $type)
        {
            $page = $page . '<div class="form_group">
			<input class="data num" type="text" name="'. $type['id'] .'" value="0" />
			<label>'. $type['descrizione'] . ' <em>('. $type['prezzo'] .' €)</em></label>
			</div>';
        }
        $page = $page .'</fieldset>
			<p><em>Il prezzo del <span xml:lang="fr">tour</span> viene applicato ad ogni singolo biglietto.</em></p>
			<p><em>Le audioguide non sono prenotabili, in quanto noleggiabili all\'entrata del museo fino ad esaurimento.</em></p>
		';
    }

    $page = $page .'
	<div class="form_group">
		<input type="submit" class="grad" name="acquista" value="Acquista" />
		<input type="reset" class="grad" name="reset" value="Cancella" />
	</div>
    </form>';

    return $page;
}

function printRicercaBiglietti()
{
    $nowd = date('d');
    $nowm = date('m');
    $nowy = date('Y');
    $page = '<form action="biglietti.php" method="get" onsubmit="return validazioneForm();">
        <div class="form_group">
            <label>Dalla data: (giorno mese anno)</label>
            <input type="text" id="ggi"  class="data"  name="ggi" value="'.$nowd.'"/>
            <input type="text" id="mmi" class="data"   name="mmi" value="'.$nowm.'"/>
            <input type="text" id="aaaai" class="data" name="aaaai" value="'.$nowy.'"/>
        </div>
        <div class="form_group">
            <label>Alla data: (giorno mese anno)</label>
            <input type="text" id="ggf"  class="data"  name="ggf" value="'.$nowd.'"/>
            <input type="text" id="mmf"  class="data"  name="mmf" value="'.$nowm.'"/>
            <input type="text" id="aaaaf" class="data" name="aaaaf" value="'.($nowy+1).'"/>
        </div>
        <div><p id="err_js"></p></div>
        <div class="form_group">
            <input type="submit" class="grad" value="Cerca" name="search" />
            <input type="reset" class="grad" value="Annulla" name="reset" />
        </div>
    </form>';

    return $page;
}

function printTicketTable($tickets)
{
    $page = '<div id = "biglietti_e_acquista">
        <a href="form_biglietti.php" class = "buttongrad not_visible"> Vai alla pagina di acquisto</a>
        <table summary="tipologia del biglietto con prezzi associati">
            <caption class="hidden">Biglietti</caption>
            <thead>
                <tr>
                    <th scope="col" class="grad">Tipologia</th>
                    <th scope="col" class="grad">Prezzo ingresso</th>
                    <th scope="col" class="grad">Prezzo audioguida</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($tickets as $ticket)
    {
        $page = $page . '<tr id="id' . $ticket["id"] .'">
            <td scope ="row" class="first_column">' . $ticket["descrizione"] . '</td>
            <td>' . $ticket["prezzo"] . ' €</td>
            <td>' . $ticket["prezzo_audioguida"] . ' €</td>
        </tr>';
    }

    $page = $page . '</tbody>
        </table></div>';

    return $page;
}

function printTicketBody()
{
    $page = '<h2> Note sui biglietti </h2>
				<h3>Disabili</h3>
                    <p class="descrizione"> Questo tipo di biglietto è acquistabile dalle persone che presentino disabilità certificata da appropriato documento (l.104/92) e dai loro accompagnatori.</p>
				<h3>Studenti</h3>
                    <p class = "descrizione"> Questo tipo di biglietto è acquistabile dalle persone dai 13 ai 25 anni frequentanti la scuola secondaria o l\'università. Nel particolare caso di studenti universitari si è tenuti alla presentazione del badge universitario o qualsiasi altro documento che provi l\'iscrizione all\'università. </p>
				<h3>Documenti</h3>
		           <p class = "descrizione"> La biglietteria si riserva la possibilità di richiedere un documento per accertarsi dell\'età delle persone. Nel caso in cui non si riescano a fornire i documenti richiesti, la biglietteria è autorizzata a non concedere l\'agevolazione. In tal caso il visitatore sarà tenuto al pagamento del prezzo del biglietto intero.</p>
                <h3>Audioguida</h3>
				            <p class = "descrizione"> All\'interno è possibile noleggiare un\'audioguida che accompagnerà la visita del nostro museo con interessanti e brevi spiegazioni al prezzo indicato nella tabella sovrastante, al fine di rendere il tuor più piacevole e istruttivo.</p>';

    return $page;
}

function printLoginForm()
{
    $page = '<form action="php/inc_login.php" method="post" onsubmit="return validazioneForm();">
         <div class="form_group">
             <label><span xml:lang="en">Username:</span></label>
             <input type="text" id="usr" name="username" />
         </div>
         <div class="form_group">
             <label><span xml:lang="en">Password:</span></label>
             <input type="password" id="pwd" name="password" />
         </div>
 	<div><p id="err_js"></p></div>
         <div class="form_group">
             <input type="submit" class="grad" value="Entra" name="login" />
             <input type="reset" class="grad" value="Cancella" name="reset" />
		 </div>
     </form>';

     return $page;
}

function printLogoutForm($type)
{
    if($type === "button")
    {
        $page = '<form action="php/inc_login.php" method="post">
            <div class="form_group">
                <input name="logout" class="hidden"/>
                <input type="submit" class="grad" value="Esci" name="logout" />
            </div>
        </form>';
    }
    if($type === "text")
    {
        $page = '<form action="../php/inc_login.php" method="post">
            <div class="form_group">
                <input name="logout" class="hidden"/>
                <input type="submit" class="rightfoot grad" value="Esci" name="logout" />
            </div>
        </form>';
    }

    return $page;
}

function printAdminMenu($type)
{
    $page = '<ul class="descrizione">
            <li><a href="biglietti.php">Cerca e visualizza biglietti</a></li>
            <li><a href="tours.php">Visualizza e modifica i <span xml:lang="fr">tours</span></a></li>';

    if($type === "segreteria")
    {
        $page = $page . '<li><a href="tipologie.php">Visualizza e modifica  le tipologie di biglietti</a></li>
            <li><a href="aggiungi_tour.php">Aggiungi un <span xml:lang="fr">tour</span></a></li>';
    }

    $page = $page . '</ul>';

    return $page;
}

?>
