<?php

require "database.php";
session_start();

if(isset($_POST['log_change'])) {
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $new_login = $_POST['new_login'];
    $confirm_login = $_POST['confirm_login'];
    $user_id = $_SESSION['id'];

    if(valid_string($login) == 0 and valid_string($pass) == 0 and valid_string($new_login) == 0 and valid_string($confirm_login) == 0){
        $query = "SELECT * FROM users WHERE `login`='$login'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(!empty($user)) {
            $hash = $user['password'];
            if(password_verify($pass,$hash)){
                if($confirm_login == $new_login) {
                    $query = "UPDATE `users` SET `login` = '$new_login' WHERE `users`.`user_id` = '$user_id'";
                    executeQuery(openConnection(),$query);

                    $_SESSION['success-log-change'] = '<p class="cargo__success">Логін успішно оновлено </p>';
                    header("Location:../profile-setting.php"); 
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

if(isset($_POST['login_check'])) {
    $login = $_POST['login_check'];
    if(valid_string($login) == 0) {
        $query = "SELECT * FROM users WHERE `login`='$login'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(empty($user)) {
            echo '<p class="form__error">Логіну не існує</p>';
            echo '<style> #login {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';  
        }
    } else {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #login {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
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
            echo '<style> #pass {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
        }
    } 
    } else {
    echo '<p class="form__error">Введено неправильний символ</p>';
    echo '<style> #pass {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
    }
}

if(isset($_POST['new_login'])) {
    $new_login = $_POST['new_login'];
    if(valid_string($new_login) == 1) {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #new_login {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
    }
}

if(isset($_POST['confirm_login'])) {
    $confirm_login = $_POST['confirm_login'];
    $login = $_POST['new_login'];
    if(valid_string($confirm_login) == 0) {
        if($confirm_login != $login){
            echo '<p class="form__error">Логін не співпадає</p>';
            echo '<style> #confirm_login {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
        }        
    } else {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #confirm_login {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
    }
}

function valid_string($params) {
    $valid_string = preg_match("/[^0-9a-zа-яёієї\"\s\-_]+/ui", $params);
    return $valid_string;
}
