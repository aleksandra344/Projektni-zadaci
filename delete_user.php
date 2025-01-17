<?php
session_start();
include('functions.php');
include('dbconn.php');

// Provjeri je li korisnik administrator
if (!isAdmin()) {
    die("Nemate pravo pristupa ovoj stranici!");
}

// Brisanje korisnika
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    $_SESSION['message'] = "Korisnik uspješno obrisan.";
    header('Location: admin.php');
    exit;
}
?>
