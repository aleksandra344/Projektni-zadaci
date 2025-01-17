<?php
session_start();
include('functions.php');
include('dbconn.php');

// Provjera pristupa: samo admini i urednici
if (!isAdmin() && !isEditor()) {
    die("Nemate pravo dodavanja vijesti!");
}

// Obrada forme za dodavanje vijesti
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user']['id']; // Trenutni korisnik

    // Spremi vijest u tablicu 'news'
    $sql = "INSERT INTO news (title, content, author_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$title, $content, $author_id]);
    $news_id = $conn->lastInsertId();

    // Obrada slika
    if (isset($_FILES['images']['name'][0]) && !empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $imagePath = 'uploads/' . basename($_FILES['images']['name'][$key]);
            if (move_uploaded_file($tmp_name, $imagePath)) {
                $sqlImage = "INSERT INTO images (news_id, image_path) VALUES (?, ?)";
                $stmtImage = $conn->prepare($sqlImage);
                $stmtImage->execute([$news_id, $imagePath]);
            }
        }
    }

    $_SESSION['message'] = "Vijest je uspješno dodana!";
    header('Location: manage_news.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dodaj vijest</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        body {
            background: #eeeec3;
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

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="news-container">
        <h1>Add news</h1>

        <!-- Prikaz poruke o uspjehu -->
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p class='success-message'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        ?>

        <!-- Forma za dodavanje vijesti -->
        <form action="add_news.php" method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" placeholder="Type new's title" required>

            <label for="content">Content:</label>
            <textarea id="content" name="content" placeholder="Type new's content" required></textarea>

            <label for="images">Insert images:</label>
            <input type="file" id="images" name="images[]" multiple accept="image/*">

            <button type="submit">Add news</button>
        </form>

        <div class="back-link">
            <a href="manage_news.php">Back</a>
        </div>
    </div>
</body>
</html>
