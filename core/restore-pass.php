<?php

require "database.php";
session_start();

function generatePass() {
    $pass = '';
    $passLenght = 10;

    for($i = 0; $i < $passLenght; $i++) {
        $pass .= chr(mt_rand(33,126));
    }
    return $pass;
}

if(isset($_POST['submit__restore'])) {
    $login = $_POST['restore_login'];
    $phone = $_POST['phone'];
    $phone = stristr($phone, '3');

    if(valid_string($login) == 0 and valid_phone($phone) == 0){
        $query = "SELECT * FROM users WHERE `login`='$login'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(!empty($user)) {
            if($user['phone'] == $phone) {
                $new_pass = generatePass();
                $_SESSION['success_restore_pass'] = '<div class="success-data__restore">
                <div class="top-success-data__restore">
                    <img src="img/data-success.svg">
                    <p class="headline-success-data__restore">Дані успішно відновлено</p>
                </div>
                <p class="data__restore">Ваш тимчасовий пароль: <span>'.$new_pass.'</span></p>
            </div>';

                $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                $query = "UPDATE `users` SET `password` = '$new_pass' WHERE `users`.`login` = $login";
                executeQuery(openConnection(),$query);
                header("Location:../restore-pass.php");
            }
        }
    }
}

if(isset($_POST['restore_login'])){
    $login = $_POST['restore_login'];
    
    if(valid_string($login) == 0){
        $query = "SELECT `login` FROM users WHERE `login`='$login'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(empty($user)) {
            echo '<p class="form__error">Логіну не існує</p>';
            echo '<style> #restore_login {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';  
        } else {
            echo '<style> #restore_login {border-bottom:1px solid #5BB318;}</style>';
        }
    } else {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #restore_login {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
    }
}

if(isset($_POST['restore_phone'])){
    $phone = $_POST['restore_phone'];
    $login = $_POST['check_login'];
    $phone = stristr($phone, '3');
    
    if(valid_phone($phone) == 0){
        $query = "SELECT `phone` FROM users WHERE `login`='$login'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        if(!empty($user)){
            if($user['phone'] == $phone) {
                echo '<style> #restore_phone {border-bottom:1px solid #5BB318;}</style>';
            } else {
                echo '<p class="form__error">Телефон не знайдено</p>';
                echo '<style> #restore_phone {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
            }
        } else {
            echo '<p class="form__error">Спочатку введіть логін</p>';
            echo '<style> #restore_phone {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
        }
    } else {
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #restore_phone {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
    }
}

function valid_string($params) {
    $valid_string = preg_match("/[^0-9a-zа-яёієї\".,:\s\-_]+/ui", $params);
    return $valid_string;
}

function valid_phone($params) {
    $valid_string = preg_match("/[^0-9\".+,:\s\-_]+/ui", $params);
    return $valid_string;
}