<?php

require "database.php";
session_start();

function valid_string($params) {
    $valid_string = preg_match("/[^0-9a-zа-яёієї\".,:\s\-_]+/ui", $params);
    return $valid_string;
}

if(isset($_POST['review_submit'])){
    $review = $_POST['review_descript'];
    $grade = $_POST['grade_review'];
    $user_id = $_SESSION['id'];

    if(valid_string($review) == 0){
        if(strlen($review) < 345){
        $query = "INSERT INTO `reviews` (`id_user`, `review_description`, `review_grade`) VALUES ('$user_id', '$review', '$grade')";
        executeQuery(openConnection(),$query);

        $_SESSION['success-review-add'] = '<p class="cargo__success">Відгук успішно додано</p>';
        header("Location:../profile.php");
        } else {
            $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
            header("Location:../profile.php");
        }  
    } else {
        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        header("Location:../profile.php");
    }
} 

if(isset($_POST['review_update_submit'])){
    $review = $_POST['update_review'];
    $grade = $_POST['grade_review'];
    $user_id = $_SESSION['id'];

    if(valid_string($review) == 0){
        if(strlen($review) < 345) {
        $query = "UPDATE `reviews` SET `id_user` = '$user_id', `review_description` = '$review', `review_grade` = '$grade' WHERE id_user='$user_id'";
        executeQuery(openConnection(),$query);
        
        $_SESSION['success-review-add'] = '<p class="cargo__success">Відгук успішно редаговано</p>';
        header("Location:../profile.php");
        } else {
            $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
            header("Location:../profile.php");
        } 
    } else {
        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        header("Location:../profile.php");
    }
}

if(isset($_POST['review_descript'])) {
    $review_descript = $_POST['review_descript'];
    if(valid_string($review_descript) == 1){
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #review__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
} else {
    if(strlen($review_descript) > 345) {
        echo '<p class="form__error">Кількість символів повинна бути меньше 345</p>';
        echo '<style> #review__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
    }
}
}

if(isset($_POST['update_review'])) {
    $review_descript = $_POST['update_review'];
    if(valid_string($review_descript) == 1){
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #update_review {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
} else {
    if(strlen($review_descript) > 345) {
        echo '<p class="form__error">Кількість символів повинна бути меньше 345</p>';
        echo '<style> #update_review {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
    }
}
} 