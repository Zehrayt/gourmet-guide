<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gourmet Guide</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; }
        .header { background: #ff6347; padding: 20px; color: white; }
        .menu { background: #333; overflow: hidden; }
        .menu a { float: left; display: block; color: white; padding: 14px 16px; text-decoration: none; }
        .menu a:hover { background-color: #ddd; color: black; }
        .slider { background-color: #f4f4f4; padding: 20px; text-align: center; border-bottom: 5px solid #ff6347; }
        .container { padding: 20px; }
        .recipe-box { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
        .pagination { margin-top: 20px; }
        .pagination a { padding: 8px 16px; background: #333; color: white; text-decoration: none; margin-right: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>GOURMET GUIDE</h1>
        <p>The address for delicious recipes</p>
    </div>

    <div class="menu">
        <a href="index.php">Home</a>
        <a href="index.php?category=Breakfast">Breakfast</a>
        <a href="index.php?category=Main Courses">Main Courses</a>
        <a href="index.php?category=Desserts">Desserts</a>
        <a href="login.php" style="float:right">Login</a>
    </div>

    <div style="background:#eee; padding:10px; text-align:right;">
        <form action="index.php" method="GET">
            <input type="text" name="search" placeholder="Search recipes... (e.g. Rice)">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="slider">
        <?php
        $sql_slider = "SELECT * FROM recipes ORDER BY RAND() LIMIT 1";
        $result_slider = mysqli_query($link, $sql_slider);
        if($row = mysqli_fetch_assoc($result_slider)){
            echo "<h2>Menu of the Day: " . $row['title'] . "</h2>";
            echo "<p><i>" . substr($row['content'], 0, 50) . "...</i></p>";
        }
        ?>
    </div>

    <div class="container">
        <h2>Recipe List</h2>

        <?php
        // FEATURE: Pagination Logic
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 3; // Show 3 recipes per page
        $offset = ($page - 1) * $limit;

        // FEATURE: Filter & Search Logic
        $where = "WHERE 1=1"; 
        
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $where .= " AND (title LIKE '%$search%' OR content LIKE '%$search%')";
            echo "<p>Search results for: <strong>$search</strong></p>";
        }
        
        if(isset($_GET['category'])){
            $category = $_GET['category'];
            $where .= " AND category = '$category'";
        }

        // Main Query
        $sql = "SELECT * FROM recipes $where LIMIT $offset, $limit";
        $result = mysqli_query($link, $sql);

        if(mysqli_num_rows($result) > 0){
            // FEATURE: Lists
            while($row = mysqli_fetch_assoc($result)){
                echo "<div class='recipe-box'>";
                echo "<h3><a href='detail.php?id=".$row['id']."'>" . $row['title'] . "</a></h3>";
                echo "<p><b>Category:</b> " . $row['category'] . "</p>";
                echo "<p>" . substr($row['content'], 0, 100) . "...</p>";
                echo "<a href='detail.php?id=".$row['id']."'>Read More</a>";
                echo "</div>";
            }
        } else {
            echo "No recipes found.";
        }
        ?>

        <div class="pagination">
            <?php
            $sql_total = "SELECT COUNT(*) as total FROM recipes $where";
            $res_total = mysqli_query($link, $sql_total);
            $data_total = mysqli_fetch_assoc($res_total);
            $total_pages = ceil($data_total['total'] / $limit);

            for($p = 1; $p <= $total_pages; $p++) {
                echo "<a href='index.php?page=$p'>$p</a>";
            }
            ?>
        </div>
    </div>

</body>
</html>