<?php
session_start();
require_once '../controllers/FilmCrudController.php';
require_once '../../config/Database.php';

if ($_SESSION['role'] !== 'admin') {
    echo "<p style='color: red; font-weight: bold;'>Access denied: only admins can view films.</p>";
    exit;
}

// Instantiate the Database and get a connection
$database = new Database();
$db = $database->connect(); // This is your MySQLi connection

// Instantiate the controller
$filmCrudController = new FilmCrudController($db);

// Get films
$films = $filmCrudController->getFilms();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
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
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .film-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin: 0 auto;
            max-width: 1200px;
        }
        .film-card {
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 15px;
        }
        .film-card img {
            max-width: 100%;
            height: auto;
        }
        .film-title {
            font-size: 18px;
            color: #007bff;
            margin: 10px 0;
        }
        .film-description {
            font-size: 14px;
            color: #555;
        }
        .film-release {
            font-size: 12px;
            color: #888;
        }
        .film-id {
            font-size: 12px;
            color: #333;
            margin: 5px 0;
            font-weight: bold;
        }
        .action-buttons {
            margin-top: 10px;
        }
        button {
            padding: 8px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 0 5px;
        }
        button[type="submit"] {
            background-color: #d11a2a;
            color: white;
        }
        button[type="submit"]:hover {
            background-color: #962a1a;
        }
        .delete-button {
            background-color: #d11a2a;
        }
        .delete-button:hover {
            background-color: #962a1a;
        }
    </style>
</head>
<body>
    <!-- Admin Dashboard Link -->
    <div class="navbar">
        <a href="Dashboard.php">Back to Admin Dashboard</a>
    </div>

    <h2>Films List</h2>
    <div class="film-container">
        <?php foreach ($films as $film): ?>
            <div class="film-card">
                <img src="../../img/<?php echo $film['poster']; ?>" alt="<?php echo $film['title']; ?>">
                <h3 class="film-title"><?php echo $film['title']; ?></h3>
                <p class="film-id">Film ID: <?php echo $film['id']; ?></p> <!-- Display Film ID -->
                <p class="film-description"><?php echo $film['description']; ?></p>
                <p class="film-release">Release Date: <?php echo $film['release_date']; ?></p>
                <div class="action-buttons">
                    <a href="EditFilm.php?id=<?php echo $film['id']; ?>">Edit</a>
                    <form method="POST" action="DeleteFilm.php" style="display:inline;">
                        <input type="hidden" name="filmId" value="<?php echo $film['id']; ?>">
                        <button type="submit" class="delete-button">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
