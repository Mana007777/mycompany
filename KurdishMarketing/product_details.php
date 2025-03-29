<?php
session_start();
require_once 'backend/config.php';
require_once 'backend/product.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$product_id = (int)$_GET['id'];
$product = getProductById($product_id);

// Redirect if product not found
if (!$product) {
    header("Location: index.php");
    exit;
}

// Fetch seller info
$seller_stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$seller_stmt->execute([$product['seller_id']]);
$seller = $seller_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['title']) ?> | Kurdish Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 to-gray-700 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-4xl p-8 space-y-6 bg-gray-800 bg-opacity-90 backdrop-blur-md rounded-2xl shadow-lg">
        <h2 class="text-3xl font-semibold text-gray-100 text-center"><?= htmlspecialchars($product['title']) ?></h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div>
                <img src="<?= htmlspecialchars($product['image_path'] ?? 'assets/images/default.png') ?>" 
                     alt="<?= htmlspecialchars($product['title']) ?>" 
                     class="w-full h-80 object-cover rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
            </div>

            <!-- Product Details -->
            <div class="text-gray-300">
                <p class="text-lg">Category: <span class="text-blue-400"><?= ucfirst($product['category']) ?></span></p>
                <p class="text-2xl font-bold text-blue-500"><?= number_format($product['price'], 2) ?> IQD</p>

                <div class="mt-4">
                    <h3 class="text-lg font-semibold text-gray-200">Description</h3>
                    <p class="text-gray-300"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                </div>
                
                <!-- Seller Info -->
                <div class="border-t border-gray-600 mt-4 pt-4">
                    <h3 class="text-lg font-semibold text-gray-200">Seller Information</h3>
                    <p>Name: <span class="text-blue-400"><?= htmlspecialchars($seller['username']) ?></span></p>
                    <p>Contact: <span class="text-blue-400"><?= htmlspecialchars($seller['email']) ?></span></p>

                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] !== $product['seller_id']): ?>
                        <a href="chat.php?seller_id=<?= $product['seller_id'] ?>&product_id=<?= $product['id'] ?>" 
                           class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transform hover:scale-105 transition duration-300">
                            Contact Seller
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Add to Cart Button -->
                <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] === 'buyer'): ?>
                    <form method="POST" action="backend/cart_handler.php" class="mt-6">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" 
                                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transform hover:scale-105 transition duration-300">
                            Add to Cart
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
