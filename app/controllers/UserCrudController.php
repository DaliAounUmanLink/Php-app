<?php
require_once '../../config/Database.php';
require_once '../models/User.php';

// Check if session is not already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class UserCrudController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db); // Pass the database connection to the User model
    }

    public function addUser($name, $email, $password, $role) {
        // Check if the current user is an admin
        if ($_SESSION['role'] !== 'admin') {
            echo "Access denied: only admins can add users.";
            return;
        }

        if ($this->userModel->addUser($name, $email, $password, $role)) {
            header("Location: ./DisplayUsers.php");
        } else {
            echo "Error: User could not be added.";
        }
    }

    public function deleteUser($userId) {
        // Check if the current user is an admin
        if ($_SESSION['role'] !== 'admin') {
            echo "Access denied: only admins can delete users.";
            return;
        }

        if ($this->userModel->deleteUser($userId)) {
            header("Location: ./DisplayUsers.php");
        } else {
            echo "Error: User could not be deleted.";
        }
    }

    public function getUsers() {
        // Check if the current user is an admin
        if ($_SESSION['role'] !== 'admin') {
            echo "Access denied: only admins can view users.";
            return;
        }

        return $this->userModel->getAllUsers();
    }

    public function editUser($id, $name, $email, $role) {
        if ($_SESSION['role'] !== 'admin') {
            echo "Access denied: only admins can edit users.";
            return;
        }

        if ($this->userModel->updateUser($id, $name, $email, $role)) {
            header("Location: ./DisplayUsers.php");
        } else {
            echo "Error: User could not be edited.";
        }
    }
        // Get user by ID
        public function getUserById($id) {
            return $this->userModel->getUserById($id); // Call the model's method
        }
}
?>
