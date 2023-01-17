<?php
require "database.php";
session_start();

function valid_phone($params) {
    $valid_string = preg_match("/[^0-9\".+,:\s\-_]+/ui", $params);
    return $valid_string;
}

if(isset($_POST['company_phone'])) {
    $phone = $_POST['company_phone'];
    $phone = stristr($phone, '3');

    if(valid_phone($phone) == 0) {
        $query = "SELECT `phone` FROM users WHERE `phone`='$phone'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(!empty($user)) {
            echo '<p class="form__error">Номер вже зареєстровано</p>';
            echo '<style> #company_phone {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
        }
    } else {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #company_phone {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['user_phone'])) {
    $phone = $_POST['user_phone'];
    $phone = stristr($phone, '3');

    if(valid_phone($phone) == 0) {
        $query = "SELECT `phone` FROM users WHERE `phone`='$phone'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(!empty($user)) {
            echo '<p class="form__error">Номер вже зареєстровано</p>';
            echo '<style> #user_phone {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
        }
    } else {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #user_phone {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['user_submit'])) {
    $user_login = $_POST['user_login'];
    $user_pass = $_POST['user_pass'];
    $user_confirm = $_POST['user_confirm'];
    $user_name = $_POST['user_name'];
    $user_middle_name = $_POST['user_middle_name'];
    $user_surname = $_POST['user_surname'];
    $user_region = $_POST['region'];
    $user_city = $_POST['city'];
    $user_phone = $_POST['phone'];
    $user_image = $_POST['user_image'];
    $user_phone = stristr($user_phone, '3');
    $link = openConnection();

    if(empty($user_image)) {
        $user_image = 'no-image.jpg';
    }

    if(valid_string($user_login) == 0 && valid_string($user_pass) == 0 && valid_string($user_confirm) == 0
    && valid_string($user_name) == 0 && valid_string($user_middle_name) == 0 && valid_string($user_surname) == 0 && valid_phone($user_phone) == 0){
        $query = "SELECT `phone` FROM users WHERE `phone`='$user_phone'";
        $phone = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(empty($phone)) { 
        if($user_pass == $user_confirm) {
            $query = "SELECT * FROM users WHERE `login`='$user_login'";
            $user = mysqli_fetch_assoc(executeQuery(openConnection(), $query));
            if(empty($user)) {  
                $user_pass = password_hash($user_pass, PASSWORD_DEFAULT);
                $query = "INSERT INTO users (`login`, `password`, `user_name`, `middle_name`, `surname`, `id_region`, `id_city`, `phone`, `user_type`, `user_image`)
                VALUES ('$user_login', '$user_pass', '$user_name', '$user_middle_name', '$user_surname', '$user_region', '$user_city', '$user_phone', '0', '$user_image')";
    
                executeQuery($link, $query);  
                $_SESSION['auth'] = true;
                $id = mysqli_insert_id($link);
                $_SESSION['id'] = $id;
                header("Location:../index.php"); 
            } else {
                $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
                header("Location:../register-user.php"); 
            }
        } else {
            $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
            header("Location:../register-user.php"); 
        }
    } else {
        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        header("Location:../register-user.php"); 
    }
 } else {
    $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
    header("Location:../register-user.php"); 
 }
}

if(isset($_POST['company_submit'])) {
    $company_login = $_POST['company_login'];
    $company_pass = $_POST['company_pass'];
    $company_confirm = $_POST['company_confirm'];
    $company_name = $_POST['company_name'];
    $company_region = $_POST['company_region'];
    $company_city = $_POST['company_city'];
    $company_phone = $_POST['company_phone'];
    $user_image = $_POST['user_image'];
    $company_phone = stristr($company_phone, '3');
    $link = openConnection();

    if(empty($user_image)) {
        $user_image = 'no-image.jpg';
    }

    if(valid_string($company_login) == 0 && valid_string($company_pass) == 0 && valid_string($company_confirm) == 0
    && valid_string($company_name) == 0 && valid_phone($company_phone)){
        $query = "SELECT `phone` FROM users WHERE `phone`='$company_phone'";
        $phone = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(empty($phone)) {
        if($company_pass == $company_confirm) {
            $query = "SELECT * FROM users WHERE `login`='$company_login'";
            $user = mysqli_fetch_assoc(executeQuery(openConnection(), $query));
            if(empty($user)) {  
                $company_pass = password_hash($company_pass, PASSWORD_DEFAULT);
                $query = "INSERT INTO users (`login`, `password`, `user_name`, `id_region`, `id_city`, `phone`, `user_type`,`user_image`)
                VALUES ('$company_login', '$company_pass', '$company_name', '$company_region', '$company_city', '$company_phone', '1','$user_image')";
    
                executeQuery($link, $query);  
                $_SESSION['auth'] = true;
                $id = mysqli_insert_id($link);
                $_SESSION['id'] = $id; 
                header("Location:../index.php");           
            } else {
                $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
                header("Location:../register-user.php");
            }
        } else {
            $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
            header("Location:../register-user.php");
        }
    } else {
        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        header("Location:../register-user.php");
    }
    } else {
        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        header("Location:../register-user.php");
    }


}

function valid_string($params) {
    $valid_string = preg_match("/[^0-9a-zа-яёієї\"\s\-_]+/ui", $params);
    return $valid_string;
}

if(isset($_POST['user_login'])) {
    $user_login = $_POST['user_login'];
        if(valid_string($user_login) == 0){
            $query = "SELECT * FROM users WHERE `login`='$user_login'";
            $user = mysqli_fetch_assoc(executeQuery(openConnection(), $query));
            if(!empty($user)) {
                echo '<p class="form__error">Такий логін вже існує</p>';
                echo '<style> #user-login__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';                
            }
    } else {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #user-login__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';  
    }   
}

if(isset($_POST['user_pass'])) {
    $user_pass = $_POST['user_pass'];
        if(valid_string($user_pass) == 1){
            echo '<p class="form__error">Введено неправильний символ</p>';
            echo '<style> #user-pass__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
    }
}

if(isset($_POST['user_confirm'])) {
    $user_confirm = $_POST['user_confirm'];
        if(valid_string($user_confirm) == 1){
            echo '<p class="form__error">Введено неправильний символ</p>';
            echo '<style> #user-confirm__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
}
}

if(isset($_POST['user_pass']) && isset($_POST['user_confirm'])) {
    $user_pass = $_POST['user_pass'];
    $user_confirm = $_POST['user_confirm'];
    if($user_pass != $user_confirm) {
        echo '<p class="form__error">Пароль не співпадає</p>';
        echo '<style> #user-confirm__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['user_name'])) {
    $user_name = $_POST['user_name'];
        if(valid_string($user_name) == 1){
            echo '<p class="form__error">Введено неправильний символ</p>';
            echo '<style> #user-name__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
}
}

if(isset($_POST['user_surname'])) {
    $user_surname = $_POST['user_surname'];
        if(valid_string($user_surname) == 1){
            echo '<p class="form__error">Введено неправильний символ</p>';
            echo '<style> #user-surname__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
}
}

if(isset($_POST['user_middle_name'])) {
    $user_middle_name = $_POST['user_middle_name'];
        if(valid_string($user_middle_name) == 1){
            echo '<p class="form__error">Введено неправильний символ</p>';
            echo '<style> #user-middle_name__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
}
}

if(isset($_POST['company_login'])){
    $company_login = $_POST['company_login'];

    if(valid_string($company_login) == 1) {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #company-login__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['company_pass'])){
    $company_pass = $_POST['company_pass'];

    if(valid_string($company_pass) == 1) {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #company-pass__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['company_confirm'])){
    $company_confirm = $_POST['company_confirm'];

    if(valid_string($company_confirm) == 1) {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #company-confirm__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['company_name'])){
    $company_name = $_POST['company_name'];

    if(valid_string($company_name) == 1) {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #company-name__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['company_pass']) && isset($_POST['company_confirm'])) {
    $company_pass = $_POST['company_pass'];
    $company_confirm = $_POST['company_confirm'];
    if($company_pass != $company_confirm) {
        echo '<p class="form__error">Пароль не співпадає</p>';
        echo '<style> #company-confirm__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}