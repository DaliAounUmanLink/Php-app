<?php

class Film {
    private $conn;
    private $table_name = "films";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add a new film
    public function addFilm($title, $description, $release_date, $posterPath) {
        // Sanitize input
        $title = htmlspecialchars(strip_tags($title));
        $description = htmlspecialchars(strip_tags($description));
        $release_date = htmlspecialchars(strip_tags($release_date));
        $posterPath = htmlspecialchars(strip_tags($posterPath)); // Sanitize poster path
    
        // Prepare SQL statement
        $query = "INSERT INTO " . $this->table_name . " (title, description, release_date, poster) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $title, $description, $release_date, $posterPath);
    
        // Execute and return result
        return $stmt->execute();
    }
    

    // Delete Film
    public function deleteFilm($filmId) {
        // Prepare SQL statement
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $filmId);

        // Execute and return result
        return $stmt->execute();
    }


    // getallusers
    public function getAllFilms() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->query($query);

        // Fetch all films
        return $stmt->fetch_all(MYSQLI_ASSOC); // Return as an associative array
    }

    // Update film information
    public function updateFilm($id, $title, $description, $release_date,$posterPath) {
    $query = "UPDATE " . $this->table_name . " SET title = ?, description = ?, release_date = ?, poster= ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);

    // Bind parameters
    $stmt->bind_param("ssssi", $title, $description, $release_date, $posterPath,$id);

    // Execute and return result
    if ($stmt->execute()) {
        return true;
    }
    return false;
}
    public function getFilmById($id) {
    $query = "SELECT * FROM films WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id); // Bind the ID as an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the film data
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the film data as an associative array
    } else {
        return null; // Return null if no film found
    }
}


}
?>
