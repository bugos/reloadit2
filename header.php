<!--Start header_wrapper -->
<div id="header_wrapper"> 
	<!--Logo-->
	<img id="logo" src="FILES/logo.png" alt="Logo" />
	<!-- Start Control Panel --> 
	<div id="control_panel"> 
		<form id="control_form" method="POST" action="<?=INDEX_FILE?>" <?=$debug?'novalidate':''?> >
			<span class="yellow-on-black">Κινητο:</span>
			<input type="text" name="phone" value="<?=$phone?>" <?=($phone == '')?'autofocus':''?>
				pattern="(69\d{8})" required
				title="Δεκαψήφιος αριθμός κινητού που ξεκινάει με 69." />
			
			<span class="yellow-on-black">Κωδικος:</span>
			<input type="text" name="code"  value="<?=$code?>"  <?=($phone == '')?'':'autofocus'?>
				pattern="(\w{5})"  required  
				title="Ο κωδικός ReloadIt αποτελείται από 5 αλφαρηθμητικούς χαρακτήρες." />
				
			<input type="submit" value="Go!" />
			<input type="button" value="Reset" onclick="reset_code(this)" />
			
			<label for="debug_checkbox">
				<input id="debug_checkbox" type="checkbox" onchange="toggle_debug()" <?=$debug?'checked':''?> />
			Debug<sup>LIVE</sup></label>
		</form>
	</div> <!-- End Control Panel -->
</div> <!--End header_wrapper -->
