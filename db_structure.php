<?php
    include 'db_access.php';

    echo "\n".'AdoraBot_user'."\n";
    $res = mysqli_query($conn, 'DESCRIBE AdoraBot_user');
    while($row = mysqli_fetch_array($res)) {
        echo "{$row['Field']} - {$row['Type']}"."\n";
    }

    echo "\n".'AdoraBot_device'."\n";
    $res = mysqli_query($conn, 'DESCRIBE AdoraBot_device');
    while($row = mysqli_fetch_array($res)) {
        echo "{$row['Field']} - {$row['Type']}"."\n";
    }

    echo "\n".'AdoraBot_register'."\n";
    $res = mysqli_query($conn, 'DESCRIBE AdoraBot_register');
    while($row = mysqli_fetch_array($res)) {
        echo "{$row['Field']} - {$row['Type']}"."\n";
    }

    echo "\n".'AdoraBot_report'."\n";
    $res = mysqli_query($conn, 'DESCRIBE AdoraBot_report');
    while($row = mysqli_fetch_array($res)) {
        echo "{$row['Field']} - {$row['Type']}"."\n";
    }

    echo "\n".'AdoraBot_message'."\n";
    $res = mysqli_query($conn, 'DESCRIBE AdoraBot_message');
    while($row = mysqli_fetch_array($res)) {
        echo "{$row['Field']} - {$row['Type']}"."\n";
    }

?>