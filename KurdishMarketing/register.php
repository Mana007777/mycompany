<?php
session_start();
require_once 'backend/config.php';


if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'] ?? 'buyer';

    // Call the registerUser function from your backend (you might need to define this function)
    if (registerUser($username, $email, $password, $role)) {
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Kurdish Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 to-gray-700 min-h-screen flex items-center justify-center">

    <!-- Registration Form -->
    <div class="w-full max-w-md p-8 space-y-4 bg-gray-800 bg-opacity-90 backdrop-blur-md rounded-2xl shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-100 text-center">Create Account</h2>

        <!-- Registration Form -->
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-300">Username</label>
                <input type="text" name="username" required class="w-full px-4 py-2 mt-1 bg-gray-700 text-gray-300 border-none rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-300">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 mt-1 bg-gray-700 text-gray-300 border-none rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-300">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 mt-1 bg-gray-700 text-gray-300 border-none rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-300">Account Type</label>
                <select name="role" class="w-full px-4 py-2 mt-1 bg-gray-700 text-gray-300 border-none rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="buyer">Buyer</option>
                    <option value="seller">Seller</option>
                </select>
            </div>

            <button type="submit" class="w-full py-2 text-lg font-semibold text-gray-100 bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105">
                Register
            </button>
        </form>

        <p class="text-center text-gray-300 mt-2">
            Already have an account? <a href="login.php" class="text-blue-400 hover:underline">Login</a>
        </p>
    </div>

</body>
</html>
