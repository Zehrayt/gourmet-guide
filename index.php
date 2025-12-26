<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";

/* PAGINATION */
$limit = 3;
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

/* SEARCH */
$search = "";
$where = "";

if (!empty($_GET["search"])) {
    $search = $_GET["search"];
    $where = "WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
}

/* CATEGORY FILTER */
$category = "";
if (!empty($_GET["category"])) {
    $category = $_GET["category"];
    $where .= ($where ? " AND " : " WHERE ") . "category = '$category'";
}

/* BREADCRUMB */
$breadcrumb = '<a href="index.php">Home</a> &gt; Recipes';
if (!empty($category)) {
    $breadcrumb .= ' &gt; ' . htmlspecialchars($category);
}
if (!empty($search)) {
    $breadcrumb .= ' &gt; Search';
}

/* TOTAL COUNT */
$countResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM recipes $where");
$totalRow = mysqli_fetch_assoc($countResult);
$totalPages = ceil($totalRow["total"] / $limit);

/* DATA */
$result = mysqli_query(
    $conn,
    "SELECT * FROM recipes $where LIMIT $limit OFFSET $offset"
);

/* CATEGORIES */
$categories = mysqli_query($conn, "SELECT * FROM categories");

/* SLIDER */
$featured = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM recipes ORDER BY RAND() LIMIT 1")
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gourmet Guide</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background: #f6f7fb;
}

/* MENU */
.menu {
    background: #1f2937;
    padding: 18px 30px;
}

.menu-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    color: white;
    font-weight: 600;
    font-size: 18px;
}

.menu a {
    color: white;
    margin-left: 20px;
    text-decoration: none;
    font-weight: 500;
}

.menu a.active {
    border-bottom: 2px solid #ff7e5f;
    padding-bottom: 4px;
}

/* BANNER */
.banner {
    background: linear-gradient(135deg, #ff7e5f, #feb47b);
    color: white;
    padding: 80px 20px;
    text-align: center;
}

/* BREADCRUMB */
.breadcrumb {
    background: #fff;
    padding: 12px 30px;
    font-size: 14px;
}

.breadcrumb a {
    text-decoration: none;
    color: #ff7e5f;
}

/* SEARCH */
.search-box {
    background: #fff;
    padding: 25px;
    text-align: center;
}

.search-box input {
    padding: 10px 15px;
    width: 240px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.search-box button {
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    background: #ff7e5f;
    color: white;
    cursor: pointer;
}

/* CONTENT */
.content {
    padding: 40px;
}

.recipe-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(260px,1fr));
    gap: 25px;
}

.recipe-link {
    text-decoration: none;
    color: inherit;
}

.recipe-card {
    background: white;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    transition: .3s;
}

.recipe-card:hover {
    transform: translateY(-10px);
}

.recipe-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.recipe-info {
    padding: 20px;
}

.recipe-info p {
    margin-top: 8px;
    line-height: 1.4;
}

.category-badge {
    background: linear-gradient(135deg,#ff7e5f,#feb47b);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-block;
}

/* PAGINATION */
.pagination {
    text-align: center;
    margin-top: 35px;
}

.pagination a {
    margin: 6px;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    background: #e5e7eb;
    color: #000;
}

.pagination a.active {
    background: #1f2937;
    color: white;
}
</style>
</head>

<body>

<!-- MENU -->
<div class="menu">
    <div class="menu-inner">
        <div class="logo">🍽️ Gourmet Guide</div>
        <div class="links">
            <a href="index.php" class="<?php echo empty($category) ? 'active' : ''; ?>">Home</a>

            <?php while ($cat = mysqli_fetch_assoc($categories)) {
                $active = ($category == $cat['name']) ? 'active' : '';
            ?>
                <a href="index.php?category=<?php echo urlencode($cat['name']); ?>" class="<?php echo $active; ?>">
                    <?php echo $cat['name']; ?>
                </a>
            <?php } ?>

            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<!-- BANNER -->
<div class="banner">
    <h1>Discover Delicious Recipes</h1>
    <p>Carefully selected meals from our kitchen</p>
</div>

<!-- BREADCRUMB -->
<div class="breadcrumb">
    <?php echo $breadcrumb; ?>
</div>

<!-- SEARCH -->
<div class="search-box">
    <form method="get">
        <input type="text" name="search" placeholder="Search recipes..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>
</div>

<!-- CONTENT -->
<div class="content">
    <div class="recipe-grid">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <a href="recipe.php?id=<?php echo $row["id"]; ?>" class="recipe-link">
                <div class="recipe-card">
                    <div class="recipe-image">
                        <img src="images/recipes/<?php echo $row["image"]; ?>" alt="">
                    </div>
                    <div class="recipe-info">
                        <span class="category-badge"><?php echo $row["category"]; ?></span>
                        <h3><?php echo $row["title"]; ?></h3>
                        <p><?php echo $row["description"]; ?></p>
                    </div>
                </div>
            </a>
        <?php } ?>
    </div>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <a href="?page=<?php echo $i; ?><?php
                if ($search) echo "&search=$search";
                if ($category) echo "&category=" . urlencode($category);
            ?>" class="<?php echo $page == $i ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php } ?>
    </div>
</div>

</body>
</html>
