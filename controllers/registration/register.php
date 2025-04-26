<?php


 require 'Database.php';

$errors = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';


    //Validate form data
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

    // Check if email already exists in the database
    $user = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $user->bindParam(':email', $email);
    $user->execute();
    $count = $user->fetchColumn();

    if ($count > 0) {
        $errors['email'] = 'Email already exists. Please use a different email or login.';
    }


    // If no errors, insert user into database
    if (empty($errors)) {

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL and bind parameters
        $user = $conn->prepare("INSERT INTO users ( email, password) 
                               VALUES (:email, :password)");

        $user->bindParam(':email', $email);
        $user->bindParam(':password', $hashed_password);

        // Execute the query
        $user->execute();

        #mark the user as logged in
        $_SESSION['user'] = [
            'email' => $email,
        ];

        // Redirect to login page with success message
        header("Location: /");
        exit();
    }
}

require 'views/registration/register.view.php';
