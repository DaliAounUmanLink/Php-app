<?php
//changes
//changes
//change

session_start(); // Start the session to access session variables
require_once './config/Database.php';
require_once './app/controllers/PublicFilmController.php';

// Instantiate the Database and get a connection
$database = new Database();
$db = $database->connect();

// Instantiate the PublicFilmController with the database connection
$PublicFilmController = new PublicFilmController($db);

// Get films
$films = $PublicFilmController->getFilms();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RetroFlix - Film Landing Page</title>
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

        .navbar h1 {
            color: white; /* Title color */
            display: inline; /* Keep title inline */
            margin: 0; /* Remove default margins */
            padding-right: 15px; /* Space after the title */
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

        .container {
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .film-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .film-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin: 10px;
            width: 200px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s; /* Added transition */
        }

        .film-card:hover {
            transform: scale(1.05); /* Scale the card */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Increase shadow */
        }

        .film-card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .film-card h3 {
            color: #007bff;
            margin: 10px 0;
        }

        .film-card p {
            font-size: 14px;
            color: #666;
        }

        .login-link {
            float: right;
            margin-top: 15px;
        }

        .dashboard-link {
            float: left;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <h1>RetroFlix</h1>
    <a href="LandingPage.php">Home</a>
    <a href="ComingSoon.php">Coming Soon</a>
    <a href="Reviews.php">Reviews</a>
    <a href="Contact.php">Contact</a>

    <!-- Conditional rendering for login/logout based on session -->
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
        <!-- If the user is logged in -->
        <a href="/app/views/logout.php">Logout (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a>

        <!-- If the logged-in user is an admin, show the dashboard link -->
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a class="dashboard-link" href="/app/views/Dashboard.php">Admin Dashboard</a>
        <?php endif; ?>
    <?php else: ?>
        <!-- If the user is not logged in -->
        <a class="login-link" href="/app/views/login.php">Login</a>
    <?php endif; ?>
</div>

<!-- Landing Page Container -->
<div class="container">
    <h1>Welcome to RetroFlix</h1>
    <div class="film-grid">
        <?php foreach ($films as $film): ?>
        <div class="film-card">
            <img src="../../img/<?php echo $film['poster']; ?>" alt="<?php echo htmlspecialchars($film['title']); ?>">
            <h3>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <a href="FilmPage.php?id=<?php echo $film['id']; ?>">
                    <?php echo htmlspecialchars($film['title']); ?>
                </a>
            <?php else: ?>
                <a href="login.php?redirect=FilmPage.php&id=<?php echo $film['id']; ?>" 
                onclick="alert('You must log in first!'); return false;">
                    <?php echo htmlspecialchars($film['title']); ?>
                </a>
            <?php endif; ?>
            </h3>

            <p><?php echo htmlspecialchars($film['description']); ?></p>
            <p><strong>Release Date:</strong> <?php echo htmlspecialchars($film['release_date']); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Show logout message if it exists -->
<?php
if (isset($_SESSION['logout_message'])) {
    $logout_message = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']); // Clear the message after displaying
    echo "<script>alert('$logout_message');</script>";
}
?>

</body>
</html>
