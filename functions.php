<?php
function handle_post_data() {
    if (isset($_POST['phone']) && isset($_POST['code'])) { 
    //Form submitted. Set the cookies and reload.
        setcookie('phone', $_POST['phone']); 
        setcookie('code',  $_POST['code'],  time()+ 60*60*0.5); //half an hour
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
    echo '<article>';
    print_prize_table($trick_data);
    echo '</article>';

}

/*=== Functions that print HTML code. ===*/

/* */
function print_debug_output($url, $json) { 
    ?>
    <section class="debug_wrapper"> 
        <ul> 
            <li> <b>Url:</b> <span><?=$url?></span> </li>
            <li> <b>Json:</b> <br> 
                <textarea disabled> <?=$json?> 
            </textarea> </li>
        </ul> 
    </section> 
    <?
}
/* */
function print_prize_table(array $d) { 

    $type = get_type($d); 
    ?>
    <section> 
    <h3><span class="yellow-on-black"> Choose a 
    <span style="background-color:<?=$type?>;"><?=$type?></span>
    prize:
    </span></h3>
    <table> <?
        foreach ( $d['extra']['chooseyourself'] as $prize)
        {
            $image       = $prize['bigimagepath'];
            $title       = $prize['title'];
            $description = $prize['description'];
            $prizeid     = $prize['prizeid'];
            ?> 
            <tr>
                <td class="table_link" onclick="document.location = '<?=INDEX_FILE?>?prizeid=<?=$prizeid?>'" >
                    <h2><img width="30%" src="<?=$image?>"/><?=$title?></h2> </td>
                <td> <?=$description?> 
                    <b>PrizeId: <input value="<?=$prizeid?>" size="5" disabled></b> </td>
            </tr> 
            <?
        }?>
    </table>  
    </section> 
    <?
}
/* */
function print_custom_prizeid() {
    ?><section>
    <form method="GET" action="<?=INDEX_FILE?>">
        <span class="yellow-on-black">Or enter a custom PrizeID:  
        <?='.'.INDEX_FILE?>?prizeid=</span><!-- no space
        --><input type="text" name="prizeid"/>
        <input type="submit" value="Submit Query"/>
    </form>
    </section><?
}

?>
