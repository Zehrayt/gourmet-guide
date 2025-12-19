<?php
$link = mysqli_connect("localhost", "root", "", "gourmet_db");

// Set charset to handle special characters properly
mysqli_set_charset($link, "utf8");

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>