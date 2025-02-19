<?php
session_start();
include('functions.php');
include('dbconn.php');

// Provjera pristupa: samo admini i urednici
if (!isAdmin() && !isEditor()) {
    die("Nemate pravo pristupa ovoj stranici!");
}

// Dohvat svih vijesti
$sql = "SELECT id, title, created_at FROM news ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$newsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravljanje vijestima</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        body {
            background: #eeeec3;
        }

        .news-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .news-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ccc;
            text-align: left;
            padding: 10px;
        }

        table th {
            background: #eeeec3;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .action-links a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }

        .action-links a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .back-link {
            text-align: center;
        }

        .back-link a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .back-link a:hover {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="news-container">
        <h1>NEWS MANAGER</h1>

        <?php if (!empty($newsList)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITLE</th>
                        <th>DATE AND TIME</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newsList as $news): ?>
                        <tr>
                            <td><?php echo $news['id']; ?></td>
                            <td><?php echo htmlspecialchars($news['title']); ?></td>
                            <td><?php echo $news['created_at']; ?></td>
                            <td class="action-links">
                                <a href="edit_news.php?id=<?php echo $news['id']; ?>">Edit</a>
                                <a href="delete_news.php?id=<?php echo $news['id']; ?>" onclick="return confirm('Jeste li sigurni da želite obrisati ovu vijest?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: #555;">Nema vijesti za prikaz.</p>
        <?php endif; ?>

        <div class="back-link">
            <a href="add_news.php">Add another one</a>
        </div>
    </div>
</body>
</html>
