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

/* Show/Hide ALL elements with ClassName = debug_wrapper,
Enable/Disable form validation,
and set the cookies accordingly.*/
function toggle_debug(checkbox) {
	var forEach = Array.prototype.forEach; //Prepare to use forEach method with a NodeList
	var nodelist = document.getElementsByClassName("debug_wrapper");
	var form = document.getElementById("control_form") //or: checkbox.parentNode

	if (checkbox.checked) {
	//Debug mode ON
		forEach.call(nodelist, function(node) { //hide debug_wrapper(s)
			node.style.display = 'block'; 
		});
		form.setAttribute("novalidate", true); //disable form validation
		document.cookie = 'debug=1'; //set cookies
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