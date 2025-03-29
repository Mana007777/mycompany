<?php
session_start();
require_once 'backend/config.php';
require_once 'backend/search_handler.php';

// Get search query from URL
$search_query = $_GET['q'] ?? '';
$category = $_GET['category'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products - Kurdish Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
    <style>
        /* DeepSeek Inspired Styling */
        .bg-gradient {
            background: linear-gradient(135deg, #1f2937, #2d3748); /* Gray Gradient from 900 to 700 */
        }
        .btn-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            background-color: #3b82f6; /* Blue accent */
            transition: all 0.3s ease-in-out;
        }
        .card-hover:hover {
            transform: scale(1.03);
            transition: all 0.3s ease-in-out;
        }
        .card-shadow {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
        }
        .input-style {
            border: 2px solid #2d3748;
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
            width: 100%;
            outline: none;
            background-color: #2d3748;
            color: #e2e8f0;
            transition: all 0.3s ease-in-out;
        }
        .input-style:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 8px rgba(59, 130, 246, 0.4);
        }
        .input-style:hover {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #1e40af;
        }
        .bg-dark-card {
            background-color: #2d3748;
            color: #e2e8f0;
        }
        .text-primary {
            color: #3b82f6; /* Blue accent for text */
        }

        /* Custom price buttons */
        .price-btn {
            background-color: #2d3748;
            color: #e2e8f0;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .price-btn:hover {
            background-color: #3b82f6;
            color: white;
        }

        /* Custom Dropdown */
        .custom-dropdown {
            position: relative;
            width: 100%;
            border: 2px solid #2d3748;
            background-color: #2d3748;
            color: #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
        }

        .custom-dropdown:hover {
            background-color: #3b82f6;
            color: white;
        }

        .custom-dropdown:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 8px rgba(59, 130, 246, 0.4);
        }

        .custom-dropdown option {
            background-color: #2d3748;
        }
    </style>
</head>
<body class="bg-gradient min-h-screen">

    <!-- Navigation (Same as index.php) -->
    <?php include_once 'partials/navbar.php'; ?>

    <main class="container mx-auto px-4 py-8">

        <!-- Search Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-white mb-6">Find the Best Products</h1>
            
            <!-- Search Form -->
            <form action="search.php" method="get" class="bg-dark-card p-6 rounded-lg shadow-lg max-w-4xl mx-auto space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Search Input -->
                    <div>
                        <label class="block text-gray-300 mb-2">Search</label>
                        <input type="text" name="q" value="<?= htmlspecialchars($search_query) ?>" 
                               class="input-style" placeholder="Search for a product...">
                    </div>
                    
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-gray-300 mb-2">Category</label>
                        <select name="category" class="custom-dropdown">
                            <option value="">All Categories</option>
                            <option value="clothing" <?= $category === 'clothing' ? 'selected' : '' ?>>Clothing</option>
                            <option value="electronics" <?= $category === 'electronics' ? 'selected' : '' ?>>Electronics</option>
                            <option value="home" <?= $category === 'home' ? 'selected' : '' ?>>Home Goods</option>
                        </select>
                    </div>
                    
                    <!-- Price Range -->
                    <div>
                        <label class="block text-gray-300 mb-2">Min Price (IQD)</label>
                        <div class="flex items-center space-x-2">
                            <button type="button" class="price-btn" id="min-price-decrease">-</button>
                            <input type="number" name="min_price" value="<?= htmlspecialchars($min_price) ?>" 
                                   id="min-price" class="input-style" placeholder="0">
                            <button type="button" class="price-btn" id="min-price-increase">+</button>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-300 mb-2">Max Price (IQD)</label>
                        <div class="flex items-center space-x-2">
                            <button type="button" class="price-btn" id="max-price-decrease">-</button>
                            <input type="number" name="max_price" value="<?= htmlspecialchars($max_price) ?>" 
                                   id="max-price" class="input-style" placeholder="100000">
                            <button type="button" class="price-btn" id="max-price-increase">+</button>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="mt-6 bg-blue-600 text-white py-3 px-8 rounded-full shadow-md hover:bg-blue-700 btn-hover w-full">
                    Search
                </button>
            </form>
        </div>

        <!-- Search Results -->
        <section class="mt-12">
            <h2 class="text-2xl font-semibold text-gray-300 mb-6">Search Results</h2>
            
            <?php if(isset($search_results) && count($search_results) > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <?php foreach($search_results as $product): ?>
                        <!-- Product Card -->
                        <div class="bg-dark-card rounded-lg shadow-xl overflow-hidden transform card-hover card-shadow">
                            <img src="<?= htmlspecialchars($product['image_path'] ?? 'assets/images/default.png') ?>" 
                                 alt="<?= htmlspecialchars($product['title']) ?>" 
                                 class="w-full h-56 object-cover">

                            <div class="p-6">
                                <h3 class="font-semibold text-xl text-gray-100 mb-2"><?= htmlspecialchars($product['title']) ?></h3>
                                <p class="text-gray-300 mb-4"><?= htmlspecialchars($product['category']) ?></p>
                                <p class="text-primary font-bold"><?= number_format($product['price'], 2) ?> IQD</p>

                                <a href="product_details.php?id=<?= $product['id'] ?>" 
                                   class="mt-4 inline-block bg-blue-600 text-white py-2 px-6 rounded-full shadow-md hover:bg-blue-700 btn-hover">
                                    View Details
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-dark-card p-8 rounded-lg shadow-lg text-center">
                    <p class="text-gray-100 text-lg">No products found matching your search.</p>
                    <a href="index.php" class="mt-4 inline-block text-blue-600 hover:underline">Browse all products</a>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Footer -->
    <?php include_once 'partials/footer.php'; ?>

    <script>
        // JavaScript to handle + and - functionality for price inputs
        document.getElementById('min-price-increase').addEventListener('click', function() {
            var minPrice = document.getElementById('min-price');
            minPrice.value = parseInt(minPrice.value || 0) + 1000; // Increase by 1000 IQD
        });

        document.getElementById('min-price-decrease').addEventListener('click', function() {
            var minPrice = document.getElementById('min-price');
            minPrice.value = Math.max(0, parseInt(minPrice.value || 0) - 1000); // Decrease by 1000 IQD, but no negative values
        });

        document.getElementById('max-price-increase').addEventListener('click', function() {
            var maxPrice = document.getElementById('max-price');
            maxPrice.value = parseInt(maxPrice.value || 0) + 1000; // Increase by 1000 IQD
        });

        document.getElementById('max-price-decrease').addEventListener('click', function() {
            var maxPrice = document.getElementById('max-price');
            maxPrice.value = Math.max(0, parseInt(maxPrice.value || 0) - 1000); // Decrease by 1000 IQD, but no negative values
        });
    </script>
</body>
</html>
