<?php
function isAdmin() {
    // Provjeri je li korisnik ulogiran i ima li definiranu ulogu
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role'])) {
        return false;
    }
    return $_SESSION['user']['role'] === 'admin';
}

function isEditor() {
    // Provjeri je li korisnik ulogiran i ima li definiranu ulogu
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role'])) {
        return false;
    }
    return $_SESSION['user']['role'] === 'editor';
}

function isUser() {
    // Provjeri je li korisnik ulogiran i ima li definiranu ulogu
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role'])) {
        return false;
    }
    return $_SESSION['user']['role'] === 'user';
}

function isLoggedIn() {
    // Provjeri samo je li korisnik ulogiran
    return isset($_SESSION['user']);
}
?>
