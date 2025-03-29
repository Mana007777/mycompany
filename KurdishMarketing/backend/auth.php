<?php
require_once 'config.php';

/**
 * Register a new user
 */
function registerUser($username, $email, $password, $role = 'buyer') {
    global $pdo;
    
    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        return ['error' => 'All fields are required'];
    }

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return ['error' => 'Email already registered'];
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    // Insert user
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $email, $hashed_password, $role])) {
        // Auto-login after registration
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
        return ['success' => true];
    }
    
    return ['error' => 'Registration failed'];
}

/**
 * Login user
 */
function loginUser($email, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $email;
        return true;
    }
    return false;
}

/**
 * Logout user
 */
function logoutUser() {
    session_unset();
    session_destroy();
    session_start(); // Start fresh session for flash messages
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is seller
 */
function isSeller() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'seller';
}

/**
 * Get current user ID
 */
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}
?>