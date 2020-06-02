<?php
    include 'db_access.php';


    $table_name = $_GET['table'];


    $result = mysqli_query($conn, "SELECT * from ".$table_name);
    $rows = array();
    while($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    $myarray = json_encode($rows); 

    print json_encode(array('hasil' => $rows));

?>