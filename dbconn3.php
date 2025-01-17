<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "clay_and_wine"; // prilagodi

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // Podešavanje PDO error mod-a
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
