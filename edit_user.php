<?php
session_start();
include('functions.php');
include('dbconn.php');

// Provjeri je li korisnik administrator
if (!isAdmin()) {
    die("Nemate pravo pristupa ovoj stranici!");
}

// Dohvat korisnika za uređivanje
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Korisnik ne postoji.");
    }
}

// Ako je forma poslana
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $sql = "UPDATE users SET role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$role, $id]);

    $_SESSION['message'] = "Uloga uspješno promijenjena.";
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uredi korisnika</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        /* Kontejner */
        .edit-container {
            width: 90%;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Naslov */
        .edit-header h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        /* Forma */
        form {
            max-width: 400px;
            margin: 0 auto;
        }

        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        form select {
            width: 100%;
            height: 40px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Gumb Spremi */
        form button {
            width: 100%;
            padding: 10px;
            background: #eeeec3; /* Bež boja */
            color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        form button:hover {
            background: #d6d6a8; /* Tamnija nijansa bež */
        }

        /* Povratak na administraciju */
        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #000; /* Crna boja */
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
            color: #555; /* Tamnosiva boja pri hoveru */
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <div class="edit-header">
            <h1>User: <?php echo htmlspecialchars($user['name'] . ' ' . $user['surname']); ?></h1>
        </div>
        <form action="" method="POST">
            <label for="role">Role:</label>
            <select name="role" id="role">
                <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>User</option>
                <option value="editor" <?php if ($user['role'] === 'editor') echo 'selected'; ?>>Editor</option>
                <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Administrator</option>
            </select>
            <button type="submit">Save</button>
        </form>
        <div class="back-link">
            <a href="admin.php">Back to administration</a>
        </div>
    </div>
</body>
</html>
