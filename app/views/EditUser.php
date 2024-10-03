<?php
require_once '../../config/Database.php';
require_once '../controllers/UserCrudController.php';

// Check if the request method is POST and if an ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    // Retrieve form data
    $id = $_GET['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Instantiate the Database and get a connection
    $database = new Database();
    $db = $database->connect(); // This is your MySQLi connection
    
    // Instantiate the controller
    $userCrudController = new UserCrudController($db);

    // Call the editUser method with the form data
    $userCrudController->editUser($id, $name, $email, $role);
}

// If an ID is provided, fetch user data to populate the form
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $database = new Database();
    $db = $database->connect();
    $userCrudController = new UserCrudController($db);
    $userData = $userCrudController->getUserById($id);
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
        text-align: center;
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

    input[type="text"],
    input[type="email"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    button {
        background-color: #007bff; /* Blue color */
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        width: 100%; /* Full width for the button */
    }

    button:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }

    .error-message {
        color: red;
        margin-bottom: 10px;
    }
</style>

<!-- Edit User Form -->
<div class="form-container">
    <h2>Edit User</h2>
    <form method="POST" action="">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter Name" value="<?php echo htmlspecialchars($userData['name'] ?? ''); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter Email" value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>" required>
        
        <label for="role">Role:</label>
        <input type="text" id="role" name="role" placeholder="Role (admin or leave blank)" value="<?php echo htmlspecialchars($userData['role'] ?? ''); ?>" >
        
        <button type="submit" name="editUser">Edit User</button>
    </form>
</div>
