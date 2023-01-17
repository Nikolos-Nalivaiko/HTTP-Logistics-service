<?php

require "database.php";

if(isset($_POST['image_name'])) {
    $image_name = $_POST['image_name'];
    
    // $filename = $_SERVER['DOCUMENT_ROOT']. "/HTTP(LS)/car_images/" . $image_name;
    $filename = $_SERVER['DOCUMENT_ROOT']. "/car_images/" . $image_name;
    unlink($filename);
}

if(isset($_POST['image_upgrade_name'])) {
    $image_name_upgrade = $_POST['image_upgrade_name'];

    $query = "DELETE FROM `car_images` WHERE image_name = '$image_name_upgrade'";
    executeQuery(openConnection(),$query);
    // echo $query;
    
    // $filename = $_SERVER['DOCUMENT_ROOT']. "/HTTP(LS)/car_images/" . $image_name_upgrade;
    $filename = $_SERVER['DOCUMENT_ROOT']. "/car_images/" . $image_name_upgrade;
    unlink($filename);
}