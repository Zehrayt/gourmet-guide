<?php include 'db.php'; ?>

<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM recipes WHERE id = $id";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
} else {
    die("No ID specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $row['title']; ?></title>
    <style>
        .breadcrumb { padding: 10px 16px; list-style: none; background-color: #eee; }
        .breadcrumb li { display: inline; font-size: 18px; }
        .breadcrumb li+li:before { padding: 8px; color: black; content: "/\00a0"; }
        .breadcrumb a { color: #0275d8; text-decoration: none; }
        .content { padding: 20px; }
    </style>
</head>
<body>

    <ul class="breadcrumb">
      <li><a href="index.php">Home</a></li>
      <li><a href="index.php?category=<?php echo $row['category']; ?>"><?php echo $row['category']; ?></a></li>
      <li><?php echo $row['title']; ?></li>
    </ul>

    <div class="content">
        <h1><?php echo $row['title']; ?></h1>
        <p><i>Published on: <?php echo $row['created_at']; ?></i></p>
        <hr>
        
        <div style="background-color: #ddd; width: 100%; height: 200px; line-height: 200px; text-align: center;">
            Recipe Image Here (<?php echo $row['image_url']; ?>)
        </div>
        <br>

        <p><?php echo $row['content']; ?></p>
        <br>
        <a href="index.php">Back to List</a>
    </div>

</body>
</html>