<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

require_once 'db.php';
requireLogin();

$link = getDBConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Guide - Delicious Recipes</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            color: #333;
        }
        
        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #ff6347, #ff8566);
            color: white;
            padding: 30px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 32px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 25px;
        }
        
        .user-info i {
            font-size: 20px;
        }
        
        /* Navigation Menu */
        .menu {
            background: #2c3e50;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .menu-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .menu-links {
            display: flex;
        }
        
        .menu a {
            color: white;
            padding: 16px 24px;
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .menu a:hover {
            background: #34495e;
        }
        
        .menu a.active {
            background: #ff6347;
        }
        
        /* Search Bar */
        .search-bar {
            background: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .search-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .search-form {
            display: flex;
            gap: 10px;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .search-form input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .search-form input:focus {
            outline: none;
            border-color: #ff6347;
            box-shadow: 0 0 0 3px rgba(255, 99, 71, 0.1);
        }
        
        .search-form button {
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .search-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        /* Slider Section */
        .slider {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .slider::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>');
            opacity: 0.3;
        }
        
        .slider-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .slider h2 {
            font-size: 36px;
            margin-bottom: 15px;
            animation: fadeInUp 0.8s ease;
        }
        
        .slider p {
            font-size: 18px;
            opacity: 0.9;
            animation: fadeInUp 0.8s ease 0.2s both;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .section-title {
            font-size: 28px;
            margin-bottom: 30px;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .search-info {
            background: #e3f2fd;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #2196f3;
        }
        
        /* Recipe Grid */
        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .recipe-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .recipe-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            color: white;
        }
        
        .recipe-content {
            padding: 20px;
        }
        
        .recipe-content h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        
        .recipe-content h3 a {
            color: #2c3e50;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .recipe-content h3 a:hover {
            color: #ff6347;
        }
        
        .recipe-category {
            display: inline-block;
            padding: 5px 12px;
            background: #ff6347;
            color: white;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .recipe-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .read-more {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .read-more:hover {
            gap: 12px;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 40px;
        }
        
        .pagination a {
            padding: 10px 18px;
            background: white;
            color: #2c3e50;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .pagination a:hover, .pagination a.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .no-results {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .no-results i {
            font-size: 80px;
            color: #ddd;
            margin-bottom: 20px;
        }
        
        .no-results h3 {
            font-size: 24px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .no-results p {
            color: #999;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <div>
                <h1><i class="fas fa-utensils"></i> GOURMET GUIDE</h1>
                <p>The address for delicious recipes</p>
            </div>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span>Welcome, <strong><?php echo $_SESSION['username']; ?></strong></span>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="menu">
        <div class="menu-content">
            <div class="menu-links">
                <a href="index.php" <?php echo !isset($_GET['category']) ? 'class="active"' : ''; ?>>
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="index.php?category=Breakfast" <?php echo (isset($_GET['category']) && $_GET['category']=='Breakfast') ? 'class="active"' : ''; ?>>
                    <i class="fas fa-coffee"></i> Breakfast
                </a>
                <a href="index.php?category=Main Courses" <?php echo (isset($_GET['category']) && $_GET['category']=='Main Courses') ? 'class="active"' : ''; ?>>
                    <i class="fas fa-hamburger"></i> Main Courses
                </a>
                <a href="index.php?category=Desserts" <?php echo (isset($_GET['category']) && $_GET['category']=='Desserts') ? 'class="active"' : ''; ?>>
                    <i class="fas fa-ice-cream"></i> Desserts
                </a>
            </div>
            <div>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-content">
            <form action="index.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="🔍 Search recipes... (e.g. Rice, Soup, Cake)" 
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit"><i class="fas fa-search"></i> Search</button>
            </form>
        </div>
    </div>

    <!-- Slider -->
    <div class="slider">
        <div class="slider-content">
            <?php
            $sql_slider = "SELECT * FROM recipes ORDER BY RAND() LIMIT 1";
            $result_slider = mysqli_query($link, $sql_slider);
            if($row = mysqli_fetch_assoc($result_slider)){
                echo "<h2>🍽️ Menu of the Day: " . htmlspecialchars($row['title']) . "</h2>";
                echo "<p>" . htmlspecialchars(substr($row['content'], 0, 100)) . "...</p>";
            }
            ?>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h2 class="section-title">
            <i class="fas fa-book-open"></i>
            Recipe Collection
        </h2>

        <?php
        // Pagination Logic
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 6;
        $offset = ($page - 1) * $limit;

        // Filter & Search Logic with SECURE prepared statements
        $where = "WHERE 1=1";
        $params = [];
        $types = "";
        
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $search = sanitizeInput($link, $_GET['search']);
            echo "<div class='search-info'>";
            echo "<i class='fas fa-search'></i> Search results for: <strong>" . htmlspecialchars($search) . "</strong>";
            echo "</div>";
            $where .= " AND (title LIKE ? OR content LIKE ?)";
            $search_param = "%$search%";
            $params[] = $search_param;
            $params[] = $search_param;
            $types .= "ss";
        }
        
        if(isset($_GET['category']) && !empty($_GET['category'])){
            $category = sanitizeInput($link, $_GET['category']);
            $where .= " AND category = ?";
            $params[] = $category;
            $types .= "s";
        }

        // Count total recipes
        $sql_total = "SELECT COUNT(*) as total FROM recipes $where";
        if(!empty($params)) {
            $stmt_total = mysqli_prepare($link, $sql_total);
            if($types) {
                mysqli_stmt_bind_param($stmt_total, $types, ...$params);
            }
            mysqli_stmt_execute($stmt_total);
            $res_total = mysqli_stmt_get_result($stmt_total);
        } else {
            $res_total = mysqli_query($link, $sql_total);
        }
        $data_total = mysqli_fetch_assoc($res_total);
        $total_pages = ceil($data_total['total'] / $limit);

        // Fetch recipes
        $sql = "SELECT * FROM recipes $where ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = mysqli_prepare($link, $sql);
        
        $all_params = array_merge($params, [$limit, $offset]);
        $all_types = $types . "ii";
        
        mysqli_stmt_bind_param($stmt, $all_types, ...$all_params);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0){
            echo "<div class='recipe-grid'>";
            while($row = mysqli_fetch_assoc($result)){
                $icons = [
                    'Breakfast' => 'fa-coffee',
                    'Main Courses' => 'fa-drumstick-bite',
                    'Desserts' => 'fa-birthday-cake'
                ];
                $icon = $icons[$row['category']] ?? 'fa-utensils';
                
                echo "<div class='recipe-card'>";
                echo "<div class='recipe-image'><i class='fas $icon'></i></div>";
                echo "<div class='recipe-content'>";
                echo "<span class='recipe-category'>" . htmlspecialchars($row['category']) . "</span>";
                echo "<h3><a href='detail.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></h3>";
                echo "<p class='recipe-excerpt'>" . htmlspecialchars(substr($row['content'], 0, 120)) . "...</p>";
                echo "<a href='detail.php?id=" . $row['id'] . "' class='read-more'>";
                echo "Read Full Recipe <i class='fas fa-arrow-right'></i>";
                echo "</a>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<div class='no-results'>";
            echo "<i class='fas fa-search'></i>";
            echo "<h3>No recipes found</h3>";
            echo "<p>Try different keywords or browse our categories</p>";
            echo "</div>";
        }
        ?>

        <!-- Pagination -->
        <?php if($total_pages > 1): ?>
        <div class="pagination">
            <?php
            $query_string = $_GET;
            for($p = 1; $p <= $total_pages; $p++) {
                $query_string['page'] = $p;
                $url = 'index.php?' . http_build_query($query_string);
                $active = ($p == $page) ? 'active' : '';
                echo "<a href='$url' class='$active'>$p</a>";
            }
            ?>
        </div>
        <?php endif; ?>
    </div>

</body>
</html>

<?php mysqli_close($link); ?>