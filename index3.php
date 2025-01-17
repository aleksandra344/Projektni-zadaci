<?php
session_start();
include("dbconn.php");

// Provera prijave
$isLoggedIn = isset($_SESSION['user']) && $_SESSION['user']['valid'] === 'true';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Clay and Wine</title>
  <meta charset="UTF-8">
  <meta name="description" content="Clay workshop with a touch of wine">
  <meta name="keywords" content="clay, wine, workshop">
  <meta name="author" content="Aleksandra Blažeković">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="favicon.png">
  <link rel="stylesheet" href="style2.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
</head>
<body>

<!-- Ovde NEMA nikakvog <header> ili <section class="header"> -->
<!-- Samo uključujemo fajl koji želimo prikazati, na osnovu ?menu parametra -->

<?php
// Ovisno o parametru 'menu', include-ujemo odgovarajući fajl
if (!isset($_GET['menu']) || $_GET['menu'] == 1) {
  include("home.php");
} else if ($_GET['menu'] == 2) {
  include("about.php");
} else if ($_GET['menu'] == 3) {
  include("course.php");
} else if ($_GET['menu'] == 4) {
  include("product.php");
} else if ($_GET['menu'] == 5) {
  include("contact.php");
}
?>

<!-- Footer (ako želiš) -->
<footer class="footer">
    <p>Copyright &copy;2024 <a href="https://github.com/aleksandra344">Aleksandra Blažeković <img src="photos/github2.jpg" title="Github"></a></p>
</footer>


<!-- JS za toggle meni ili nešto drugo ako treba -->
<script>
  // Ako trebaš showMenu/hideMenu, ali obično ti to treba u home.php (jer je tamo <nav>).
</script>
</body>
</html>
