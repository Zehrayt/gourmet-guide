<?php 
require_once 'db.php';
requireLogin();

$link = getDBConnection();

if(isset($_GET['id'])){
    $id = (int)$_GET['id']; // Secure: cast to integer
    
    // Secure: use prepared statement
    $stmt = mysqli_prepare($link, "SELECT * FROM recipes WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if($row = mysqli_fetch_assoc($result)){
        // Recipe found
    } else {
        die("Recipe not found.");
    }
} else {
    die("No ID specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['title']); ?> - Gourmet Guide</title>
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
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #ff6347, #ff8566);
            color: white;
            padding: 20px 0;
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
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
        }
        
        /* Breadcrumb */
        .breadcrumb {
            background: white;
            padding: 15px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .breadcrumb-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
        
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #ff6347;
        }
        
        .breadcrumb-separator {
            color: #999;
        }
        
        .breadcrumb-current {
            color: #666;
        }
        
        /* Content Container */
        .content-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .recipe-detail {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }
        
        .recipe-header {
            padding: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
        }
        
        .category-badge {
            display: inline-block;
            padding: 8px 20px;
            background: rgba(255,255,255,0.3);
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .recipe-title {
            font-size: 42px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .recipe-meta {
            display: flex;
            justify-content: center;
            gap: 30px;
            font-size: 14px;
            opacity: 0.9;
        }
        
        .recipe-meta i {
            margin-right: 8px;
        }
        
        .recipe-image-container {
            position: relative;
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .recipe-image-placeholder {
            font-size: 120px;
            color: rgba(255,255,255,0.4);
        }
        
        .recipe-image-text {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: rgba(0,0,0,0.6);
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 12px;
        }
        
        .recipe-body {
            padding: 50px;
        }
        
        .recipe-content-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 3px solid #ff6347;
        }
        
        .recipe-content {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            text-align: justify;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #f0f0f0;
        }
        
        .btn {
            flex: 1;
            padding: 15px 30px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            background: white;
            color: #2c3e50;
            border: 2px solid #e0e0e0;
        }
        
        .btn-secondary:hover {
            background: #f8f9fa;
            border-color: #667eea;
            color: #667eea;
        }
        
        @media (max-width: 768px) {
            .recipe-header {
                padding: 30px 20px;
            }
            
            .recipe-title {
                font-size: 32px;
            }
            
            .recipe-body {
                padding: 30px 20px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <h1><i class="fas fa-utensils"></i> GOURMET GUIDE</h1>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span><?php echo $_SESSION['username']; ?></span>
            </div>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <div class="breadcrumb-content">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <span class="breadcrumb-separator">/</span>
            <a href="index.php?category=<?php echo urlencode($row['category']); ?>">
                <?php echo htmlspecialchars($row['category']); ?>
            </a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current"><?php echo htmlspecialchars($row['title']); ?></span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-container">
        <div class="recipe-detail">
            
            <!-- Recipe Header -->
            <div class="recipe-header">
                <div class="category-badge">
                    <?php 
                    $icons = [
                        'Breakfast' => 'fa-coffee',
                        'Main Courses' => 'fa-drumstick-bite',
                        'Desserts' => 'fa-birthday-cake'
                    ];
                    $icon = $icons[$row['category']] ?? 'fa-utensils';
                    ?>
                    <i class="fas <?php echo $icon; ?>"></i>
                    <?php echo htmlspecialchars($row['category']); ?>
                </div>
                <h1 class="recipe-title"><?php echo htmlspecialchars($row['title']); ?></h1>
                <div class="recipe-meta">
                    <span><i class="fas fa-calendar"></i> <?php echo date('F d, Y', strtotime($row['created_at'])); ?></span>
                    <span><i class="fas fa-clock"></i> 30-45 min</span>
                </div>
            </div>

            <!-- Recipe Image -->
            <div class="recipe-image-container">
                <i class="fas <?php echo $icon; ?> recipe-image-placeholder"></i>
                <div class="recipe-image-text">
                    <?php echo htmlspecialchars($row['image_url']); ?>
                </div>
            </div>

            <!-- Recipe Body -->
            <div class="recipe-body">
                <div class="recipe-content-section">
                    <h2 class="section-title">
                        <i class="fas fa-book-reader"></i>
                        Recipe Instructions
                    </h2>
                    <div class="recipe-content">
                        <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to List
                    </a>
                    <a href="index.php?category=<?php echo urlencode($row['category']); ?>" class="btn btn-primary">
                        <i class="fas fa-th-large"></i>
                        More in <?php echo htmlspecialchars($row['category']); ?>
                    </a>
                </div>
            </div>

        </div>
    </div>

</body>
</html>

<?php mysqli_close($link); ?>