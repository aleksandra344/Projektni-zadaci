<?php
session_start(); // Pokretanje sesije ako još nije započeta

// Definiraj varijablu 'menu' koja će prepoznati koji je link aktivan
$menu = isset($_GET['menu']) ? $_GET['menu'] : 1; // Ako nije postavljen, default je 1 (Home)

print '
<nav>
    <a href="index.php?menu=1"><img src="photos/cawlogo2.png" alt="Clay and Wine logo"></a>
    <div class="nav-links" id="navLinks">
        <i class="fa fa-times" onclick="hideMenu()"></i>
        <ul>
            <li><a href="index.php?menu=1" class="'.($menu == 1 ? 'active' : '').'">HOME</a></li>
            <li><a href="index.php?menu=2" class="'.($menu == 2 ? 'active' : '').'">ABOUT US</a></li>
            <li><a href="index.php?menu=3" class="'.($menu == 3 ? 'active' : '').'">COURSES</a></li>
            <li><a href="index.php?menu=4" class="'.($menu == 4 ? 'active' : '').'">PRODUCTS</a></li>
            <li><a href="index.php?menu=5" class="'.($menu == 5 ? 'active' : '').'">CONTACT US</a></li>
        </ul>
    </div>
    <i class="fa fa-bars" onclick="showMenu()"></i>
</nav>';
?>
