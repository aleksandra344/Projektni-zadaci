<?php
session_start();
include('dbconn.php');

$username = trim($_POST['username']);
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user) {
    // Korisnik postoji, provjeriti lozinku
    if(password_verify($password, $user['password'])) {
        // Uspješna prijava
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'valid' => 'true'
        ];
        $_SESSION['message'] = "Uspješno ste prijavljeni kao {$user['username']}.";
        header("Location: index.php"); // ili admin.php, ovisno o zadatku
        exit;
    } else {
        // Pogrešna lozinka
        $_SESSION['message'] = "Pogrešna lozinka.";
        header("Location: login.php");
        exit;
    }
} else {
    // Ne postoji korisnik s tim usernameom
    $_SESSION['message'] = "Korisničko ime ne postoji.";
    header("Location: login.php");
    exit;
}
