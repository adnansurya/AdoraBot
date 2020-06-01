<?php

include 'db_access.php';
include 'global.php';


$getter = file_get_contents("php://input");

$update = json_decode($getter, TRUE);

$chat_id = $update["message"]["chat"]["id"];

$message = $update["message"]["text"];
$username = $update["message"]["from"]["username"];
$user_id = $update["message"]["from"]["id"];
$first_name = $update["message"]["from"]["first_name"];
$last_name = $update["message"]["from"]["last_name"];

$timestamp = date_timestamp_get($date);

$save_msg = "INSERT INTO AdoraBot_message(acc_id,message,time) VALUES ('$user_id','$message','$waktu')";

if($user_id != $admin_id){
    $admin_msg = "ADMIN_LOG : " .PHP_EOL. "From : " .$user_id. " (@".$username.")". PHP_EOL .$first_name. " " .$last_name. PHP_EOL .$message;   
    sendMessage($admin_id,$admin_msg, $token);
}



if (!mysqli_query($conn,$save_msg)){            
    $pesan = 'Bete akunya, gak bisa nyimpan histori obrolan kita -_-';
    sendMessage($chat_id, $pesan, $token);
            
} 

function getComm($msg, $commString){
        
    $pos = strpos($msg, $commString);
    echo $pos;
    if($pos !== false){
        if($pos === 0){
            return true;
        }else{
            return FALSE;
        }
    }else{
        return $pos;
    }      
      
}


$pesan = "";



if($chat_id !== $user_id){        
    $pesan = 'Aku tuh lebih suka kalo kita ngobrol cuma berdua, kak '.$first_name.' ;)';                    
}else{
    //USER DATA INPUT
    $check_user = mysqli_query($conn,"SELECT * FROM AdoraBot_user WHERE acc_id='".$user_id."'");
    if (mysqli_num_rows($check_user) < 1) {
        $sql = "INSERT INTO AdoraBot_user(acc_id,acc_username,acc_firstname,acc_lastname) VALUES ('$user_id','$username','$first_name','$last_name')";
        if (!mysqli_query($conn,$sql)){            
            $pesan = 'Aku pusing, data usernya kok gak bisa masuk ya? :(';
            sendMessage($chat_id, $pesan, $token);
                    
        }
    }

    //READ COMMAND
    if(getComm($message, '/create')){                  
        $subcomm = substr($message, 8);
        $pos = strpos($subcomm, " ");
        
        if ($pos === false) {
            $pesan = "Gunakan spasi untuk memisahkan nama perangkat dan password, oke? :3";
        }else{
            $dev_data = explode(" ", $subcomm);
            $dev_name = $dev_data[0];
            $dev_pass = $dev_data[1];
            $dev_token = "AO-".uniqid();

            $sql = "INSERT INTO AdoraBot_device(dev_token,dev_name,password) VALUES ('$dev_token','$dev_name','$dev_pass')";
            if (!mysqli_query($conn,$sql)){            
                $pesan = 'Maaf kak, input data perangkatnya lagi error. -_-';
                
                        
            }else{
                $last_id = mysqli_insert_id($conn);
                $sql = "INSERT INTO AdoraBot_register(acc_id,id_dev,roles,time) VALUES ('$user_id','$last_id','OWNER','$waktu')";
                if (!mysqli_query($conn,$sql)){            
                    $pesan = 'Ada yang salah dengan proses registrasinya, sabar dulu ya :\'(';                                                
                }else{
                    $pesan = 'Hore! pendaftaran perangkatnya sudah berhasil :D';
                }
            }
        
        } 
        
    }elseif(getComm($message, '/subscribe')){  
        $subcomm = substr($message, 11);
        $pos = strpos($subcomm, " ");
        
        if ($pos === false) {
            $pesan = "Gunakan spasi untuk memisahkan nama perangkat dan password, oke? :3";
        }else{
            $dev_data = explode(" ", $subcomm);
            $dev_token = $dev_data[0];
            $dev_pass = $dev_data[1];

            $check_dev = mysqli_query($conn,"SELECT * FROM AdoraBot_device WHERE dev_token='".$dev_token."' AND password='".$dev_pass."'");
            if($check_dev && mysqli_num_rows($check_dev)==1){
                while($row = mysqli_fetch_assoc($check_dev)) {
                    $id_dev = $row['id_dev'];
                    $sql = "INSERT INTO AdoraBot_register(acc_id,id_dev,roles,time) VALUES ('$user_id','$id_dev','SUBSCRIBER','$waktu')";
                    if (!mysqli_query($conn,$sql)){            
                        $pesan = 'Perangkatnya gak bisa disubscribe, gimana kalo subscribe youtube aku aja? :v';                                                
                    }else{
                        $pesan = 'Hore! subscribe ke perangkat '.$row['dev_name'].' sudah berhasil :D';
                    }
                }
            }else{
                $pesan = 'Perangkat kakak yang mana ya? x_x';
            }                       
        
        } 

    }elseif(getComm($message, '/unsubs')){  
        $dev_token = substr($message, 8);

        $unsubs_dev = mysqli_query($conn,"DELETE FROM AdoraBot_register WHERE dev_token='".$dev_token."' AND acc_id='".$user_id."' AND roles='SUBSCRIBER'"); 
        if($unsubs_dev){
            $pesan = 'Perangkatnya sudah aku putusin ya. XD';
        }else{
            $pesan = 'Kok perangkatnya gak mau putus ya? :/';
        }

    }elseif(getComm($message, '/delete')){  
        $dev_token = substr($message, 8);

        $delete_dev = mysqli_query($conn,"DELETE FROM AdoraBot_register WHERE dev_token='".$dev_token."' AND acc_id='".$user_id."' AND roles='OWNER'"); 
        if($delete_dev){
            $remove_all = mysqli_query($conn,"DELETE FROM AdoraBot_register WHERE dev_token='".$dev_token."'");
            if($remove_all){
                $pesan = "Sayang banget, perangkatnya udah berhasil dihapus :\'(";
            }else{
                $pesan = "Sepertinya ada masalah, perangkatnya gak bisa dihapus -_-";
            }
        }else{
            $pesan = 'Kok perangkatnya gak bisa dihapus ya? :/';
        }

    }elseif(getComm($message, '/admin')){  
        $subcomm = substr($message, 7);
        if($user_id != $admin_id){
            $pesan = 'Maaf kak, command itu hanya untuk admin :)';
        }else{
            $msg_data = explode("#", $subcomm);
            $send_id = $msg_data[0];
            $admin_msg = $msg_data[1];
            $pesan = "ADMIN : ". $admin_msg;
            sendMessage($send_id, $pesan, $token);
            
        }        
    }else{

        $pesan = "Aku tak tahu perintah itu, bisa coba yang lain? :/";
    }

}


if($user_id != $admin_id){
    sendMessage($chat_id, $pesan, $token);
}


?>