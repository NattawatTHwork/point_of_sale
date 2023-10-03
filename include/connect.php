<?php
$db_host = 'localhost';
$db_name = 'db62223615';
$db_user = 'root';
$db_pass = '';

try {
    $connect = new PDO("mysql:host=$db_host; dbname=$db_name", $db_user, $db_pass);
    $connect->exec("set names utf8mb4");
}
catch (PDOException $e) {
    echo $e->getMessage();
}