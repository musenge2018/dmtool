<?php

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "online_notice";

$conn = mysqli_connect($servername,$username,$password,$db_name);

if (!$conn) {
    echo "Connection failed!";
    exit();
}