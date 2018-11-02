var className = "errori";

function mostraErrore(campo, messaggio) {
	var e = document.createElement("strong");
	e.className = className;
	e.appendChild(document.createTextNode(messaggio));
	campo.parentNode.appendChild(e);
}

function checkNome() {
	var campo = document.getElementById('nomeTour');
	var espressione_regolare = /^[0-9a-zA-Zòàùèéì\ ]{2,64}$/;
	if(campo.value.match(espressione_regolare)) {
		return true;
	} else {
		mostraErrore(document.getElementById("err_js"), "Il nome del Tour deve contenere da 2 a 64 caratteri alfanumerici o spazi");
		return false;
	}
}

function checkDescrizione() {
	var campo = document.getElementById('descrizioneTour');
	var espressione_regolare = /.{10,255}/;
	if(campo.value.match(espressione_regolare)) {
		return true;
	} else {
		mostraErrore(document.getElementById("err_js"), "La descrizione del Tour deve contenere da 10 a 255 caratteri");
		return false;
	}
}

function checkPrezzo() {
	var campo = document.getElementById('prezzoTour');
	var espressione_regolare = /^[0-9]{1,4}\.[0-9]{2,2}$/;

	if(campo.value.match(espressione_regolare)) {
		return true;
	} else {
		mostraErrore(document.getElementById("err_js"), 'Il "Prezzo" è scritto scorrettamente: si usino due cifre dopo il punto decimale');
		return false;
	}
}

function validazioneForm() {
	// elimina eventuali precedenti segnalazioni
	var elements = document.getElementsByClassName(className);
	for (var i=0; i<elements.length; i++) {
		elements[i].parentNode.removeChild(elements[i]);
	}

	return checkNome() && checkDescrizione() && checkPrezzo();
}
