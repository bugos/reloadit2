/* Event Handle Functions */

/*Not used. Inline prefered.
usage: onclick="submit_prizeid('<?=INDEX_FILE?>', <?=$prizeid?>);"*/
function submit_prizeid(action, prize_id) {
	document.location =  action + '?prizeid=' + prize_id ;
}

/* Used for Logout. Empties the code field in main form and submits it.*/
function reset_code(self) {
	self.parentNode.code.value=''; 
	self.parentNode.submit();
}

/* Handles the changes of the debug_checkbox.
show/hide ALL elements with ClassName = debug_wrapper,
enable/disable form validation,
and set the cookies accordingly.*/
function toggle_debug() {
	var forEach = Array.prototype.forEach; //we will use the forEach method of arrays on a NodeList
	var checkbox = document.getElementById("debug_checkbox");
	var nodelist = document.getElementsByClassName("debug_wrapper");
	var form = document.getElementById("control_form") //or: checkbox.parentNode
	if (checkbox.checked) {
	//Debug mode ON
		forEach.call(nodelist, function(node) {
			node.style.display = 'block'; 
		});
		form.setAttribute("novalidate", true);
		document.cookie = 'debug=1';
	}
	else {
	//Debug mode OFF
		forEach.call(nodelist, function(node) {
			node.style.display = 'none'; 
		});
		form.removeAttribute("novalidate");
		document.cookie = 'debug=0';
	}
}