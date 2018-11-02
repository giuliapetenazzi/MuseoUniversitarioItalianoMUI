var className = "errori";

function mostraErrore(campo, messaggio) {
	var e = document.createElement("strong");
	e.className = className;
	e.appendChild(document.createTextNode(messaggio));
	campo.parentNode.appendChild(e);
}
function checkUsername() {
	var campo = document.getElementById('usr');
	var espressione_regolare = /^[0-9a-zA-Z\-\_]{3,20}$/;
	if(campo.value.match(espressione_regolare)) {
		return true;
	} else {
		mostraErrore(document.getElementById("err_js"), "L'username deve contenere da 3 a 20 caratteri alfanumerici o '-' e '_'");
		return false;
	}
}
function checkPassword() {
	var campo = document.getElementById('pwd');
	var espressione_regolare = /.{5,}/;
	if(campo.value.match(espressione_regolare)) {
		return true;
	} else {
		mostraErrore(document.getElementById("err_js"), "La password deve avere almeno 5 caratteri");
		return false;
	}
}
function validazioneForm() {
	// elimina eventuali precedenti segnalazioni
	var elements = document.getElementsByClassName(className);
	for (var i=0; i<elements.length; i++) {
		elements[i].parentNode.removeChild(elements[i]);
	}

	return checkUsername() && checkPassword();
}
