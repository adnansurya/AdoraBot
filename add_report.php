<?php
  
include 'db_access.php';

$waktu_local = $_POST['waktu'];
$gambar = $_POST['gambar'];


$date = new DateTime("now", new DateTimeZone('Asia/Makassar') );
$waktu = $date->format('Y-m-d H:i:s');

$namapic='../gambar/'.$waktu.'.jpg';
file_put_contents($namapic, base64_decode($gambar));

$namapic = $waktu.'.jpg';

$sql = "INSERT INTO iot_farm_monitor(suhu_udara,lembab_udara,lembab_tanah,ph_tanah,gambar,waktu) VALUES ('$suhu_udara','$lembab_udara','$lembab_tanah','$ph_tanah','$namapic','$waktu')";

if (mysqli_query($conn,$sql)){    
    // include 'kontrol.php';
}
else{
    echo "Terjadi Kesalahan.<br>";
    echo $waktu;  
}
?>