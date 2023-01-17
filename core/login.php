<?php

require "database.php";

function valid_string($params) {
    $valid_string = preg_match("/[^0-9a-zа-яёієї\s\-_]+/ui", $params);
    return $valid_string;
}

if(isset($_POST['user_login'])) {
    $user_login = $_POST['user_login'];
        if(valid_string($user_login) == 0){
            $query = "SELECT * FROM users WHERE `login`='$user_login'";
            $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
            if(empty($user)) {
                echo '<p class="form__error">Логіну не існує</p>';
                echo '<style> #login-error_login {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';  
            }
    } else {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #login-error_login {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
    }
}

if(isset($_POST['user_pass'])) {
    $user_pass = $_POST['user_pass'];
    $user_login = $_POST['user_login'];
    if(valid_string($user_login) == 0) {
    $query = "SELECT * FROM users WHERE `login`='$user_login'";
    $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
    if(!empty($user)) {
        $hash = $user['password'];
        if(password_verify($user_pass,$hash)){

        }  else {
            echo '<p class="form__error">Пароль не існує</p>';
            echo '<style> #pass-error_login {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
        }
    } 
} else {
    echo '<p class="form__error">Введено неправильний символ</p>';
    echo '<style> #pass-error_login {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
}
}

if(isset($_POST['login_submit'])) {
    $user_login = $_POST['user_login'];
    $user_pass = $_POST['user_pass'];
    if(isset($_POST['remember'])) {
        $checkbox = $_POST['remember']; 
    }

    if(valid_string($user_login) == 0){
        $query = "SELECT * FROM users WHERE `login`='$user_login'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(!empty($user)) {
            $hash = $user['password'];
            if(password_verify($user_pass,$hash)){
                session_start();
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $user['user_id'];

                if($checkbox == 1) {
                    $key = generateSalt();
                    setcookie('login', $user['login'], time() + 60*60*24*30, "/");
                    setcookie('key', $key, time() + 60*60*24*30, "/");

                    $query = 'UPDATE users SET cookie="'. $key .'" WHERE login="'. $user_login .'"';
                    executeQuery(openConnection(),$query);
                }
            }
        }  
    }
    header("Location:../index.php");
}

function generateSalt() {
    $salt = '';
    $saltLenght = 10;

    for($i = 0; $i < $saltLenght; $i++) {
        $salt .= chr(mt_rand(33,126));
    }
    return $salt;
}