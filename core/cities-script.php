<?php
require "database.php";

if(isset($_POST['region'])) {
    $region = $_POST['region'];
    $query = "SELECT * FROM regions JOIN cities ON cities.id_region = regions.region_id WHERE region_id='$region'";
    $cities = executeQuery(openConnection(), $query);

    while($city = mysqli_fetch_assoc($cities)){
        echo '<option value="'.$city['city_id'].'">'.$city['city_name'].'</option>';
    }
}

if(isset($_POST['unload_region'])) {
    $unload_region = $_POST['unload_region'];
    $query = "SELECT * FROM regions JOIN cities ON cities.id_region = regions.region_id WHERE region_id='$unload_region'";
    $unload_cities = executeQuery(openConnection(), $query);

    while($unload_city = mysqli_fetch_assoc($unload_cities)){
        echo '<option value="'.$unload_city['city_id'].'">'.$unload_city['city_name'].'</option>';
    }
}

if(isset($_POST['load_region'])) {
    $load_region = $_POST['load_region'];
    $query = "SELECT * FROM regions JOIN cities ON cities.id_region = regions.region_id WHERE region_id='$load_region'";
    $load_cities = executeQuery(openConnection(), $query);

    while($load_city = mysqli_fetch_assoc($load_cities)){
        echo '<option value="'.$load_city['city_id'].'">'.$load_city['city_name'].'</option>';
    }
}