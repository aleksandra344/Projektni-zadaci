<?php 
include 'index.html'; //Uključivanje index.html

include 'header.php'; //Uključivanje header.php

// Provjera vrijednosti varijable 'menu' iz URL parametra
$menu = isset($_GET['menu']) ? $_GET['menu'] : 1; // Ako nije postavljen, default je 1 (Home)

switch ($menu) {
    case 1:
        include 'home.php'; // Početna stranica
        break;
    case 2:
        include 'about.php'; // About us stranica
        break;
    case 3:
        include 'courses.php'; // Courses stranica
        break;
    case 4:
        include 'products.php'; // Products stranica
        break;
    case 5:
        include 'contact.php'; // Contact us stranica
        break;
    default:
        include 'home.php'; // Ako ništa nije odabrano, učitaj Home
        break;
}

// Uključivanje podnožja
include 'footer.php';
?>

