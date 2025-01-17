<?php
session_start();
include('functions.php');

// Provjera je li korisnik administrator
if (!isAdmin()) {
    die("Nemate pravo pristupa ovoj stranici!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        /* Glavni kontejner */
        .admin-container {
            width: 90%;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Naslov stranice */
        .admin-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .admin-header h1 {
            font-size: 28px;
            color: #333;
        }

        /* Navigacija */
        nav ul {
            list-style-type: none;
            display: flex;
            justify-content: center;
            padding: 0;
            margin-bottom: 20px;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            font-size: 14px;
        }

        nav ul li a:hover {
            color: #555;
            text-decoration: underline;
        }

        /* Tablica korisnika */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 12px;
        }

        table th {
            background-color: #eeeec3;
            color: #333;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .action-links a {
            text-decoration: none;
            color: #000; /* Crna boja za linkove */
            margin-right: 10px;
            transition: color 0.3s ease; /* Animacija za promjenu boje */
        }

        .action-links a:hover {
            color: #555; /* Siva boja pri hoveru */
        }
    </style>
</head>
<body>
    <!-- Glavni omot -->
    <div class="admin-container">

        <!-- Naslov i navigacija -->
        <div class="admin-header">
            <h1>ADMINISTRATION</h1>
            <nav>
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="logout.php">LOG OUT</a></li>
                </ul>
            </nav>
        </div>

        <!-- Tablica korisnika -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>SURNAME</th>
                    <th>E-MAIL</th>
                    <th>ROLE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('dbconn.php');
                $sql = "SELECT id, name, surname, email, role FROM users";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($users) {
                    foreach ($users as $user) {
                        echo "<tr>
                            <td>{$user['id']}</td>
                            <td>{$user['name']}</td>
                            <td>{$user['surname']}</td>
                            <td>{$user['email']}</td>
                            <td>{$user['role']}</td>
                            <td class='action-links'>
                                <a href='edit_user.php?id={$user['id']}'>Edit</a>
                                <a href='delete_user.php?id={$user['id']}' onclick='return confirmDelete()'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nema korisnika za prikaz.</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>

    <!-- JavaScript za potvrdu brisanja -->
    <script>
        function confirmDelete() {
            return confirm("Jeste li sigurni da želite obrisati ovog korisnika?");
        }
    </script>
</body>
</html>
