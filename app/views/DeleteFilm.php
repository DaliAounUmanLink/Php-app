<?php
require_once '../../config/Database.php';
require_once '../controllers/FilmCrudController.php';

// Handle form submission for deleting a film
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_film'])) {
    // Retrieve form data
    $filmId = $_POST['film_id'];

    // Instantiate the Database and get a connection
    $database = new Database();
    $db = $database->connect(); // This is your MySQLi connection

    // Instantiate the FilmCrudController
    $filmCrudController = new FilmCrudController($db);

    // Call the deleteFilm method with the film ID
    $filmCrudController->deleteFilm($filmId);
}
?>

<!-- CSS Styles -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    .form-container {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: auto;
        text-align: center;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
    }

    input[type="number"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    button {
        background-color: #ff4d4d; /* Red color for delete */
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #d43f3f; /* Darker red on hover */
    }

    .error-message {
        color: red;
        margin-bottom: 10px;
    }
</style>

<!-- Delete Film Form -->
<div class="form-container">
    <h2>Confirm The ID Of The Film to Delete</h2>
    <form method="POST" action="">
        <input type="number" name="film_id" placeholder="Enter Film ID" required>
        <button type="submit" name="delete_film">Delete Film</button>
    </form>
</div>
