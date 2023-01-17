<?php
require "database.php";
session_start();

$login = $_COOKIE['login'];
$key = $_COOKIE['key'];

$query = 'UPDATE users SET cookie=null WHERE login="' . $login . '"';
executeQuery(openConnection(), $query);

session_destroy();

header("Location:../index.php"); 