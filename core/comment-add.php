<?php 

require "database.php";
session_start();

function valid_string($params) {
    $valid_string = preg_match("/[^0-9a-zа-яёієї\".,:\s\-_]+/ui", $params);
    return $valid_string;
}

if(isset($_POST['comment_descript'])) {
    $comment_descript = $_POST['comment_descript'];
    if(valid_string($comment_descript) == 1){
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #comment__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
    } else {
        if(strlen($comment_descript) > 345) {
            echo '<p class="form__error">Кількість символів повинна бути меньше 345</p>';
            echo '<style> #comment__error {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
        }
    }
}

if(isset($_POST['update_comment'])) {
    $comment_descript = $_POST['update_comment'];
    if(valid_string($comment_descript) == 1){
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #update_review {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
    } else {
        if(strlen($comment_descript) > 345) {
            echo '<p class="form__error">Кількість символів повинна бути меньше 345</p>';
            echo '<style> #update_review {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
        }
    }
}

if(isset($_POST['comment_submit'])){
    $comment = $_POST['comment_descript'];
    $grade = $_POST['grade_comment'];
    $recipient_id = $_SESSION['recipient_id'];
    $sender_id = $_SESSION['id'];

    if(valid_string($comment) == 0){
        if(strlen($comment) < 345) {
        $query = "INSERT INTO `comments` (`recipient_id`, `comment_description`, `sender_id`, `comment_grade`) 
        VALUES ('$recipient_id', '$comment', '$sender_id', '$grade')";
        executeQuery(openConnection(),$query);

        $_SESSION['success-comment-add'] = '<p class="cargo__success">Відгук успішно додано</p>';
        header("Location:../user-info.php?user_id=$recipient_id"); 
        } else {
            $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
            header("Location:../user-info.php?user_id=$recipient_id"); 
        }
    } else {
        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        header("Location:../user-info.php?user_id=$recipient_id"); 
    }
}

if(isset($_POST['comment_update_submit'])){
    $comment = $_POST['update_comment'];
    $grade = $_POST['grade_comment'];
    $recipient_id = $_SESSION['recipient_id'];
    $sender_id = $_SESSION['id'];

    if(valid_string($comment) == 0){
        if(strlen($comment) < 345) {
        $query = "UPDATE `comments` SET `recipient_id` = '$recipient_id', `comment_description` = '$comment', `sender_id` = '$sender_id', `comment_grade` = '$grade' WHERE recipient_id='$recipient_id' AND sender_id='$sender_id'";
        executeQuery(openConnection(),$query);

        $_SESSION['success-comment-add'] = '<p class="cargo__success">Відгук успішно редаговано</p>';
        header("Location:../user-info.php?user_id=$recipient_id");  
        } else {
            $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
            header("Location:../user-info.php?user_id=$recipient_id"); 
        }
    } else {
        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        header("Location:../user-info.php?user_id=$recipient_id"); 
    }
}