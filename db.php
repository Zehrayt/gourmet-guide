<?php

function getDBConnection() {
    $link = mysqli_connect("localhost", "root", "", "webapp_db");
    if (!$link) {
        die("DB Connection Error: " . mysqli_connect_error());
    }
    mysqli_set_charset($link, "utf8");
    return $link;
}

function sanitizeInput($link, $data) {
    return mysqli_real_escape_string($link, trim($data));
}

/* 🔐 LOGIN KONTROLÜ BURADA */
function requireLogin() {
    if (
        !isset($_SESSION['user_logged_in']) ||
        $_SESSION['user_logged_in'] !== true
    ) {
        header("Location: login.php");
        exit;
    }
}
