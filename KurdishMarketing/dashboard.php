<?php
session_start();
require_once 'backend/config.php';
require_once 'backend/auth.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ensure role is set
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'buyer'; // Default role
}

// Fetch user products if seller
$products = [];
if ($_SESSION['role'] === 'seller') {
    try {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE seller_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - Kurdish Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-800 to-gray-600 min-h-screen text-white">
    <!-- Page Wrapper -->
    <div class="w-full max-w-4xl mx-auto p-8 space-y-6 bg-opacity-90 bg-gray-900 backdrop-blur-lg rounded-3xl shadow-xl">
        <!-- Navbar -->
        <?php include_once 'partials/navbar.php'; ?>

        <!-- Dashboard Content -->
        <main class="space-y-8">
            <h1 class="text-3xl font-semibold text-center">Dashboard</h1>

            <!-- User Info -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-xl font-semibold text-center mb-2">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>
                <p class="text-center">Account Type: <?= ucfirst($_SESSION['role']) ?></p>
            </div>

            <!-- Seller Specific Section -->
            <?php if ($_SESSION['role'] === 'seller'): ?>
                <div class="flex justify-center mb-8">
                    <a href="upload_product.php" class="w-full max-w-xs bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-lg shadow-lg transform hover:scale-105 transition duration-300 text-center">
                        Upload New Product
                    </a>
                </div>

                <h2 class="text-2xl font-semibold mb-4">Your Products</h2>
                <?php if (!empty($products)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                        <?php foreach ($products as $product): ?>
                            <div class="bg-gray-800 p-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
                                <img src="<?= htmlspecialchars($product['image_path'] ?? 'assets/images/default.png') ?>" alt="Product Image" class="w-full h-48 object-cover rounded-lg mb-4">
                                <h3 class="font-semibold text-lg"><?= htmlspecialchars($product['title']) ?></h3>
                                <p class="text-lg text-blue-500"><?= number_format($product['price'], 2) ?> IQD</p>
                                <div class="mt-4 flex space-x-4">
                                    <a href="product_details.php?id=<?= $product['id'] ?>" class="text-blue-400 hover:text-blue-600 transform transition duration-300">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="#" class="text-red-400 hover:text-red-600 transform transition duration-300">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center text-gray-400">No products found.</p>
                <?php endif; ?>
            <?php endif; ?>
        </main>

        <!-- Footer -->
        <?php include_once 'partials/footer.php'; ?>
    </div>
</body>
</html>