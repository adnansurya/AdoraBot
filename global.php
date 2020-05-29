
<?php 

$token = '1115765927:AAFgDI003Xn41tererJRuoU543tBsg8CBpE';
$hologram_id = '-1001195370799';
$adnan_id = '108488036';



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