<?php
session_start();
include('functions.php');
include('dbconn.php');

// Provjera pristupa: samo admini i urednici
if (!isAdmin() && !isEditor()) {
    die("Nemate pravo uređivati vijesti!");
}

// Dohvat vijesti za uređivanje
if (isset($_GET['id'])) {
    $news_id = $_GET['id'];
    $sql = "SELECT * FROM news WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$news_id]);
    $news = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$news) {
        die("Vijest ne postoji.");
    }
}

// Ažuriranje vijesti
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Ažuriraj vijest u tablici `news`
    $sql = "UPDATE news SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$title, $content, $news_id]);

    $_SESSION['message'] = "Vijest je uspješno ažurirana.";
    header('Location: manage_news.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uredi vijest</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        body {
            background: #eeeec3; /* Bež pozadina */
        }

        .news-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .news-container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .news-container label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .news-container input,
        .news-container textarea,
        .news-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .news-container textarea {
            height: 100px;
            resize: none;
        }

        .news-container button {
            background: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        .news-container button:hover {
            background: #555;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
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
        <h1>Uredi vijest</h1>

        <?php
        if (isset($_SESSION['message'])) {
            echo "<p style='color:green; text-align:center;'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        ?>

        <form action="edit_news.php?id=<?php echo $news_id; ?>" method="POST">
            <label for="title">Naslov:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($news['title']); ?>" required>

            <label for="content">Sadržaj:</label>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($news['content']); ?></textarea>

            <button type="submit">Spremi promjene</button>
        </form>

        <div class="back-link">
            <a href="manage_news.php">Povratak na upravljanje vijestima</a>
        </div>
    </div>
</body>
</html>
