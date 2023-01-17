<?php
require "database.php";
session_start();

if(isset($_POST['user_upgrade_submit'])) {
    $region = $_POST['region'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $image = $_POST['user_image'];
    $user_type = $_POST['user_type'];
    $user_id = $_SESSION['id'];
    $phone = stristr($phone, '3');

    $query = "SELECT user_image FROM users WHERE user_id='$user_id'";
    $user_image = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

    if($user_type == 1) {
        $name_company = $_POST['name_company'];
        if(valid_string($name_company) == 0){
        $query = "SELECT `phone` FROM users WHERE `phone`='$phone'";
        $db_phone = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(empty($db_phone)) { 
        $query = "UPDATE `users` SET `user_name` = '$name_company', `id_region` = '$region', `id_city` = '$city', `phone` = '$phone' WHERE `users`.`user_id` = $user_id";
        executeQuery(openConnection(),$query);    
        if(!empty($image)) {
            $query = "UPDATE `users` SET `user_image` = '$image' WHERE `users`.`user_id` = $user_id";
            executeQuery(openConnection(),$query);
         } 
        } else {
            $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        }
         $_SESSION['success-upgrade-user'] = '<p class="cargo__success">Профіль успішно редаговано</p>';
        } else {
            $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        }

        header("Location:../profile-setting.php");  

    } else {
        $name_user = $_POST['name_user'];
        $middle_name = $_POST['middle_name'];
        $surname = $_POST['surname'];

        if(valid_string($name_user) == 0 and valid_string($middle_name) == 0 and valid_string($surname) == 0){
        // $query = "SELECT `phone` FROM users WHERE `phone`='$phone'";
        // $db_phone = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        // if(empty($db_phone)){
        $query = "UPDATE `users` SET `user_name` = '$name_user', `middle_name` = '$middle_name', `surname` = '$surname', `id_region` = '$region', `id_city` = '$city', `phone` = '$phone' WHERE `users`.`user_id` = $user_id";
        executeQuery(openConnection(),$query);    
        if(!empty($image)) {
            $query = "UPDATE `users` SET `user_image` = '$image' WHERE `users`.`user_id` = $user_id";
            executeQuery(openConnection(),$query);
         } 
         $_SESSION['success-upgrade-user'] = '<p class="cargo__success">Профіль успішно редаговано</p>';
        // } else {
        //     $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        // }
        } else {
            $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
            header("Location:../profile.php");
        }
        header("Location:../profile-setting.php"); 
    }
}

function valid_string($params) {
    $valid_string = preg_match("/[^0-9a-zа-яёієї\"\s\-_]+/ui", $params);
    return $valid_string;
}

function valid_phone($params) {
    $valid_string = preg_match("/[^0-9\".+,:\s\-_]+/ui", $params);
    return $valid_string;
}

if(isset($_POST['user_phone'])) {
    $phone = $_POST['user_phone'];
    $phone = stristr($phone, '3');

    if(valid_phone($phone) == 0) {
        $query = "SELECT `phone` FROM users WHERE `phone`='$phone'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(!empty($user)) {
            echo '<p class="form__error">Номер вже зареєстровано</p>';
            echo '<style> #phone {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
        }
    } else {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #phone {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['name_company'])){
    $company_name = $_POST['name_company'];

    if(valid_string($company_name) == 1) {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #name_company {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['name_user'])){
    $name_user = $_POST['name_user'];

    if(valid_string($name_user) == 1) {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #name_user {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['middle_name'])){
    $middle_name = $_POST['middle_name'];

    if(valid_string($middle_name) == 1) {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #middle_name {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['surname'])){
    $surname = $_POST['surname'];

    if(valid_string($surname) == 1) {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #surname {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}