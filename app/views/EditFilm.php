<?php
require_once '../../config/Database.php';
require_once '../controllers/FilmCrudController.php';

// Check if the request method is POST and if an ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    // Retrieve form data
    $id = $_GET['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $release_date = $_POST['release_date'];

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
    $db = $database->connect(); // MySQLi connection

    // Instantiate the controller
    $filmCrudController = new FilmCrudController($db);

    // Call the editFilm method with the form data
    if ($filmCrudController->editFilm($id, $title, $description, $release_date, $posterPath)) {
        $message = "Film edited successfully!";
    } else {
        $message = "Error: Film could not be edited.";
    }
}

// Fetch film data if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Instantiate the Database and get a connection
    $database = new Database();
    $db = $database->connect(); // MySQLi connection

    // Instantiate the controller
    $filmCrudController = new FilmCrudController($db);
    
    // Fetch the film details
    $film = $filmCrudController->getFilmById($id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Film</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            color: #d9534f; /* Bootstrap danger color */
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Film</h2>

    <?php if (isset($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Edit Film Form -->
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Film Title" value="<?php echo htmlspecialchars($film['title'] ?? ''); ?>" required>
        <textarea name="description" placeholder="Film Description" required><?php echo htmlspecialchars($film['description'] ?? ''); ?></textarea>
        <input type="date" name="release_date" value="<?php echo htmlspecialchars($film['release_date'] ?? ''); ?>" required>
        <input type="file" name="poster" accept="image/*" required>
        <button type="submit" name="editFilm">Edit Film</button>
    </form>
</div>

</body>
</html>
