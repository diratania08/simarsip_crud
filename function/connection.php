<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "coba";

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die(mysqli_error($connection));
}