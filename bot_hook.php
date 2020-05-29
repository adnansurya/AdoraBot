<?php

include 'db_access.php';
include 'global.php';


// $chat_id = $adnan_id;

$getter = file_get_contents("php://input");

$update = json_decode($getter, TRUE);

$chat_id = $update["message"]["chat"]["id"];

$message = $update["message"]["text"];
$username = $update["message"]["from"]["username"];
$user_id = $update["message"]["from"]["id"];
$first_name = $update["message"]["from"]["first_name"];
$last_name = $update["message"]["from"]["last_name"];

$timestamp = date_timestamp_get($date);

$pesan = "Pesan yang anda kirim adalah : ". $message;


sendMessage($chat_id, $pesan, $token);

?>