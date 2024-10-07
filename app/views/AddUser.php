<?php
require_once '../../config/Database.php';
require_once '../controllers/UserCrudController.php';

// Initialize an error message variable
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Admin or leave blank

    // Instantiate the Database and get a connection
    $database = new Database();
    $db = $database->connect();

    // Instantiate the UserCrudController with the database connection
    $userCrudController = new UserCrudController($db);

    // Call the addUser method with the form data
    $result = $userCrudController->addUser($name, $email, $password, $role);
    
    // Check if the result is an error message, otherwise handle success
    if (is_string($result)) {
        $errorMessage = $result; // Store the error message
    } else {
        header("Location: ./DisplayUsers.php"); // Redirect on success
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
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
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #218838;
        }
        .role-hint {
            font-size: 12px;
            color: #888;
            margin: 0 0 10px;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Admin Dashboard Link -->
    <div class="navbar">
        <a href="Dashboard.php">Back to Admin Dashboard</a>
    </div>

    <h2>Add User</h2>
    <div class="form-container">
        <form method="POST" action="">
            <div class="error-message">
                <?php if (isset($errorMessage)) echo $errorMessage; ?>
            </div>
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="role" placeholder="Role (admin or leave blank)" >
            <button type="submit" name="add_user">Add User</button>
        </form>
    </div>
</body>
</html>
