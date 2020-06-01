
<?php 

include 'secret.php';
$hologram_id = '-1001195370799';
$admin_id = '108488036';



function sendMessage($chatId, $msg, $tokenAPI){
    $request_params = [
        'chat_id' => $chatId,
        'text' => $msg
    ];    
    
    $request_url = 'https://api.telegram.org/bot'. $tokenAPI . '/sendMessage?' . http_build_query($request_params);

    file_get_contents($request_url);
}

$date = new DateTime("now", new DateTimeZone('Asia/Makassar') );
$waktu = $date->format('Y-m-d H:i:s');
?>