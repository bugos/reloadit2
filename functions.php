<?php
function handle_post_data() {
	if (isset($_POST['phone']) && isset($_POST['code'])) { 
	//Form submitted. Set the cookies and reload.
		setcookie('phone', $_POST['phone'], time()+ 0.5 * 3600);
		setcookie('code',  $_POST['code'],  time()+ 0.5 * 3600);
		header("Location: {$_SERVER['PHP_SELF']}");
	}
}
/*Returns an html-valid color that refers to the prize type.*/
function get_type(array $d) {
	switch($d['type']) {
		case 's': return 'Silver';
		case 'g': return 'Gold'  ;
		case 'trick': return 'Snow';
	}
}
/*Used to show Error Messages and more.*/
function show_message($title, $subtitle, $description, $smalltext = '') {
	echo "
	<h1>$title<span class=\"small_text\">$smalltext</span></h1>
	<h2>$subtitle</h2>
	<p>$description</p>	
	";
}
/*Makes sure a variable has a value.
Used with POST, GET data, cookies and more.*/
function isset_shield(&$var, $alt='') {
	return isset($var)? $var:$alt;
}
/*Compares $result with $success_val. When not equal, handles the error.*/
function parse_response(array $arg) {
    $arg = array_merge(array( //defaults
        "result"      => '', 
        "success_val" => '', 
        "err_title"   => '', 
        "err_sub"     => '', 
        "err_desc"    => '', 
        "err_small"   => ''
    ), $arg);
    extract($arg);
	if ($result == $success_val) { 
		//Success. Return.
		return true;  
	}
	else { 
		//Handle error.
		show_message($err_title, $err_sub, $err_desc, $err_small);
	}
}
/* Gets Json data from $url and decodes it. 
Optionally writes logs and debug output. */
function get_data($url, $logging = true) {
	$json = file_get_contents($url);
	$data = json_decode($json, true);
	if ($logging) {
		write_logs($json);
		print_debug_output($url, $json);
	}
	return $data;
}
/* TODO: Rethink*/
function write_logs($json) { //todo: rethink
	$log = strftime('%c'). "\t" . $json . "\r\n\r\n";
	file_put_contents(LOG_FILE, $log, FILE_APPEND);
}
/* Documentation: todo 
Smart trick ;)
*/
function perform_trick() {
	$trick_url = TRICK_FILE;
	$trick_data = get_data($trick_url, false);
	print_prize_table($trick_data);
}

/*=== Functions that print HTML code. ===*/

/* */
function print_debug_output($url, $json) { 
	global $debug;
	?> <!--Start debug_wrapper --> 
	<div class="debug_wrapper" style="<?=$debug?'':'display:none;'/*Hide when debug is off*/?>"> 
		<ul> 
			<li> <b>Url:</b> <span><?=$url?></span> </li>
			<li> <b>Json:</b> <br> 
				<textarea disabled> <?=$json?> 
			</textarea> </li>
		</ul> 
	</div> <!--End debug_wrapper --> <?
}
/* */
function print_prize_table(array $d) { 
	?> <h2> Choose a <span style="color:<?=get_type($d)?>"><?=get_type($d)?></span> prize: </h2>
	<!-- Start data table --> 
	<table> <?
		foreach ( $d['extra']['chooseyourself'] as $prize)
		{
			$image 		 = $prize['bigimagepath'];
			$title 		 = $prize['title'];
			$description = $prize['description'];
			$prizeid 	 = $prize['prizeid'];
			?> 
			<tr >
				<td id="td_title" class="table_link" onclick="document.location = '<?=INDEX_FILE?>?prizeid=<?=$prizeid?>'" >
					<h2><img width="30%" src="<?=$image?>"/><?=$title?></h2> </td>
				<td> <?=$description?> 
					<b>PrizeId: <input value="<?=$prizeid?>" size="5" disabled></b> </td>
			</tr> 
			<?
		}
	?> </table> <!-- End data table --> <?
}
/* */
function print_custom_prizeid() {
	?> <!-- Start custom_prizeid_form -->
	<form method="GET" action="<?=INDEX_FILE?>">
		Or enter a custom PrizeID:  
		<?='.'.INDEX_FILE?>?prizeid=
		<input type="text" name="prizeid"/>
		<input type="submit"/>
	</form> <!-- End custom_prizeid_form --> <?
}

?>
