<?php
// Password host: $Nx0B~Kp&>e]})iV
// Name user: id19796517_nikolos52
function openConnection() {
    $host = 'localhost';
    $user = 'id19796517_nikolos52';
    $password = '$Nx0B~Kp&>e]})iV';
    $db_name = 'id19796517_http';
    // $host = 'localhost';
    // $user = 'root';
    // $password = '';
    // $db_name = 'http';
    $link = mysqli_connect($host, $user, $password, $db_name);
    mysqli_query($link, "SET NAMES 'utf8'");

    // if(mysqli_connect_errno()) {
    //     echo "false";
    // } else {
    //     echo "true";
    // }
    return $link;
}

function executeQuery($conn, $query) {
    return mysqli_query($conn, $query);
}

function closeConnection($conn) {
    mysqli_close($conn);
}
