<?php
session_start();
require_once 'backend/config.php';
require_once 'backend/chat_handler.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$seller_id = (int)$_GET['seller_id'] ?? 0;
$product_id = (int)$_GET['product_id'] ?? 0;

// Get conversation
$messages = getMessages($_SESSION['user_id'], $seller_id, $product_id);

// Get product info
$product = getProductById($product_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Same head as register.php -->
    <script src="assets/js/chat.js" defer></script>
</head>
<body class="bg-gray-100">
    <?php include_once 'partials/navbar.php'; ?>

    <main class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Chat Header -->
            <div class="bg-blue-500 text-white p-4">
                <h1 class="text-xl font-bold">Chat with Seller</h1>
                <?php if($product): ?>
                    <p>About: <?= htmlspecialchars($product['title']) ?></p>
                <?php endif; ?>
            </div>
            
            <!-- Messages Container -->
            <div id="messages-container" class="p-4 h-96 overflow-y-auto">
                <?php foreach($messages as $message): ?>
                    <div class="mb-4 <?= $message['sender_id'] == $_SESSION['user_id'] ? 'text-right' : 'text-left' ?>">
                        <div class="<?= $message['sender_id'] == $_SESSION['user_id'] ? 'bg-blue-100' : 'bg-gray-200' ?> p-3 rounded-lg inline-block max-w-xs">
                            <p><?= htmlspecialchars($message['message']) ?></p>
                            <p class="text-xs text-gray-500 mt-1">
                                <?= date('M j, g:i a', strtotime($message['created_at'])) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Message Input -->
            <div class="border-t p-4">
                <form id="message-form" method="POST">
                    <input type="hidden" name="receiver_id" value="<?= $seller_id ?>">
                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                    
                    <div class="flex">
                        <input type="text" name="message" placeholder="Type your message..." required 
                               class="flex-1 border rounded-l px-3 py-2">
                        <button type="submit" 
                                class="bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-600">
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include_once 'partials/footer.php'; ?>
</body>
</html>