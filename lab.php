<?php
$servername = "localhost";
$username = "root";
$userpass = "123456";
$database = "lab";
$conn = mysqli_connect($servername, $username, $userpass, $database);

if (!$conn) {
    echo "Could not connect to server ";
}
$sql = "CREATE DATABASE IF NOT EXISTS lab";

$db_selected = mysqli_select_db($conn, 'lab');
if ($db_selected) {
    echo "Database 'lab' already exists.<br>";
} else {
    echo "Database 'lab' does not exist.<br>";
}

if($conn->query($sql)) {
    echo "Created database lab successfully";
}else{
    echo "Could not create database lab";
}