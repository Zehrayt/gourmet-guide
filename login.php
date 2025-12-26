<?php
session_start();

/* ZATEN LOGİN İSE ANA SAYFAYA GİTSİN */
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if ($username == "" || $password == "") {
        $error = "Lütfen tüm alanları doldurun.";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            /* LOGIN BAŞARILI */
            $_SESSION["login"] = true;
            $_SESSION["username"] = $user["username"];

            header("Location: index.php");
            exit;
        } else {
            $error = "Kullanıcı adı veya şifre hatalı.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | Gourmet Guide</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff6f61, #ff9472);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            width: 320px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        button {
            background: #ff6f61;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            font-size: 15px;
        }

        button:hover {
            background: #ff4f3d;
        }

        .error {
            background: #ffe0e0;
            color: #b00000;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>🍽️ Gourmet Guide</h2>

    <?php if ($error != "") { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" autocomplete="off">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
