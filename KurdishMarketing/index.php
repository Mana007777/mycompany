<?php
session_start();
require_once 'backend/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurdish Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Styling for an Expert Feel */
        .btn-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-hover:hover {
            transform: scale(1.05);
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .navbar-logo {
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
            letter-spacing: 1.5px;
        }
        .bg-gradient {
            background: linear-gradient(135deg, #1E3A8A, #1D4ED8);
        }
        .shadow-lg-custom {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        /* Sticky Navbar */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 10;
            background: rgba(0, 0, 0, 0.7); /* Dark background for visibility */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 to-gray-700 min-h-screen">

    <!-- Navigation Bar -->
    <nav class="navbar text-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-4xl font-bold text-gray-100 hover:text-blue-400 transition duration-300 transform hover:scale-110 navbar-logo">Kurdish Market</a>
            <div class="flex items-center space-x-6">
                <a href="index.php" class="text-gray-300 hover:text-blue-400 transition duration-300 transform hover:scale-105">Home</a>
                <a href="search.php" class="text-gray-300 hover:text-blue-400 transition duration-300 transform hover:scale-105">Search</a>

                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="text-gray-300 hover:text-blue-400 transition duration-300 transform hover:scale-105">Dashboard</a>
                    <a href="logout.php" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700 transition duration-300 transform hover:scale-105">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-gray-300 hover:text-blue-400 transition duration-300 transform hover:scale-105">Login</a>
                    <a href="register.php" class="bg-green-600 px-4 py-2 rounded hover:bg-green-700 transition duration-300 transform hover:scale-105">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <h1 class="text-5xl font-semibold text-gray-100 mb-8 text-center">Discover the Best Products</h1>
        
        <!-- Product Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            // Mock Data for Products
            $products = [
                ['id' => 1, 'title' => 'Gaming Laptop', 'category' => 'Electronics', 'price' => 120000, 'image' => 'https://via.placeholder.com/300x200.png?text=Gaming+Laptop'],
                ['id' => 2, 'title' => 'Smartphone', 'category' => 'Electronics', 'price' => 80000, 'image' => 'https://via.placeholder.com/300x200.png?text=Smartphone'],
                ['id' => 3, 'title' => 'Office Chair', 'category' => 'Furniture', 'price' => 35000, 'image' => 'https://via.placeholder.com/300x200.png?text=Office+Chair'],
                ['id' => 4, 'title' => 'Running Shoes', 'category' => 'Fashion', 'price' => 25000, 'image' => 'https://via.placeholder.com/300x200.png?text=Running+Shoes'],
                ['id' => 5, 'title' => 'Bluetooth Headphones', 'category' => 'Electronics', 'price' => 15000, 'image' => 'https://via.placeholder.com/300x200.png?text=Headphones'],
                ['id' => 6, 'title' => 'Electric Guitar', 'category' => 'Music', 'price' => 90000, 'image' => 'https://via.placeholder.com/300x200.png?text=Electric+Guitar'],
                ['id' => 7, 'title' => 'Mountain Bike', 'category' => 'Sports', 'price' => 50000, 'image' => 'https://via.placeholder.com/300x200.png?text=Mountain+Bike'],
                ['id' => 8, 'title' => 'Coffee Maker', 'category' => 'Home Appliances', 'price' => 20000, 'image' => 'https://via.placeholder.com/300x200.png?text=Coffee+Maker'],
            ];

            // Loop through the products and display them
            foreach($products as $product):
            ?>
                <div class="bg-gray-800 rounded-lg shadow-lg-custom overflow-hidden transform transition duration-300 hover:scale-105 card-hover">
                    <img src="<?= htmlspecialchars($product['image']) ?>" 
                         alt="<?= htmlspecialchars($product['title']) ?>" 
                         class="w-full h-64 object-cover transition duration-300 transform hover:scale-110">

                    <div class="p-6">
                        <h3 class="font-semibold text-xl mb-2 text-gray-100 card-header"><?= htmlspecialchars($product['title']) ?></h3>
                        <p class="text-gray-300 mb-4"><?= htmlspecialchars($product['category']) ?></p>
                        <p class="text-blue-400 font-bold"><?= number_format($product['price'], 2) ?> IQD</p>
                        
                        <a href="product_details.php?id=<?= $product['id'] ?>" 
                           class="mt-6 inline-block bg-blue-600 text-white py-2 px-6 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 transform hover:scale-110">
                            View Details
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; <?= date('Y') ?> Kurdish Marketplace. All rights reserved.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="assets/js/script.js"></script>
</body>
</html>
