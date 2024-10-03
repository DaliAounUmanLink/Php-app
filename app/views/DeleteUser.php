<?php
// Include necessary files for database connection, user management, and user model
require_once '../../config/Database.php';
require_once '../controllers/UserCrudController.php';
require_once '../models/User.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    // Retrieve form data
    $userId = $_POST['user_id'];

    // Instantiate the Database and get a connection
    $database = new Database();
    $db = $database->connect();

    // Instantiate the UserCrudController with the database connection
    $userCrudController = new UserCrudController($db);

    // Call the deleteUser method with the user ID
    $userCrudController->deleteUser($userId);
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

    h2 {
        color: #333;
    }

    .form-container {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: auto;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    button {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #218838;
    }

    .error-message {
        color: red;
        margin-bottom: 10px;
    }
</style>

<!-- Delete User Form -->
<div class="form-container">
    <h2>Confirm The ID Of The User To Delete </h2>
    <form method="POST" action="">
        <label for="user_id">User ID:</label>
        <input type="number" id="user_id" name="user_id" placeholder="Enter User ID" required>

        <button type="submit" name="delete_user">Delete User</button>
    </form>
</div>
