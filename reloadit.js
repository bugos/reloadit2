window.onload = function() {
	update_debug();

	/* Event Handle Functions */

	var reset_button = document.getElementById("reset");
	reset_button.addEventListener("click", function() {
		//Empty the value of the "code" field.
		var form = document.getElementById('control_form');
		form.code.value=''; 
		form.submit();
	});

	var debug_checkbox = document.getElementById("debug_checkbox");
	debug_checkbox.addEventListener("click", function() {
		var state = debug_checkbox.checked;
		localStorage.debug = state;
		update_debug();
	});
}

/* updates the debug features of the document:
1. set the debug checkbox
2. enable/disable form validation
3. show/hide ALL .debug_wrapper elements. */
function update_debug() {
	if (localStorage.debug == undefined) {
		localStorage.debug = "false"; //default value
	}
	var cb = document.getElementById("debug_checkbox");
	var form = document.getElementById('control_form');
	var nodelist = document.getElementsByClassName('debug_wrapper');
	NodeList.prototype.forEach = Array.prototype.forEach; //we will be using the forEach method of Array
	if (localStorage.debug == "true") {
		form.setAttribute('novalidate', '');
		cb.setAttribute('checked', 'true');
		nodelist.forEach(function(node) {
			node.style.display = 'block';
		});
	}
	else {
		form.removeAttribute('novalidate');
		cb.removeAttribute('checked');
		nodelist.forEach(function(node) {
			node.style.display = 'none';
		});
	}
}

/*Not used. Inline prefered.
usage: onclick="submit_prizeid('<?=INDEX_FILE?>', <?=$prizeid?>);"*/
function submit_prizeid(action, prize_id) {
	document.location =  action + '?prizeid=' + prize_id ;
}