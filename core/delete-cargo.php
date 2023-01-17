<?php

require "database.php";
session_start();

if(isset($_POST['delete_id'])){
    $delete_id = $_POST['delete_id'];

    $query = "DELETE FROM cargos WHERE `cargo_id` = '$delete_id'";
    executeQuery(openConnection(),$query);

    $_SESSION['success-delete-cargo'] = '<p class="cargo__success">Вантаж успішно видалено</p>';
}