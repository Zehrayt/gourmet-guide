<?php
// 1. Connection
$link = mysqli_connect("localhost", "root", "");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Create Database
$sql = "CREATE DATABASE IF NOT EXISTS gourmet_db";
if(mysqli_query($link, $sql)){
    echo "Database created successfully.<br>";
} else {
    echo "ERROR: " . mysqli_error($link);
}

// Select Database
mysqli_select_db($link, "gourmet_db");

// 2. Create Recipes Table
$sql_table = "CREATE TABLE IF NOT EXISTS recipes(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title varchar(255) NOT NULL,
    category varchar(100),
    content text,
    image_url varchar(255),
    created_at datetime DEFAULT CURRENT_TIMESTAMP
)";

if(mysqli_query($link, $sql_table)){
    echo "Table created successfully.<br>";
} else {
    echo "ERROR: " . mysqli_error($link);
}

// 3. Insert Sample Data (English)
$sql_insert = "INSERT INTO recipes (title, category, content, image_url) VALUES 
    ('Rice Pudding', 'Desserts', 'Wash the rice and boil it with milk. Add sugar and vanilla...', 'rice_pudding.jpg'),
    ('Lentil Soup', 'Soups', 'Fry the onions and add red lentils. Boil with water...', 'lentil_soup.jpg'),
    ('Stuffed Eggplant', 'Main Courses', 'Fry the eggplants and fill them with minced meat sauce...', 'karniyarik.jpg'),
    ('Menemen', 'Breakfast', 'Sauté tomatoes and green peppers, then add eggs...', 'menemen.jpg'),
    ('Meatballs', 'Main Courses', 'Mix ground beef with spices and breadcrumbs. Bake with potatoes...', 'meatballs.jpg'),
    ('Magnolia Pudding', 'Desserts', 'Crush the biscuits. Prepare the pudding with milk and cream...', 'magnolia.jpg')";

if(mysqli_query($link, $sql_insert)){
    echo "Sample records inserted successfully.";
}

mysqli_close($link);
?>