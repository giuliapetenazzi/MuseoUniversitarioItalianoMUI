var className = "errori";

function mostraErrore(campo, messaggio) {
	var e = document.createElement("strong");
	e.className = className;
	e.appendChild(document.createTextNode(messaggio));
	campo.parentNode.appendChild(e);
}

function checkNomi() {
	var campi_nome = document.getElementsByName('nome');
	for (var i=0; i<campi_nome.length; i++) {
		var espressione_regolare = /^[0-9a-zA-Zòàùèéì\ ]{2,64}$/;
		if(!campi_nome[i].value.match(espressione_regolare)) {
			mostraErrore(document.getElementById("err_js"+i), 'I nomi dei Tours devono contenere da 2 a 64 caratteri alfanumerici o spazi');
			return false;
		}
	}
	return true;
}

function checkPrezzi() {
	var campi_prezzo = document.getElementsByName('prezzo');
	for (var i=0; i<campi_prezzo.length; i++) {
		var espressione_regolare = /^[0-9]{1,4}\.[0-9]{2,2}$/;
		if(!campi_prezzo[i].value.match(espressione_regolare)) {
			mostraErrore(document.getElementById("err_js"+i), 'Il "Prezzo del biglietto" è scritto scorrettamente: si usino due cifre dopo il punto decimale');
			return false;
		}
	}
	return true;
}

function checkPrezziAudioGuida() {
	var campi_prezzo = document.getElementsByName('prezzo_audioguida');
	for (var i=0; i<campi_prezzo.length; i++) {
		var espressione_regolare = /^[0-9]{1,4}\.[0-9]{2,2}$/;
		if(!campi_prezzo[i].value.match(espressione_regolare)) {
			mostraErrore(document.getElementById("err_js"+i), 'Il "Prezzo audioguida" è scritto scorrettamente: si usino due cifre dopo il punto decimale');
			return false;
		}
	}
	return true;
}

function validazioneForm() {
	// elimina eventuali precedenti segnalazioni
	var elements = document.getElementsByClassName(className);
	for (var i=0; i<elements.length; i++) {
		elements[i].parentNode.removeChild(elements[i]);
	}

	return checkNomi() && checkPrezzi() && checkPrezziAudioGuida();
}
