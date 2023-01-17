<?php

require "database.php";
session_start();

if(isset($_POST['cargo_name'])) {
    $cargo_name = $_POST['cargo_name'];
    if(valid_string($cargo_name) == 1){
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #cargo_name__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
}
}

if(isset($_POST['cargo_descript'])) {
    $cargo_descript = $_POST['cargo_descript'];
    if(valid_string($cargo_descript) == 1){
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #cargo_descript__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
}
}

function valid_string($params) {
    $valid_string = preg_match("/[^0-9a-zа-яёієї\".,:\s\-_]+/ui", $params);
    return $valid_string;
}

if(isset($_POST['cargo_submit'])) {
    $cargo_name = $_POST['cargo_name'];
    $cargo_descript = $_POST['cargo_descript'];
    $load_region = $_POST['load_region']; 
    $load_city = $_POST['load_city'];
    $load_date = $_POST['load_date'];
    $unload_region = $_POST['unload_region'];
    $unload_city = $_POST['unload_city'];
    $cargo_weight = $_POST['cargo_weight'];
    $body_type = $_POST['body_type'];
    $distance = $_POST['distance'];
    $unload_date = $_POST['unload_date'];
    $cargo_price = $_POST['cargo_price'];
    $cargo_urgent = $_POST['cargo_urgent'];
    $id_user = $_SESSION['id'];

    if(empty($cargo_urgent)) {
        $cargo_urgent = 0;
    }

    if(valid_string($cargo_name) == 0 && valid_string($cargo_descript) == 0){
        $query = "INSERT INTO `cargos` (`cargo_name`, `loading_region`, `loading_city`, `loading_date`, `weight`, `distance`, `body_type`, `unloading_region`, `unloading_city`, `unloading_date`, `price`, `id_user`, `description_cargo`, `urgent`) 
        VALUES ('$cargo_name', '$load_region', '$load_city', '$load_date', '$cargo_weight', '$distance', '$body_type', '$unload_region', '$unload_city', '$unload_date', '$cargo_price', '$id_user', '$cargo_descript', '$cargo_urgent')";

        executeQuery(openConnection(),$query);

        $_SESSION['success-add-cargo'] = '<p class="cargo__success">Вантаж успішно додано</p>';
        header("Location:../cargo-add.php");  
    } else {
        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        header("Location:../cargo-add.php"); 
    }
}
