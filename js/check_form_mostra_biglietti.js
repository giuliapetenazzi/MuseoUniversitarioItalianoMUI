var className = "errori";

function mostraErrore(campo, messaggio) {
	var e = document.createElement("strong");
	e.className = className;
	e.appendChild(document.createTextNode(messaggio));
	campo.parentNode.appendChild(e);
}

function checkDate() {
	var ggi = document.getElementById('ggi').value;
	var mmi =document.getElementById('mmi').value;
	var aaaai = document.getElementById('aaaai').value;
	var ggf =document.getElementById('ggf').value;
	var mmf = document.getElementById('mmf').value;
	var aaaaf = document.getElementById('aaaaf').value;

	var data_inizio = new Date(aaaai, mmi, ggi);
	var data_fine   = new Date(aaaaf, mmf, ggf);

	if ( data_inizio.getTime() >= data_fine.getTime() ) {
		var campo = document.getElementById('err_js');
		mostraErrore(campo, "La data di fine ricerca deve essere uguale o successiva alla data di inizio");
		return false;
	} else {
		return true;
	}
}

function checkIsNumber() {
	var ggi = document.getElementById('ggi').value;
	var mmi =document.getElementById('mmi').value;
	var aaaai = document.getElementById('aaaai').value;
	var ggf =document.getElementById('ggf').value;
	var mmf = document.getElementById('mmf').value;
	var aaaaf = document.getElementById('aaaaf').value;

	if(!ggi.match(/^[0-3][0-9]$/) || !mmi.match(/^[0-1][0-9]$/) || !aaaai.match(/^[0-9][0-9][0-9][0-9]$/) ||
	   !ggf.match(/^[0-3][0-9]$/) || !mmf.match(/^[0-1][0-9]$/) || !aaaaf.match(/^[0-9][0-9][0-9][0-9]$/)) {
		mostraErrore(document.getElementById("err_js"), 'Inserire la data nel formato:  GG MM YYYY"');
		return false;
	}
	return true;
}

function validazioneForm() {
	// rimuove eventuali segnalazioni precedenti
	var elements = document.getElementsByClassName(className);
	for (var i=0; i<elements.length; i++) {
		elements[i].parentNode.removeChild(elements[i]);
	}

	return checkIsNumber() && checkDate();
}
