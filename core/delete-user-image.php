<?php

require "database.php";
session_start();

if(isset($_POST['image_name'])) {
    $image_name = $_POST['image_name'];
    
    // $filename = $_SERVER['DOCUMENT_ROOT']. "/HTTP(LS)/user_images/" . $image_name;
    $filename = $_SERVER['DOCUMENT_ROOT']. "/user_images/" . $image_name;
    unlink($filename);
}

if(isset($_POST['image_upgrade_name'])) {
    $image_name_upgrade = $_POST['image_upgrade_name'];
    $user_id = $_SESSION['id'];

    $query = "UPDATE `users` SET `user_image` = 'no-image.jpg' WHERE `users`.`user_id` = '$user_id'";
    executeQuery(openConnection(),$query);
    
    // $filename = $_SERVER['DOCUMENT_ROOT']. "/HTTP(LS)/user_images/" . $image_name_upgrade;
    $filename = $_SERVER['DOCUMENT_ROOT']. "/user_images/" . $image_name_upgrade;
    unlink($filename);
}