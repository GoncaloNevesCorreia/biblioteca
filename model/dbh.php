<?php

$Servername = "localhost";
$dbUsername = "root";
$Password = "";
$dbName = "biblioteca";

$conn = mysqli_connect($Servername, $dbUsername, $Password, $dbName);
$conn->set_charset("utf8");
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}