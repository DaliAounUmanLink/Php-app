<?php
require_once '../../config/Database.php';
require_once '../controllers/FilmCrudController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_film'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $release_date = $_POST['release_date'];

    // Handle poster upload
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $poster = $_FILES['poster'];

        // Define target directory and file name
        $targetDir = "../../img/";
        $targetFile = $targetDir . basename($poster['name']);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($poster['tmp_name'], $targetFile)) {
            $posterPath = basename($poster['name']); // Save only the file name in the database
        } else {
            echo "Error uploading the poster.";
            exit;
        }
    } else {
        echo "Please upload a valid poster.";
        exit;
    }

    // Instantiate the Database and get a connection
    $database = new Database();
    $db = $database->connect();

    // Instantiate the FilmCrudController with the database connection
    $filmCrudController = new FilmCrudController($db);

    // Call the addFilm method with the form data and poster path
    $filmCrudController->addFilm($title, $description, $release_date, $posterPath);
}
?>

<!-- Add Film Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Film</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #007bff;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            margin: 0 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .navbar a:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- Admin Dashboard Link -->
<div class="navbar">
    <a href="Dashboard.php">Back to Admin Dashboard</a>
</div>

<h2>Add New Film</h2>
<form method="POST" action="" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Film Title" required>
    <textarea name="description" placeholder="Film Description" required></textarea>
    <input type="date" name="release_date" required>
    <input type="file" name="poster" accept="image/*" required>
    <button type="submit" name="add_film">Add Film</button>
</form>

</body>
</html>
