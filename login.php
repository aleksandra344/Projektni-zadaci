<?php
session_start();

// Ako imate poruku (npr. “Uspješno registrirani” ili greška pri loginu):
if(isset($_SESSION['message'])) {
  $msg = $_SESSION['message'];
  unset($_SESSION['message']);
} else {
  $msg = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style2.css">
  <style>
    /* Cijela pozadina bež */
    body {
      background: #eeeec3;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    /* Naslov "Login" */
    .login-title {
      text-align: center;
      margin-top: 40px;
      font-size: 32px;
      color: #333;
    }

    /* Kontejner za formu, centriran */
    .login-container {
      display: flex;
      justify-content: center;
      align-items: flex-start; /* ako želiš i vertikalno centriranje: center */
      min-height: 100vh;
      padding-top: 20px;
    }

    /* Bijela kartica za formu */
    .login-card {
      background: #fff;
      border-radius: 10px;
      padding: 25px 30px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      max-width: 400px;
      width: 90%; /* za uže ekrane */
    }

    /* Stil za p (npr. poruka), label, input */
    .login-card p {
      text-align: center;
      color: green; /* ili #333, po želji. Možeš staviti crvenu ako je greška. */
      margin-bottom: 10px;
      font-weight: 500;
    }
    .login-card label {
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
      font-weight: 500;
      color: #333;
    }
    .login-card input {
      width: 100%;
      height: 40px;
      padding: 5px 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      margin-bottom: 10px;
    }

    /* Gumb “Prijava” */
    .login-btn {
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
    .login-btn:hover {
      background: #333;
      color: #fff;
      transition: 0.4s;
    }
  </style>
</head>
<body>

<h1 class="login-title">Login</h1>

<div class="login-container">
  <div class="login-card">
    <!-- Ako postoji poruka (npr. “Uspješno ste registrirani!” ili “Pogrešna lozinka”) -->
    <?php if(!empty($msg)): ?>
      <p><?php echo $msg; ?></p>
    <?php endif; ?>

    <form action="login_action.php" method="POST">
      <label for="username">Korisničko ime:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Lozinka:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit" class="login-btn">Prijava</button>
    </form>
  </div>
</div>

</body>
</html>
