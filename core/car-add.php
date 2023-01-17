<?php

require "database.php";
session_start();

if(isset($_POST['car_submit'])){
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $capacity_engine = $_POST['capacity_engine'];
    $wheel = $_POST['wheel'];
    $gearbox = $_POST['gearbox'];
    $power = $_POST['power'];
    $mileage = $_POST['mileage'];
    $engine = $_POST['engine'];
    $body = $_POST['body'];
    $load_capacity = $_POST['load_capacity'];
    $region = $_POST['region'];
    $city = $_POST['city'];
    $load_capacity = $_POST['load_capacity'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $year = $_POST['year'];
    $images = $_POST['image'];
    $id_user = $_SESSION['id'];
    $link = openConnection();
    $preview_image = $_POST['preview_image'];

    if(valid_string($description) == 0) {
        $query = "INSERT INTO `cars` (`brand`, `model`, `engine_capacity`, `wheel_drive`, `gearbox`, `year`, `power`, `mileage`, `engine_type`, `body_type`, `load_capacity`, `description_car`, `location_region`, `location_city`, `price`, `id_user`) 
        VALUES ('$brand', '$model', '$capacity_engine', '$wheel', '$gearbox', '$year', '$power', '$mileage', '$engine', '$body', '$load_capacity', '$description', '$region', '$city', '$price', '$id_user');";
        executeQuery($link, $query);

        $id_car = mysqli_insert_id($link);

        foreach($images as $image) {
            if(empty($image)) {
                $query =  "INSERT INTO `car_images` ( `image_name`, `id_car`, `preview_image`) VALUES ('no-image.jpg', '$id_car', '0')";
            } else {
                $query =  "INSERT INTO `car_images` ( `image_name`, `id_car`, `preview_image`) VALUES ('$image', '$id_car', '0')";
            }
            executeQuery($link,$query);
        }
    
        if(empty($preview_image)) {
            $query = "UPDATE `car_images` SET `preview_image` = '1' WHERE `car_images`.`image_name` = 'no-image.jpg'";    
        } else {
            $query = "UPDATE `car_images` SET `preview_image` = '1' WHERE `car_images`.`image_name` = '$preview_image'";
        }
        executeQuery($link,$query);

        $_SESSION['success-add-car'] = '<p class="cargo__success">Транспорт успішно додано</p>';
        header("Location:../car-add.php");
    } else {
        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        header("Location:../car-add.php");
    }
}

function valid_string($params) {
    $valid_string = preg_match("/[^0-9a-zа-яёієї\".!,:\s\-_]+/ui", $params);
    return $valid_string;
}

if(isset($_POST['descript'])) {
    $car_descript = $_POST['descript'];

    if(valid_string($car_descript) == 1){
        echo '<p class="form__error">Введено неправильний символ</p>';
        echo '<style> #car_descript {border:1px solid #FD5D5D; color:#FD5D5D;}</style>';   
}
}