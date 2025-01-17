<?php
// Postavi lozinku koju želiš hashirati
$plainPassword = 'editor123';

// Generiraj hash lozinke
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// Ispiši hash
echo "Hashirana lozinka: " . $hashedPassword;
?>
