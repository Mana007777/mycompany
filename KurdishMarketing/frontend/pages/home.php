<?php 
$page_title = "Kurdish Marketplace - Home";
require_once '../partials/header.php';
?>

<!-- Hero Section -->
<section class="bg-blue-600 text-white py-16 mb-12">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Welcome to Kurdish Marketplace</h1>
        <p class="text-xl mb-8">Buy and sell authentic Kurdish products</p>
        <a href="search.php" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100">
            Browse Products
        </a>
    </div>
</section>

<!-- Featured Products -->
<section class="mb-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Featured Products</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            // Sample products - Replace with actual database query
            $products = [
                ['id' => 1, 'title' => 'Kurdish Rug', 'price' => 120, 'image' => 'rug.jpg'],
                ['id' => 2, 'title' => 'Handmade Shawl', 'price' => 35, 'image' => 'shawl.jpg'],
                // Add more products
            ];
            
            foreach($products as $product): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <img src="../assets/images/products/<?= $product['image'] ?>" 
                     alt="<?= $product['title'] ?>" 
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-2"><?= $product['title'] ?></h3>
                    <p class="text-blue-600 font-bold mb-4">$<?= number_format($product['price'], 2) ?></p>
                    <a href="product-detail.php?id=<?= $product['id'] ?>" 
                       class="block text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        View Details
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once '../partials/footer.php'; ?>