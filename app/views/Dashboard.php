<?php
session_start();

// Check if user is logged in and has admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not an admin
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #007bff;
            padding: 15px;
            text-align: center;
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

        .navbar .title {
            color: white;
            font-size: 24px; /* Larger font for title */
            margin: 0; /* Remove margin */
            display: inline-block; /* Keep title inline with other items */
        }

        .navbar .subtitle {
            color: #e0e0e0; /* Lighter color for subtitle */
            font-size: 14px; /* Smaller font size for subtitle */
            margin-left: 5px; /* Space to the left of the subtitle */
            display: inline-block; /* Keep subtitle inline with title */
        }

        .container {
            padding: 20px;
            text-align: center;
        }

        .card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin: 20px;
            display: inline-block;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 200px;
        }

        .card h3 {
            margin: 0 0 10px;
            color: #007bff;
        }

        .card a {
            display: inline-block;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .card a:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        /* New style for the index button */
        .index-button {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .index-button:hover {
            background-color: #218838; /* Darker green on hover */
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <span class="title">RetroFlix</span>
    <span class="subtitle">admin interface</span>
    <a href="DisplayUsers.php">Display Users</a>
    <a href="DisplayFilms.php">Display Films</a>
    <a href="AddUser.php">Add User</a>
    <a href="AddFilm.php">Add Film</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Dashboard Container -->
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> to the Admin Dashboard</h2> <!-- Display logged-in user's name -->
    
    <!-- Admin cards -->
    <div class="card">
        <h3>User Management</h3>
        <a href="DisplayUsers.php">Manage Users</a>
    </div>
    <div class="card">
        <h3>Film Management</h3>
        <a href="DisplayFilms.php">Manage Films</a>
    </div>
    <div class="card">
        <h3>Add User</h3>
        <a href="AddUser.php">Add User</a>
    </div>
    <div class="card">
        <h3>Add Film</h3>
        <a href="AddFilm.php">Add Film</a>
    </div>

    <!-- Button to redirect to index.php -->
    <a href="../../index.php" class="index-button">Go to Home</a>
</div>

</body>
</html>
