<?php
session_start();
include('dbconn.php'); // Mora definirati $conn

// Dohvat svih država iz tablice 'countries'
$sqlCountries = "SELECT id, country_name FROM countries";
$stmt = $conn->prepare($sqlCountries);
$stmt->execute();
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration</title>

  <!-- Tvoj glavni CSS -->
  <link rel="stylesheet" href="style2.css"> 

  <!-- Dodatni stilovi -->
  <style>
    /* Cijela pozadina bež */
    body {
      background: #eeeec3; /* ili neka druga pastelna boja, po želji */
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    /* Centriranje “Registration” naslova */
    .registration-title {
      text-align: center;
      margin-top: 40px;
      font-size: 32px; 
      color: #333; /* po želji */
    }

    /* Omot za formu da bude centralno postavljena */
    .registration-container {
      display: flex;
      justify-content: center;
      align-items: flex-start; /* ili center ako želiš i vertikalno centrirati */
      min-height: 100vh;       /* da zauzme cijelu visinu ekrana */
      padding-top: 20px;       /* malo odmaka od vrha */
    }

    /* Kartica za formu */
    .registration-card {
      background: #fff; /* bijela kartica unutar bež pozadine */
      border-radius: 10px;
      padding: 25px 30px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      max-width: 400px;      /* širina */
      width: 90%;            /* za male ekrane */
    }

    /* Stil za sve label/input parove */
    .registration-card label {
      display: block;        /* svaki label blok, da budu jedan ispod drugog */
      margin-top: 15px;
      margin-bottom: 5px;
      font-weight: 500;
      color: #333;
    }
    .registration-card input,
    .registration-card select {
      width: 100%;
      height: 40px;
      padding: 5px 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    /* Razmak ispod select/input */
    .registration-card input:not([type="radio"]),
    .registration-card select {
      margin-bottom: 10px;
    }

    /* Stil za gumb “Registriraj se” */
    .register-btn {
      margin-top: 20px;
      display: inline-block;
      padding: 12px 34px;
      font-size: 14px;
      background: transparent;
      color: #333;
      border: 1px solid #333;
      cursor: pointer;
      border-radius: 5px;
      transition: 0.4s;
    }
    .register-btn:hover {
      background: #333;
      color: #fff;
      transition: 0.4s;
    }

    /* Polje za lozinku, sakriveno JS-om */
    #manualPasswordField {
      display: none;
    }
  </style>
</head>
<body>

<!-- (1) Natpis “Registration” iznad forme, centriran -->
<h1 class="registration-title">Registration</h1>

<!-- (2) Omot za formu (kontejner) da bude centriran -->
<div class="registration-container">

  <!-- (3) Kartica za formu -->
  <div class="registration-card">
    <?php
    // Ispiši poruku greške ili uspjeha (ako postoji)
    if (isset($_SESSION['message'])) {
      echo "<p style='color:red; text-align:center;'>".$_SESSION['message']."</p>";
      unset($_SESSION['message']);
    }
    ?>

    <form action="registration_action.php" method="POST">
      <label for="ime">Ime:</label>
      <input type="text" id="ime" name="ime" required>

      <label for="prezime">Prezime:</label>
      <input type="text" id="prezime" name="prezime" required>

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required>

      <label for="drzava">Država:</label>
      <select id="drzava" name="drzava" required>
        <option value="">-- Odaberite državu --</option>
        <?php foreach($countries as $country): ?>
          <option value="<?php echo $country['id']; ?>">
            <?php echo $country['country_name']; ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label for="grad">Grad:</label>
      <input type="text" id="grad" name="grad" required>

      <label for="ulica">Ulica:</label>
      <input type="text" id="ulica" name="ulica" required>

      <label for="datum_rodjenja">Datum rođenja:</label>
      <input type="date" id="datum_rodjenja" name="datum_rodjenja" required>

      <!-- Naslov za radio gumbiće -->
      <label style="margin-top: 15px; font-weight: 500;">Odaberite način lozinke:</label>

      <!-- (4) Radio gumbi - jedan ispod drugog, manji -->
      <div style="margin-top: 10px; margin-bottom: 15px;">
        <label style="display: block; font-size: 14px; margin-bottom: 8px;">
          <input 
            type="radio" 
            name="pw_option" 
            value="auto" 
            checked 
            style="width:18px; height:18px; margin-right:5px;"
          >
          Automatski generirana lozinka
        </label>
        <label style="display: block; font-size: 14px;">
          <input 
            type="radio" 
            name="pw_option" 
            value="manual"
            style="width:18px; height:18px; margin-right:5px;"
          >
          Ja želim sam/a unijeti lozinku
        </label>
      </div>

      <!-- Polje za lozinku (inicijalno skriveno) -->
      <div id="manualPasswordField">
        <label for="lozinka" style="margin-top: 10px;">Unesite lozinku:</label>
        <input type="password" id="lozinka" name="lozinka">
      </div>

      <button type="submit" class="register-btn">Registriraj se</button>
    </form>
  </div> <!-- /registration-card -->

</div> <!-- /registration-container -->

<!-- JS za prikaz lozinke ako user odabere "manual" -->
<script>
  const radioAuto = document.querySelector('input[name="pw_option"][value="auto"]');
  const radioManual = document.querySelector('input[name="pw_option"][value="manual"]');
  const manualPasswordField = document.getElementById('manualPasswordField');

  function togglePasswordField() {
    if (radioManual.checked) {
      manualPasswordField.style.display = 'block';
    } else {
      manualPasswordField.style.display = 'none';
    }
  }
  // Poziv na početku i na event change
  togglePasswordField();
  if (radioAuto)  radioAuto.addEventListener('change', togglePasswordField);
  if (radioManual) radioManual.addEventListener('change', togglePasswordField);
</script>

</body>
</html>
