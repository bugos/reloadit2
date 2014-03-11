<!--
    Cosmote WhatsUp Reloadit Private Api Showcase Script
    Developer: Evangelos "bugos" Mamalakis <mamalakis@auth.gr>

    Short Tags: This script uses php short tags. Set short_open_tag=enabled in php.ini
-->
<?
require_once 'functions.php';
require_once 'constants.php';
handle_post_data(); // Handle submitted POST data if there is any.
?>

<!DOCTYPE html> <!-- Render in standards mode -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> ReloadIt Private API Showcase </title>
    <link rel="icon" type="image/x-icon" href="FILES/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="reloadit.css" />
    <script type="text/javascript" src="reloadit.js"></script>
</head>

<body>
    <? require 'header.php'; ?> 
    <main>
        <?
        if ($phone != '' && $code != '' && $prizeid == '') { 
        //Prize selection screen
            $url = API . "?method=runLottery&msisdn=$phone&code=$code";
            /*===DEBUG===*/ if ($code == 'test1') $url = 'FILES/fake.php';
            $data = get_data($url);

            //Parse response 
            if (parse_response(array(
                "result"      => $data['result'] , 
                "success_val" => 'v' , 
                "err_title"   => 'Server Error' , 
                "err_sub"     => 'Code ' . isset_shield($data['error_code'], 'unknown') , 
                "err_desc"    => isset_shield($data['error_string']) , 
                "err_small"   => "(Result {$data['result']} != v)" 
                ))) { 
            //Success
                print_prize_table($data);
                print_custom_prizeid();

                perform_trick();
            }
        }
        elseif ($phone != '' && $code != '' && $prizeid != '') {
        //Submission Results screen

            //Prize Code Submission
            $rld_url = API . "?method=secondProvisioning&msisdn=$phone&code=$code&prizeid=$prizeid";
            $rld_data = get_data($rld_url);

            //Parse response 
            if (parse_response(array(
                "result"      => $rld_data['response'] , 
                "success_val" => 1 , 
                "err_title"   => 'Prize Code Submisson:' ,
                "err_sub"     => 'Failure: An error occured.' , 
                "err_desc"    => '<a href="' . INDEX_FILE . '">Go back</a>' , 
                ))) { 
                //Success
                show_message('Prize Code Submisson:', 'Prize Selection Successful', '');
            

                //Contest Submission (if code submission was accepted)
                $opt_url = API . "?method=optin&msisdn=$phone&code=$code"; 
                $opt_data = get_data($opt_url);
                
                //Parse response
                if (parse_response(array(
                    "result"      => $opt_data['response'] , 
                    "success_val" => 1 , 
                    "err_title"   => 'Contest Submisson:' ,
                    "err_sub"     => 'Failure' , 
                    ))) { 
                    //Success
                    show_message('Contest Submission:', 'Contest Submission Successful', '');
                }
            } 
        }
        else {
        //First visit. Homepage.
            show_message('What\'s Up Reload It Private Api Showcase.', 'whatsup.gr/reloadit/', 'Use code test for testing.');
        }
        ?>
    </main>
    <footer> 
        Made in Thessaloniki. <small>Originaly developed in Agia Galini.</small>
    </footer>
</body>
</html>
