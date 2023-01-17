<?php
require "database.php";

if(isset($_POST['brand'])) {
    $brand = $_POST['brand'];
    $query = "SELECT * FROM models WHERE id_brand='$brand'";
    $models = executeQuery(openConnection(), $query);

    while($model = mysqli_fetch_assoc($models)){
        echo '<option value="'.$model['model_id'].'">'.$model['model_name'].'</option>';
    }
}
