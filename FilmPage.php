<?php
require_once './app/controllers/PublicFilmController.php';
require_once './config/Database.php';

// Start the session if not already started
session_start();

// Assuming you get the film ID from the URL (e.g., FilmPage.php?id=1)
$filmId = $_GET['id'] ?? null;

if (!$filmId) {
    echo "<p>Film not found.</p>";
    exit;
}

// Instantiate the Database and get a connection
$database = new Database();
$db = $database->connect();

// Instantiate the controller
$publicFilmController = new PublicFilmController($db);

// Get film details
$film = $publicFilmController->getFilmById($filmId); // You'll need to implement this method
//$reviews = $publicFilmController->getFilmReviews($filmId); // You'll need to implement this method

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($film['title']); ?> - Film Details</title>
    <style>
        /* CSS Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .film-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .film-header img {
            width: 100%;
            max-width: 300px; /* Adjust size as needed */
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .film-title {
            font-size: 28px;
            margin: 15px 0;
            color: #333;
        }

        .film-description, .film-release-date {
            font-size: 18px;
            color: #666;
            margin: 10px 0;
            line-height: 1.5;
        }

        .play-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .play-button:hover {
            background-color: #0056b3;
        }

        .reviews-section {
            margin-top: 40px;
        }

        .reviews-section h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .review {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .review strong {
            color: #007bff;
        }

        .review-form {
            margin-top: 20px;
        }

        .review-form textarea {
            width: 100%;
            height: 120px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .review-form textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        .review-form button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .review-form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="film-header">
        <img src="../../img/<?php echo htmlspecialchars($film['poster']); ?>" alt="<?php echo htmlspecialchars($film['title']); ?>">
        <h1 class="film-title"><?php echo htmlspecialchars($film['title']); ?></h1>
        <p class="film-description"><?php echo htmlspecialchars($film['description']); ?></p>
        <p class="film-release-date"><strong>Release Date:</strong> <?php echo htmlspecialchars($film['release_date']); ?></p>
        <a href="#" class="play-button">Play</a> <!-- Link to play the film -->
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <h2>User Reviews</h2>
        <!-- Assuming you fetch reviews from the database -->
        <?php // foreach ($reviews as $review): ?>
            <div class="review">
                <strong>User 1</strong>: Great movie! <br>
                <em>Rating: 4/5</em>
            </div>
        <?php // endforeach; ?>

        <div class="review-form">
            <h3>Submit Your Review</h3>
            <form action="submit_review.php" method="post"> <!-- Point to a review submission handler -->
                <textarea name="review" placeholder="Write your review here..."></textarea>
                <button type="submit">Submit Review</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
