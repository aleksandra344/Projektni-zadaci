<?php
session_start();
include('functions.php');
include('dbconn.php');

if (!isAdmin()) {
    die("Nemate pravo brisanja vijesti!");
}

if (isset($_GET['id'])) {
    $news_id = $_GET['id'];
    $sql = "DELETE FROM news WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$news_id]);

    header('Location: news_list.php');
    exit;
}
?>
