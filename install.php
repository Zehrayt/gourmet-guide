<?php
echo "<h2>🔧 Gourmet Guide - Database Installation</h2>";
echo "<hr>";

// 1. Connection
$link = mysqli_connect("localhost", "root", "");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// 2. Create Database
$sql = "CREATE DATABASE IF NOT EXISTS gourmet_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if(mysqli_query($link, $sql)){
    echo "✅ Database created successfully.<br>";
} else {
    echo "❌ ERROR: " . mysqli_error($link) . "<br>";
}

// 3. Select Database
mysqli_select_db($link, "gourmet_db");

// 4. Create Users Table
$sql_users = "CREATE TABLE IF NOT EXISTS users(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";

if(mysqli_query($link, $sql_users)){
    echo "✅ Users table created successfully.<br>";
} else {
    echo "❌ ERROR: " . mysqli_error($link) . "<br>";
}

// 5. Create Recipes Table
$sql_recipes = "CREATE TABLE IF NOT EXISTS recipes(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category)
)";

if(mysqli_query($link, $sql_recipes)){
    echo "✅ Recipes table created successfully.<br>";
} else {
    echo "❌ ERROR: " . mysqli_error($link) . "<br>";
}

// 6. Insert Demo User (password: admin123)
$hashed_password = password_hash("admin123", PASSWORD_DEFAULT);
$sql_user = "INSERT IGNORE INTO users (username, password, email) VALUES 
    ('admin', '$hashed_password', 'admin@gourmet.com')";

if(mysqli_query($link, $sql_user)){
    echo "✅ Demo user created (username: admin, password: admin123).<br>";
} else {
    echo "⚠️ Note: " . mysqli_error($link) . "<br>";
}

// 7. Insert Sample Recipes
$sql_recipes_data = "INSERT INTO recipes (title, category, content, image_url) VALUES 
    ('Rice Pudding', 'Desserts', 'Wash the rice thoroughly and boil it with milk on medium heat. Add sugar and vanilla extract for flavor. Stir occasionally to prevent sticking. Once thickened, let it cool and serve chilled with cinnamon on top.', 'rice_pudding.jpg'),
    ('Lentil Soup', 'Main Courses', 'Fry finely chopped onions in olive oil until golden. Add red lentils and stir for a minute. Pour water and let it boil until lentils are soft. Blend half of the soup for a creamy texture. Season with salt, pepper, and lemon juice.', 'lentil_soup.jpg'),
    ('Menemen', 'Breakfast', 'Sauté diced tomatoes and green peppers in olive oil until soft. Season with salt and red pepper flakes. Crack eggs directly into the pan and gently scramble. Serve hot with fresh bread.', 'menemen.jpg'),
    ('Turkish Meatballs', 'Main Courses', 'Mix ground beef with breadcrumbs, grated onion, minced garlic, cumin, and paprika. Shape into oval meatballs. Bake in the oven with sliced potatoes and tomatoes. Drizzle with olive oil before serving.', 'meatballs.jpg'),
    ('Magnolia Pudding', 'Desserts', 'Crush digestive biscuits and layer them in glasses. Prepare vanilla pudding with milk and whipped cream. Pour over biscuits and refrigerate for 4 hours. Top with chocolate shavings before serving.', 'magnolia.jpg'),
    ('Spinach Borek', 'Breakfast', 'Sauté fresh spinach with onions and feta cheese. Layer phyllo dough sheets, brushing each with melted butter. Add spinach filling between layers. Bake until golden and crispy.', 'borek.jpg'),
    ('Chocolate Cake', 'Desserts', 'Mix flour, cocoa powder, sugar, eggs, and melted butter. Pour into a greased pan and bake at 180°C for 35 minutes. Let it cool before adding chocolate ganache frosting.', 'chocolate_cake.jpg'),
    ('Turkish Coffee', 'Breakfast', 'Add finely ground coffee and sugar to cold water in a cezve. Heat slowly without stirring. When foam rises, remove from heat. Pour into small cups and let grounds settle before drinking.', 'turkish_coffee.jpg')";

if(mysqli_query($link, $sql_recipes_data)){
    echo "✅ Sample recipes inserted successfully.<br>";
} else {
    echo "⚠️ Note: " . mysqli_error($link) . "<br>";
}

echo "<hr>";
echo "<h3>✅ Installation Complete!</h3>";
echo "<p>🔗 <a href='login.php'>Go to Login Page</a></p>";
echo "<p><strong>Demo Login:</strong><br>Username: admin<br>Password: admin123</p>";

mysqli_close($link);
?>