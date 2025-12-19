<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>🧪 Sistem Test Sayfası</h2>";
echo "<hr>";

// Test 1: Database Connection
echo "<h3>Test 1: Database Bağlantısı</h3>";
$link = mysqli_connect("localhost", "root", "", "gourmet_db");
if($link === false){
    echo "❌ HATA: Veritabanına bağlanılamadı. " . mysqli_connect_error() . "<br>";
} else {
    echo "✅ Veritabanı bağlantısı başarılı!<br>";
    mysqli_close($link);
}

// Test 2: Check if db.php exists
echo "<h3>Test 2: db.php Dosyası</h3>";
if(file_exists('db.php')){
    echo "✅ db.php dosyası mevcut!<br>";
    require_once 'db.php';
    echo "✅ db.php başarıyla yüklendi!<br>";
} else {
    echo "❌ db.php dosyası bulunamadı!<br>";
}

// Test 3: Check users table
echo "<h3>Test 3: Users Tablosu</h3>";
$link = getDBConnection();
$result = mysqli_query($link, "SELECT * FROM users");
if($result){
    $count = mysqli_num_rows($result);
    echo "✅ Users tablosu mevcut! ($count kullanıcı)<br>";
    
    while($row = mysqli_fetch_assoc($result)){
        echo "- Kullanıcı: " . $row['username'] . "<br>";
    }
} else {
    echo "❌ Users tablosu bulunamadı! " . mysqli_error($link) . "<br>";
}

// Test 4: Check recipes table
echo "<h3>Test 4: Recipes Tablosu</h3>";
$result = mysqli_query($link, "SELECT * FROM recipes");
if($result){
    $count = mysqli_num_rows($result);
    echo "✅ Recipes tablosu mevcut! ($count tarif)<br>";
} else {
    echo "❌ Recipes tablosu bulunamadı! " . mysqli_error($link) . "<br>";
}

// Test 5: Session test
echo "<h3>Test 5: Session Testi</h3>";
$_SESSION['test'] = 'Session çalışıyor!';
if(isset($_SESSION['test'])){
    echo "✅ Session çalışıyor: " . $_SESSION['test'] . "<br>";
} else {
    echo "❌ Session çalışmıyor!<br>";
}

// Test 6: Check if logged in
echo "<h3>Test 6: Login Durumu</h3>";
if(isLoggedIn()){
    echo "✅ Kullanıcı giriş yapmış: " . $_SESSION['username'] . "<br>";
} else {
    echo "⚠️ Kullanıcı giriş yapmamış (Bu normal, henüz login olmadıysanız)<br>";
}

mysqli_close($link);

echo "<hr>";
echo "<h3>Test Tamamlandı!</h3>";
echo "<p><a href='login.php'>Login Sayfasına Git</a></p>";
?>