<?php
// Check if session is not already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/UserCrudController.php';
require_once '../../config/Database.php';

if ($_SESSION['role'] !== 'admin') {
    echo "<p style='color: red; font-weight: bold;'>Access denied: only admins can view users.</p>";
    exit;
}

// Instantiate the Database and get a connection
$database = new Database();
$db = $database->connect();

// Instantiate the controller
$userCrudController = new UserCrudController($db);

// Get users
$users = $userCrudController->getUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto; /* Center the table */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Light grey for even rows */
        }
        tbody tr:hover {
            background-color: #e0e0e0; /* Slightly darker on hover */
        }
        .edit-button, .delete-button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .edit-button {
            background-color: #007bff;
            color: white;
        }
        .edit-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
        }
        .delete-button:hover {
            background-color: #c82333; /* Darker red on hover */
        }
        @media (max-width: 600px) {
            th, td {
                font-size: 14px; /* Reduce font size for small screens */
                padding: 8px; /* Reduce padding for small screens */
            }
        }
    </style>
</head>
<body>

    <!-- Admin Dashboard Link -->
    <div class="navbar">
        <a href="Dashboard.php">Back to Admin Dashboard</a>
    </div>

    <h2>Users List</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo $user['role'] ? htmlspecialchars($user['role']) : 'User'; ?></td> <!-- Display 'User' if role is null -->
                        <td>
                            <a href="EditUser.php?id=<?php echo $user['id']; ?>">Edit</a>

                            <form method="POST" action="DeleteUser.php" style="display:inline;">
                                <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
