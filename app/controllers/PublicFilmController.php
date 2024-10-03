<?php
//session_start(); // Start session to use $_SESSION

require_once './config/Database.php'; // Adjust the path as necessary
require_once './app/models/Film.php'; // Include the Film model

class PublicFilmController {
    private $conn;
    private $filmModel;

    public function __construct($db) {
        $this->conn = $db;
        $this->filmModel = new Film($db); // Instantiate the Film model
    }


 

    public function getFilmById($id) {
        $query = "SELECT title, description, release_date, poster FROM films WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    

        // Get Films
        public function getFilms() {
        // Check if the current user is an admi
        $films = $this->filmModel->getAllFilms();
        return $films;
        }
    

    
}
