<?php
require "database.php";
session_start();

if(isset($_POST['car_upgrade_submit'])){
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
    $carID = $_POST['carID'];
    
    $query = "SELECT * FROM car_images WHERE id_car='$carID'";
    $car_images = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

    if(valid_string($description) == 0) {
        $query = "UPDATE `cars` SET `brand` = '$brand', `model` = '$model', `engine_capacity` = '$capacity_engine', 
        `wheel_drive` = '$wheel', `gearbox` = '$gearbox', `year` = '$year', `power` = '$power', `mileage` = '$mileage', 
        `engine_type` = '$engine', `body_type` = '$body', `load_capacity` = '$load_capacity', `description_car` = '$description', 
        `location_region` = '$region', `location_city` = '$city', `price` = '$price', `id_user` = '$id_user' WHERE `cars`.`car_id` = '$carID'";
        executeQuery($link, $query);


        foreach($images as $image){
            if(empty($image) and empty($car_images)) {
                $query = "INSERT INTO `car_images` (`image_name`, `id_car`, `preview_image`) VALUES ('no-image.jpg', '$carID', '1')"; 
                executeQuery(openConnection(),$query);

            } elseif(!empty($image) and $car_images['image_name'] == 'no-image.jpg') {
                $query = "DELETE FROM car_images WHERE `image_name` = 'no-image.jpg' AND id_car='$carID'";
                executeQuery($link,$query);
                $query =  "INSERT INTO `car_images` ( `image_name`, `id_car`, `preview_image`) VALUES ('$image', '$carID', '0')";
                executeQuery($link,$query);

                $query = "UPDATE `car_images` SET `preview_image` = '0' WHERE `id_car` = '$carID'";
                executeQuery($link,$query);
                $query = "UPDATE `car_images` SET `preview_image` = '1' WHERE `car_images`.`image_name` = '$preview_image'";
                executeQuery($link,$query); 

            } elseif (!empty($image) and $car_images['image_name'] != 'no-image.jpg') {
                $query =  "INSERT INTO `car_images` ( `image_name`, `id_car`, `preview_image`) VALUES ('$image', '$carID', '0')";
                executeQuery($link,$query);

                $query = "UPDATE `car_images` SET `preview_image` = '0' WHERE `id_car` = '$carID'";
                executeQuery($link,$query);
                $query = "UPDATE `car_images` SET `preview_image` = '1' WHERE `car_images`.`image_name` = '$preview_image'";
                executeQuery($link,$query); 
            } elseif (empty($image) and !empty($car_images) and $car_images['image_name'] != 'no-image.jpg') {
                $query = "UPDATE `car_images` SET `preview_image` = '0' WHERE `id_car` = '$carID'";
                executeQuery($link,$query);
                $query = "UPDATE `car_images` SET `preview_image` = '1' WHERE `car_images`.`image_name` = '$preview_image'";
                executeQuery($link,$query); 
            }
        }

        $_SESSION['success-upgrade-car'] = '<p class="cargo__success">Транспорт успішно редаговано</p>';
        header("Location:../profile.php");  
    } else {
        $_SESSION['error-reg'] = '<p class="error_message">Щось пішло не так</p>';
        header("Location:../profile.php");
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