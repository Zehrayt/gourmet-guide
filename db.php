<?php
$conn = mysqli_connect("localhost", "root", "", "gourmet_guide", 3307);

if (!$conn) {
    die("DB HATA: " . mysqli_connect_error());
}
