<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";

$id = (int)$_GET["id"];

$result = mysqli_query($conn, "SELECT * FROM recipes WHERE id=$id");
$recipe = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $recipe["title"]; ?> | Gourmet Guide</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background: #f6f7fb;
}

.hero {
    height: 380px;
    background: url('images/recipes/<?php echo $recipe["image"]; ?>') center/cover;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.hero h1 {
    background: rgba(0,0,0,0.6);
    color: white;
    padding: 20px 30px;
    border-radius: 15px;
    margin-bottom: 15px;
}

.info-bar span {
    background: rgba(0,0,0,0.6);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    margin: 0 6px;
}

.container {
    max-width: 900px;
    margin: 40px auto;
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
}

.category {
    display: inline-block;
    background: linear-gradient(135deg,#ff7e5f,#feb47b);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
}

.section {
    margin-top: 35px;
}

.section h2 {
    margin-bottom: 15px;
    color: #1f2937;
}

ul, ol {
    padding-left: 20px;
}

.back {
    display: inline-block;
    margin-top: 40px;
    background: #ff7e5f;
    color: white;
    padding: 12px 22px;
    border-radius: 12px;
    text-decoration: none;
}
</style>
</head>

<body>

<!-- HERO -->
<div class="hero">
    <h1><?php echo $recipe["title"]; ?></h1>

    <!-- ✅ TIME + DIFFICULTY -->
    <div class="info-bar">
        <span>⏱ <?php echo $recipe["cooking_time"]; ?> min</span>
        <span>⚡ <?php echo $recipe["difficulty"]; ?></span>
    </div>
</div>

<div class="container">
    <span class="category"><?php echo $recipe["category"]; ?></span>

    <p><?php echo $recipe["description"]; ?></p>

    <div class="section">
        <h2>Ingredients</h2>
        <ul>
            <?php foreach (explode("\n", $recipe["ingredients"]) as $item) { ?>
                <li><?php echo htmlspecialchars($item); ?></li>
            <?php } ?>
        </ul>
    </div>

    <div class="section">
        <h2>Instructions</h2>
        <ol>
            <?php foreach (explode("\n", $recipe["instructions"]) as $step) { ?>
                <li><?php echo htmlspecialchars($step); ?></li>
            <?php } ?>
        </ol>
    </div>

    <a href="index.php" class="back">← Back to recipes</a>
</div>

</body>
</html>
