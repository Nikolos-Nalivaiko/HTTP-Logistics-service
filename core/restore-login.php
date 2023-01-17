<?php
require "database.php";
session_start();

function valid_phone($params) {
    $valid_string = preg_match("/[^0-9\".+,:\s\-_]+/ui", $params);
    return $valid_string;
}

if(isset($_POST['restore_phone'])) {
    $restore_phone = $_POST['restore_phone'];
    $restore_phone = stristr($restore_phone, '3');

    if(valid_phone($restore_phone) == 0) {
        $query = "SELECT `phone` FROM users";
        $phones = mysqli_fetch_array(executeQuery(openConnection(),$query));
        foreach($phones as $phone) {
            if($restore_phone == $phone) {
                echo '<style> #restore_phone {border-bottom:1px solid #5BB318;}</style>';
            } else {
                $error_phone = '<p class="form__error">Телефон не знайдено</p>';
                echo '<style> #restore_phone {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
            }
        }
        if(isset($error_phone)) {
            echo $error_phone;
        }
    }
}

if(isset($_POST['restore_pass'])) {
    $restore_pass = $_POST['restore_pass'];
    $phone_check = $_POST['phone_check'];
    $phone_check = stristr($phone_check, '3');

    if(valid_phone($phone_check) == 0) {
        $query = "SELECT `phone` FROM users";
        $phones = mysqli_fetch_array(executeQuery(openConnection(),$query));
        foreach($phones as $phone) {
            if($phone_check == $phone) {
                $success = true;
            } else {
                $success = false;
            }
        }

        if($success == true) {
            $query = "SELECT * FROM users WHERE `phone` = '$phone_check'";
            $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
            $hash = $user['password'];
            if(password_verify($restore_pass,$hash)){
                echo '<style> #restore_pass {border-bottom:1px solid #5BB318;}</style>';
            } else {
                echo '<p class="form__error">Пароль не існує</p>';
                echo '<style> #restore_pass {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';
            }
        } else {
            echo '<p class="form__error">Телефон не знайдено</p>';
            echo '<style> #restore_pass {border:1px solid #FD5D5D; color:#FD5D5D;}</style>'; 
        }

        if(isset($error)) {
            echo $error;
        }
    }
}

if(isset($_POST['submit__restore'])){
    $phone_restore = $_POST['restore_phone'];
    $phone_restore = stristr($phone_restore, '3');
    $pass = $_POST['restore_pass'];

    if(valid_phone($phone_restore) == 0) {
        $query = "SELECT `phone` FROM users";
        $phones = mysqli_fetch_array(executeQuery(openConnection(),$query));
        foreach($phones as $phone) {
            if($phone_restore == $phone) {
                $success = true;
            } else {
                $success = false;
            }
        }
    }

    if($success == true) {
        $query = "SELECT * FROM users WHERE `phone` = '$phone_restore'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
        $hash = $user['password'];
        if(password_verify($pass,$hash)) {
            $login = $user['login'];

            $_SESSION['success_restore_login'] = '<div class="success-data__restore">
            <div class="top-success-data__restore">
                <img src="img/data-success.svg">
                <p class="headline-success-data__restore">Дані успішно відновлено</p>
            </div>
            <p class="data__restore">Ваш логін: <span>'.$login.'</span></p>
        </div>';


        }
    }
    header("Location:../restore-login.php");
}