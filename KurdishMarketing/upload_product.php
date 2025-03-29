<?php
session_start();
require_once 'backend/config.php';
require_once 'backend/product.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $category = $_POST['category'];
    
    if(uploadProduct($_SESSION['user_id'], $title, $description, $price, $category, $_FILES['image'])) {
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
    <title>Upload New Product - Kurdish Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-600 to-blue-800 min-h-screen flex items-center justify-center">

    <!-- Page Wrapper -->
    <div class="w-full max-w-2xl p-8 space-y-8 bg-gray-900 bg-opacity-90 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl">

        <!-- Title -->
        <h2 class="text-3xl font-semibold text-white text-center mb-6">
            Upload Your Product
        </h2>

        <!-- Form Card -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-md">
            <form method="POST" enctype="multipart/form-data">

                <!-- Product Title -->
                <div class="mb-6">
                    <label class="block text-gray-300 text-lg mb-2 font-medium">Product Title</label>
                    <input type="text" name="title" required class="w-full p-4 bg-gray-700 text-white rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-gray-300 text-lg mb-2 font-medium">Description</label>
                    <textarea name="description" rows="4" required class="w-full p-4 bg-gray-700 text-white rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <!-- Price & Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-300 text-lg mb-2 font-medium">Price (IQD)</label>
                        <input type="number" step="0.01" name="price" required class="w-full p-4 bg-gray-700 text-white rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-300 text-lg mb-2 font-medium">Category</label>
                        <select name="category" required class="w-full p-4 bg-gray-700 text-white rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="clothing">Clothing</option>
                            <option value="electronics">Electronics</option>
                            <option value="home">Home Goods</option>
                            <option value="beauty">Beauty</option>
                            <option value="sports">Sports</option>
                            <option value="toys">Toys</option>
                            <option value="automotive">Automotive</option>
                            <option value="books">Books</option>
                            <option value="health">Health</option>
                            <option value="furniture">Furniture</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <!-- Cool Image Upload with Drag-and-Drop -->
                <div class="mb-6">
                    <label class="block text-gray-300 text-lg mb-2 font-medium">Product Image</label>
                    <div class="border-4 border-dashed border-gray-500 p-6 rounded-lg text-center relative">
                        <input type="file" name="image" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="flex flex-col justify-center items-center space-y-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-10 h-10 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l4-4 4 4M12 12V4m0 0L9 7l3 3z"></path>
                            </svg>
                            <p class="text-gray-400">Drag & Drop your image here or click to select a file</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-blue-600 text-white py-3 rounded-lg hover:bg-gradient-to-r hover:from-indigo-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    Upload Product
                </button>
            </form>
        </div>

    </div>

</body>
</html>
