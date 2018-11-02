function addPlaceHolder(elID) {
    if(document.getElementById(elID)) {
        var el = document.getElementById(elID);
		console.log(el);
		var pH = el.getAttribute('myplaceholder');
		console.log(el.getAttribute('myplaceholder'));
        if(pH !== 'undefined' && el.value == '') {
            el.value = pH;
            el.className += 'placeheld';
        }
    }
}

function clearPlaceHolder(elID) {
    if(document.getElementById(elID)) {
        var el = document.getElementById(elID);
		console.log(el);
		var pH = el.getAttribute('myplaceholder');
        if(pH !== 'undefined' && el.value == pH) {
            el.value = '';
            el.className = el.className.replace('placeheld','');
        }
    }
}

var myElIDs = ['usr','pwd'];
console.log(myElIDs);
for(var i in myElIDs) {
    if(document.getElementById(myElIDs[i])) {
		console.log(document.getElementById(myElIDs[i]));
		addPlaceHolder(myElIDs[i]);
    }
}
