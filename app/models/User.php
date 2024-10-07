<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create user (signup)
    public function emailExists($email) {
        // Sanitize input
        $email = htmlspecialchars(strip_tags($email));
    
        // Prepare SQL statement
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
    
        // Bind parameter
        $stmt->bind_param("s", $email);
        $stmt->execute();
    
        // Check if any record exists
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return true; // Email exists
        } else {
            return false; // Email does not exist
        }
    
        // Close the statement
        $stmt->close();
    }
    
    public function signup($name, $email, $password) {
        // Sanitize input
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        // Prepare SQL statement
        $query = "INSERT INTO " . $this->table_name . " (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        // Bind parameters
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
    
        // Execute and return result
        if ($stmt->execute()) {
            return true;
        } else {
            return false; // Handle any errors internally in the model
        }
    
        // Close the statement
        $stmt->close();
    }
    
    
    // Login user
    public function login($email, $password) {
        // Sanitize input
        $email = htmlspecialchars(strip_tags($email));
        
        // Prepare SQL statement
        $query = "SELECT id, name, password,role  FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        
        // Bind parameters
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        // Check if the user exists
        if ($stmt->num_rows > 0) {
            // Bind the result to variables
            $stmt->bind_result($id, $name, $hashedPassword,$role);
            $stmt->fetch();
    
            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                // Return user details on successful login
                return [
                    'id' => $id,
                    'name' => $name,
                    'role' =>$role
                ];
            }
        }
    
        return false; // Login failed
    }

    public function addUser($name, $email, $password, $role) {
        // Sanitize input
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Prepare SQL statement
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

        // Execute and return the result
        return $stmt->execute();
    }

    // Delete User (Admin Only)
    public function deleteUser($userId) {
        // Prepare SQL statement
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);

        // Execute and return the result
        return $stmt->execute();
    }

        // User.php
    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->query($query);

        // Fetch all users
        return $stmt->fetch_all(MYSQLI_ASSOC); // Return as an associative array
    }


    
    // Update user credentials
    public function updateUser($id, $name, $email, $role) {
    $query = "UPDATE " . $this->table_name . " SET name = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);

    // Check for preparation errors
    if (!$stmt) {
        echo "Preparation failed: " . $this->conn->error;
        return false;
    }

    // Bind parameters
    $stmt->bind_param("sssi", $name, $email, $role, $id);

    // Execute and return result
    if ($stmt->execute()) {
        return true;
    } else {
        echo "Execution failed: " . $stmt->error; // Output any execution errors
    }
    return false;
}

       // Get user by ID
       public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); // Bind the ID as an integer
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Fetch the user data
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Return the user data as an associative array
        } else {
            return null; // Return null if no user found
        }
    }


}
