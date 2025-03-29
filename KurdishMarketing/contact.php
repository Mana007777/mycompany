<?php
session_start();
require_once 'backend/config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    
    // Process contact form (you can add email sending here)
    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Same head as register.php -->
</head>
<body class="bg-gray-100">
    <?php include_once 'partials/navbar.php'; ?>

    <main class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6">Contact Us</h1>
            
            <?php if(isset($success) && $success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    Thank you! We'll get back to you soon.
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Your Name</label>
                    <input type="text" name="name" required 
                           class="w-full border rounded px-3 py-2">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required 
                           class="w-full border rounded px-3 py-2">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Message</label>
                    <textarea name="message" rows="5" required 
                              class="w-full border rounded px-3 py-2"></textarea>
                </div>
                
                <button type="submit" 
                        class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                    Send Message
                </button>
            </form>
        </div>
    </main>

    <?php include_once 'partials/footer.php'; ?>
</body>
</html>