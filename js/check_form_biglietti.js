var className = "errori";

function mostraErrore(campo, messaggio) {
	var e = document.createElement("strong");
	e.className = className;
	e.appendChild(document.createTextNode(messaggio));
	campo.parentNode.appendChild(e);
}

function checkNominativo() {
	var campo = document.getElementById('nominativo');
	var espressione_regolare = /^[0-9a-zA-Zòàùèéì\s]+$/;
	//var espressione_regolare = /[\w\ ]{2,64}$/;
	if(campo.value.match(espressione_regolare)) {
		return true;
	} else {
		mostraErrore(document.getElementById("err_js"), 'Il "Nominativo" deve contenere esclusivamente caratteri alfanumerici e spazi!');
		return false;
	}
}

function checkIsNumber() {
	// valida la data
	var gg = document.getElementById('gg').value;
	var mm =document.getElementById('mm').value;
	var aaaa = document.getElementById('aaaa').value;
	if(!gg.match(/^[0-3][0-9]$/) || !mm.match(/^[0-1][0-9]$/) || !aaaa.match(/^[0-9][0-9][0-9][0-9]$/)) {
		mostraErrore(document.getElementById("err_js"), 'Inserire la data nel formato: GG MM YYYY"');
		return false;
	}

	// valida che il numero di biglietti siano numeri
	var campi_num = document.getElementsByClassName('num');
	for (var i=0; i<campi_num.length; i++) {
		var espressione_regolare = /^[0-9]{1,2}$/;
		if(!campi_num[i].value.match(espressione_regolare)) {
			mostraErrore(document.getElementById("err_js"), 'Inserire solo numeri da 1 o 2 cifre');
			return false;
		}
	}

	return true;
}

function validazioneForm() {
	var elements = document.getElementsByClassName(className);
	for (var i=0; i<elements.length; i++) {
		elements[i].parentNode.removeChild(elements[i]);
	}

	return checkNominativo() && checkIsNumber();
}
