<?php
require_once '../../config/Database.php';
require_once '../models/User.php';
session_start(); 
class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db); // Pass the database connection to the User model
    }


    
    public function register($name, $email, $password) {
        // Check if the email is already registered
        if ($this->userModel->emailExists($email)) {
            // Store error message in session
            $_SESSION['error'] = "This email is already registered.";
            header("Location: ./register.php");
            exit;
        }
    
        // Call the Model's signup method to handle registration
        $result = $this->userModel->signup($name, $email, $password);
    
        if ($result) {
            header("Location: ./login.php");
        } else {
            $_SESSION['error'] = "Error: User could not be registered.";
            header("Location: ./register.php");
        }
    }
    

    public function login($email, $password) {
        // Call the Model's login method to handle authentication
        $userData= $this->userModel->login($email, $password);
    
        if ($userData) {
            // Start a session
            // Store user details in session
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['user_name'] = $userData['name'];
            $_SESSION['role'] = $userData['role'];
            $_SESSION['logged_in'] = true;
            if ($_SESSION['role']==="admin" ){
                header("Location: ./Dashboard.php");
            }
            else{
                header("Location: ../../index.php");
            }
            echo "Login successful!";
            
            
            // You can redirect the user to a different page after login
        } else {
            echo "Error: Invalid email or password.";
        }
    }
    

}
