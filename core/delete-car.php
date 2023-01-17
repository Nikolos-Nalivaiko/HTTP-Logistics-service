<?php

require "database.php";
session_start();

if(isset($_POST['delete_id'])){
    $car_id = $_POST['delete_id']; 
    
    $query = "SELECT * FROM car_images WHERE id_car='$car_id'";
    $images = executeQuery(openConnection(), $query);

    while($image = mysqli_fetch_assoc($images)) {
        // $filename = $_SERVER['DOCUMENT_ROOT']. "/HTTP(LS)/car_images/" . $image['image_name'];
        $filename = $_SERVER['DOCUMENT_ROOT']. "/car_images/" . $image['image_name'];
        unlink($filename);
        $query = "DELETE FROM car_images WHERE `id_car` = '$car_id'";
        executeQuery(openConnection(),$query);
    }

    $query = "DELETE FROM cars WHERE `car_id` = '$car_id'";
    executeQuery(openConnection(),$query);

    $_SESSION['success-delete-car'] = '<p class="cargo__success">Транспорт успішно видалено</p>';

}