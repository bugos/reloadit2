<header> 
    <img id="logo" src="FILES/logo.png" alt="Logo" />
    <nav> 
        <form id="control_form" method="POST" action="<?=INDEX_FILE?>">
            <span class="yellow-on-black">Κινητο:</span>
            <input type="text" name="phone" value="<?=$phone?>" <?=($phone == '')?'autofocus':''?>
                pattern="(69\d{8})" required
                title="Δεκαψήφιος αριθμός κινητού που ξεκινάει με 69." />
            
            <span class="yellow-on-black">Κωδικος:</span>
            <input type="text" name="code"  value="<?=$code?>"  <?=($phone == '')?'':'autofocus'?>
                pattern="(\w{5})"  required  
                title="Ο κωδικός ReloadIt αποτελείται από 5 αλφαρηθμητικούς χαρακτήρες." />
                
            <input type="submit" value="Go!" />

            <input id="reset" type="button" value="Reset" />
            
            <label for="debug_checkbox">
                <input id="debug_checkbox" type="checkbox"/>
            Debug<sup>LIVE</sup></label>
        </form>
    </nav>
</header>