<?php
// Check if a session is already started, and start one if not
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session to use $_SESSION
}

require_once '../../config/Database.php'; // Adjust the path as necessary
require_once '../models/Film.php'; // Include the Film model

class FilmCrudController {
    private $conn;
    private $filmModel;

    public function __construct($db) {
        $this->conn = $db;
        $this->filmModel = new Film($db); // Instantiate the Film model
    }

    // Add Film (Admin Only)
    public function addFilm($title, $description, $release_date, $posterPath) {
        // Check if the current user is an admin
        if ($_SESSION['role'] !== 'admin') {
            echo "Access denied: only admins can add films.";
            return;
        }
    
        // Call the model's addFilm method with posterPath
        if ($this->filmModel->addFilm($title, $description, $release_date, $posterPath)) {
            echo "Film added successfully!";
        } else {
            echo "Error: Film could not be added.";
        }
    }

    // Delete Film (Admin Only)
    public function deleteFilm($filmId) {
        // Check if the current user is an admin
        if ($_SESSION['role'] !== 'admin') {
            echo "Access denied: only admins can delete films.";
            return;
        }

        // Call the model's deleteFilm method
        if ($this->filmModel->deleteFilm($filmId)) {
            header("Location: ./DisplayFilms.php");
        } else {
            echo "Error: Film could not be deleted.";
        }
    }

    // Get Films
    public function getFilms() {
        $films = $this->filmModel->getAllFilms();
        return $films;
    }
    
    // Edit film
    public function editFilm($id, $title, $description, $release_date,$posterPath) {
        if( $this->filmModel->updateFilm($id, $title, $description, $release_date,$posterPath)){
            header("Location: ./DisplayFilms.php");
        } else {
            echo "Error: Film could not be edited.";
        }
        
    }

     // Get film by ID
     public function getFilmById($id) {
        return $this->filmModel->getFilmById($id); // Call the model's method
    }
}
