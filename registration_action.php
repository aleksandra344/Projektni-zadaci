<?php
session_start();
include('dbconn.php'); // Mora imati $conn

// 1. Dohvaćamo podatke iz POST forme
$ime            = trim($_POST['ime']);
$prezime        = trim($_POST['prezime']);
$email          = trim($_POST['email']);
$drzava         = trim($_POST['drzava']);
$grad           = trim($_POST['grad']);
$ulica          = trim($_POST['ulica']);
$datum_rodjenja = $_POST['datum_rodjenja'];

// 2. Provjeravamo odabir lozinke
$pwOption  = $_POST['pw_option']; // "auto" ili "manual"

// 3. Generiranje korisničkog imena (prvo slovo imena + prezime):
$firstLetter   = mb_substr($ime, 0, 1);
$baseUsername  = mb_strtolower($firstLetter . $prezime, 'UTF-8');
$baseUsername  = preg_replace('/\s+/', '', $baseUsername);

$username = $baseUsername;
$brojac   = 1;

// Provjera postoji li već takvo username
$sqlCheck = "SELECT COUNT(*) FROM users WHERE username = :username";
$stmtCheck = $conn->prepare($sqlCheck);

while (true) {
  $stmtCheck->execute(['username' => $username]);
  $count = $stmtCheck->fetchColumn();
  if ($count > 0) {
    $username = $baseUsername . $brojac;
    $brojac++;
  } else {
    break;
  }
}

// 4. Lozinka
if ($pwOption === 'auto') {
  // Generiramo nasumično 8 heksadecimalnih znakova
  $plainPassword = bin2hex(random_bytes(4));
} else {
  // Uzimamo lozinku iz POST forme
  $plainPassword = $_POST['lozinka'];
  // Možeš validirati, npr. min duljina
  if (strlen($plainPassword) < 6) {
    // Vrati korisniku grešku ili sl.
    $_SESSION['message'] = "Lozinka mora imati barem 6 znakova!";
    header("Location: registration.php");
    exit;
  }
}

// 5. Hash lozinke
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// 6. Spremanje u bazu
$sqlInsert = "INSERT INTO users 
  (name, surname, email, country, city, street, birth_date, password, username)
  VALUES 
  (:name, :surname, :email, :country, :city, :street, :birth_date, :password, :username)";
$stmtInsert = $conn->prepare($sqlInsert);
$stmtInsert->execute([
  'name'       => $ime,
  'surname'    => $prezime,
  'email'      => $email,
  'country'    => $drzava,
  'city'       => $grad,
  'street'     => $ulica,
  'birth_date' => $datum_rodjenja,
  'password'   => $hashedPassword,
  'username'   => $username
]);

// 7. Poruka korisniku s generiranom ili ručno unesenom lozinkom
$_SESSION['message'] = "Uspješna registracija! Korisničko ime: $username. "
                     . "Lozinka: $plainPassword";
header("Location: login.php");
exit;
