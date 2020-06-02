<?php
  
include 'db_access.php';
include 'global.php';



if(isset($_POST['dev_token']) && isset($_POST['dev_pass']) && isset($_POST['waktu']) && isset($_POST['gambar'])){
    $dev_token = $_POST['dev_token'];
    $dev_pass = $_POST['dev_pass'];
    $waktu_local = $_POST['waktu'];
    $gambar = $_POST['gambar'];

    $check_dev = mysqli_query($conn,"SELECT * FROM AdoraBot_device WHERE dev_token='".$dev_token."' AND password='".$dev_pass."'");
    if($check_dev && mysqli_num_rows($check_dev)==1){
        while($row = mysqli_fetch_assoc($check_dev)) {
            $id_dev = $row['id_dev'];
            $dev_name = $row['dev_name'];


      
            $timestamp = date_timestamp_get($date);
            $namapic = $dev_token.'-'.$timestamp.'.jpg';
            
            $filepic='gambar/'.$namapic;
            file_put_contents($filepic, base64_decode($gambar));
            
        
            
            $sql = "INSERT INTO AdoraBot_report(id_dev,img,time) VALUES ('$id_dev','$namapic','$waktu_local')";
            
            if (mysqli_query($conn,$sql)){    
                $check_register = mysqli_query($conn,"SELECT * FROM AdoraBot_register WHERE id_dev='".$id_dev."'");
                while($row = mysqli_fetch_assoc($check_register)) {
                    $send_id = $row['acc_id'];
                    $pesan = "Ada gerakan di ".$dev_name. " :".PHP_EOL."Waktu : ".$waktu_local;
                    sendMessage($send_id, $pesan, $token);
                   

                    $bot_url    = "https://api.telegram.org/bot".$token."/";
                    $url        = $bot_url . "sendPhoto?chat_id=" . $send_id ;
                    
                    $post_fields = array('chat_id'   => $send_id,
                        'photo'     => new CURLFile(realpath($filepic))
                    );
                    
                    $ch = curl_init(); 
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        "Content-Type:multipart/form-data"
                    ));
                    curl_setopt($ch, CURLOPT_URL, $url); 
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
                    $output = curl_exec($ch);                    
                    echo $output;
            
                }
            }
            else{
                echo "Error Penulisan Report";
                echo $waktu;  
            }
           
        }
    }else{
        echo 'Perangkat tidak ditemukan';
    }    
    
    
   
}else{
    echo 'Request Error';
}


?>