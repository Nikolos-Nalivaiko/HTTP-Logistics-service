<?php
require "database.php";
session_start();

function valid_string($params) {
    $valid_string = preg_match("/[^0-9a-zа-яёієї\"\s\-_]+/ui", $params);
    return $valid_string;
}

if(isset($_POST['login_check'])) {
    $login = $_POST['login_check'];
    if(valid_string($login) == 0) {
        $query = "SELECT * FROM users WHERE `login`='$login'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(empty($user)) {
            echo '<p class="form__error">Логіну не існує</p>';
            echo '<style> #login_pass {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';  
        }
    } else {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #login_pass {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
    }
}

if(isset($_POST['pass_check'])) {
    $user_pass = $_POST['pass_check'];
    $user_login = $_POST['login_check'];
    if(valid_string($user_login) == 0) {
    $query = "SELECT * FROM users WHERE `login`='$user_login'";
    $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
    if(!empty($user)) {
        $hash = $user['password'];
        if(password_verify($user_pass,$hash)){

        }  else {
            echo '<p class="form__error">Пароль не існує</p>';
            echo '<style> #old_pass {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
        }
    } 
    } else {
    echo '<p class="form__error">Введено неправильний символ</p>';
    echo '<style> #old_pass {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
    }
}

if(isset($_POST['new_pass'])) {
    $new_pass = $_POST['new_pass'];
    if(valid_string($new_pass) == 1) {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #new_pass {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
    }
}

if(isset($_POST['confirm_pass'])) {
    $confirm_pass = $_POST['confirm_pass'];
    $new_pass = $_POST['new_pass'];
    if(valid_string($confirm_pass) == 0) {
        if($confirm_pass != $new_pass){
            echo '<p class="form__error">Логін не співпадає</p>';
            echo '<style> #confirm_pass {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
        }        
    } else {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #confirm_pass {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
    }
}

if(isset($_POST['pass_change'])) {
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];
    $user_id = $_SESSION['id'];

    if(valid_string($login) == 0 and valid_string($new_pass) == 0 and valid_string($confirm_pass) == 0) {
            $query = "SELECT * FROM users WHERE `login`='$login'";
            $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
            if(!empty($user)) {
                $hash = $user['password'];
                if(password_verify($pass,$hash)){
                    if($new_pass == $confirm_pass){
                         $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                         $query = "UPDATE `users` SET `password` = '$new_pass' WHERE `users`.`user_id` = '$user_id'";
                         executeQuery(openConnection(),$query);

                         $_SESSION['success-pass-change'] = '<p class="cargo__success">Пароль успішно оновлено </p>';
                    } else {
                        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
                    }
                } else {
                    $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
                } 
        } else {
            $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        }
    } else {
        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
    }
    header("Location:../profile-setting.php"); 
}