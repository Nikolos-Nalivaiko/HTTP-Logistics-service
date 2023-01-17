<?php
require "database.php";
session_start();

if(isset($_POST['load_region'])) {
    $load_region = $_POST['load_region'];
    $load_region = strrchr($load_region, ' ');
    $query = "SELECT * FROM regions JOIN cities ON cities.id_region = regions.region_id WHERE region_id='$load_region'";
    $load_cities = executeQuery(openConnection(), $query);

    echo '<option class="option__filter" value="">Всі області</option>';
    while($load_city = mysqli_fetch_assoc($load_cities)){
        echo '<option class="option__filter" value="loading_city = '.$load_city['city_id'].'">'.$load_city['city_name'].'</option>';
    }
}

if(isset($_POST['brand'])) {
    $brand = $_POST['brand'];
    $brand = strrchr($brand, ' ');
    $query = "SELECT * FROM models WHERE id_brand='$brand'";
    $models = executeQuery(openConnection(), $query);

    echo '<option class="option__filter" value="">Всі моделі</option>';
    while($model = mysqli_fetch_assoc($models)){
        echo '<option class="option__filter" value="model = '.$model['model_id'].'">'.$model['model_name'].'</option>';
    }
}

if(isset($_POST['region'])) {
    $region = $_POST['region'];
    $region = strrchr($region, ' ');
    $query = "SELECT * FROM regions JOIN cities ON cities.id_region = regions.region_id WHERE region_id='$region'";
    $cities = executeQuery(openConnection(), $query);

    echo '<option class="option__filter" value="">Всі області</option>';
    while($city = mysqli_fetch_assoc($cities)){
        echo '<option class="option__filter" value="location_city = '.$city['city_id'].'">'.$city['city_name'].'</option>';
    }
}

if(isset($_POST['unload_region'])) {
    $unload_region = $_POST['unload_region'];
    $unload_region = strrchr($unload_region, ' ');
    $query = "SELECT * FROM regions JOIN cities ON cities.id_region = regions.region_id WHERE region_id='$unload_region'";
    $unload_cities = executeQuery(openConnection(), $query);

    echo '<option class="option__filter" value="">Всі області</option>';
    while($unload_city = mysqli_fetch_assoc($unload_cities)){
        echo '<option class="option__filter" value="unloading_city = '.$unload_city['city_id'].'">'.$unload_city['city_name'].'</option>';
    }
}

if(isset($_POST['filter_submit'])) {
    if(!empty($_POST['load_region'])) $load_region = $_POST['load_region'];
    if(!empty($_POST['load_city'])) $load_city = $_POST['load_city'];
    if(!empty($_POST['load_date'])) $load_date = "loading_date = '".$_POST['load_date']."'";
    if(!empty($_POST['weight'])) $weight = "weight = '".$_POST['weight']."'";
    if(!empty($_POST['body'])) $body = $_POST['body'];
    if(!empty($_POST['distance'])) $distance = "distance = '".$_POST['distance']."'";
    if(!empty($_POST['unload_region'])) $unload_region = $_POST['unload_region'];
    if(!empty($_POST['unload_city'])) $unload_city = $_POST['unload_city'];
    if(!empty($_POST['unload_date'])) $unload_date = "unloading_date = '".$_POST['unload_date']."'";

    $filters = [$load_region, $load_city, $load_date, $weight, $body, $distance, $unload_region, $unload_city, $unload_date];
    $query_first_part = "SELECT * FROM cargos JOIN body_types ON body_types.body_id = cargos.body_type WHERE";
    $query_last_part = " ORDER BY cargo_id DESC;";

    $query_loads = "SELECT city_name,region_name FROM cargos 
    JOIN regions ON regions.region_id = cargos.loading_region
    JOIN cities ON cities.city_id = cargos.loading_city WHERE";

    $query_unloads = "SELECT city_name,region_name FROM cargos 
    JOIN regions ON regions.region_id = cargos.unloading_region
    JOIN cities ON cities.city_id = cargos.unloading_city WHERE";

    foreach($filters as $filter) {
        if(!empty($filter)) {
            $no_empty[] = $filter;
            $query = $query_first_part.' '.implode(' AND ', $no_empty).$query_last_part;
            $_SESSION['cargo-filter'] = $query;

            $query = $query_loads.' '.implode(' AND ', $no_empty).$query_last_part;
            $_SESSION['cargo-filter-loads'] = $query;

            $query = $query_unloads.' '.implode(' AND ', $no_empty).$query_last_part;
            $_SESSION['cargo-filter-unloads'] = $query;
            
        } else {
            $empty_filter[] = $filter;
        }
    }
    header("Location:../cargos.php"); 
}  

if(isset($_POST['filter_submit_car'])) {
    if(!empty($_POST['brand'])) $brand = $_POST['brand'];
    if(!empty($_POST['model'])) $model = $_POST['model'];
    if(!empty($_POST['engine_capacity'])) $engine_capacity = "engine_capacity = '".$_POST['engine_capacity']."'";
    if(!empty($_POST['wheel'])) $wheel = $_POST['wheel'];
    if(!empty($_POST['gearbox'])) $gearbox = $_POST['gearbox'];
    if(!empty($_POST['engine'])) $engine = $_POST['engine'];
    if(!empty($_POST['body'])) $body = $_POST['body'];
    if(!empty($_POST['load_capacity'])) $load_capacity = "load_capacity = '".$_POST['load_capacity']."'";
    if(!empty($_POST['region'])) $region = $_POST['region'];
    if(!empty($_POST['city'])) $city = $_POST['city'];

    $filters = [$brand, $model, $engine_capacity, $wheel, $gearbox, $engine, $body, $load_capacity, $region, $city];

    $query_first_part = "SELECT * FROM cars 
    JOIN brands ON brands.brand_id=cars.brand
    JOIN models ON models.model_id=cars.model
    JOIN regions ON regions.region_id=cars.location_region
    JOIN cities ON cities.city_id=cars.location_city
    JOIN body_types ON body_types.body_id=cars.body_type 
    JOIN car_images ON car_images.id_car=cars.car_id WHERE preview_image = '1' AND";
    $query_last_part = " ORDER BY car_id DESC;";

    foreach($filters as $filter) {
        if(!empty($filter)) {
            $conditions[] = $filter;
            $query = $query_first_part.' '.implode(' AND ', $conditions).$query_last_part;
            $_SESSION['filter-car'] = $query;
        }
    }

    header("Location:../cars.php"); 

}

if(isset($_POST['filter_reset'])) {
    if(isset($_SESSION['cargo-filter'])) unset($_SESSION['cargo-filter']);
    if(isset($_SESSION['cargo-filter-loads'])) unset($_SESSION['cargo-filter-loads']);
    if(isset($_SESSION['cargo-filter-unloads'])) unset($_SESSION['cargo-filter-unloads']);
    header("Location:../cargos.php"); 
}

if(isset($_POST['filter_reset_car'])) {
    if(isset($_SESSION['filter-car'])) unset($_SESSION['filter-car']);
    header("Location:../cars.php"); 
}
?>