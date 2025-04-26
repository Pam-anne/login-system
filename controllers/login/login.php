<?php

require 'Database.php';

$errors = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    // Validate form data
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long';
    }

    // If no validation errors, check credentials
    if (empty($errors)) {
        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        // Verify user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Set session data
            $_SESSION['user'] = [
                'email' => $user['email'],
                // You can add more user info here if needed
            ];
            
            // Redirect to home page after successful login
            header("Location: /");
            exit();
        } else {
            // Invalid credentials
            $errors['login'] = 'Invalid email or password';
        }
    }
}

// Load the login view with any errors
require 'views/login/login.view.php';