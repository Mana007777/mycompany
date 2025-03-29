<?php
session_start();
require_once '../backend/config.php';
require_once '../backend/auth.php';

// Redirect non-admin users
if(!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Get stats
$users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="bg-gray-100">
    <!-- Admin Header -->
    <?php include 'partials/header.php'; ?>
    
    <div class="flex">
        <!-- Sidebar -->
        <?php include 'partials/sidebar.php'; ?>
        
        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-8">Dashboard Overview</h1>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Total Users</h3>
                    <p class="text-3xl font-bold text-blue-600"><?= number_format($users) ?></p>
                    <a href="users/all.php" class="text-blue-500 hover:underline mt-2 block">View All</a>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Total Products</h3>
                    <p class="text-3xl font-bold text-green-600"><?= number_format($products) ?></p>
                    <a href="products/all.php" class="text-blue-500 hover:underline mt-2 block">Manage Products</a>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Total Orders</h3>
                    <p class="text-3xl font-bold text-purple-600"><?= number_format($orders) ?></p>
                    <a href="reports/sales.php" class="text-blue-500 hover:underline mt-2 block">View Sales</a>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">User</th>
                                <th class="py-2 px-4 border-b">Action</th>
                                <th class="py-2 px-4 border-b">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $activity = $pdo->query("
                                SELECT u.username, a.action, a.created_at 
                                FROM admin_activity a
                                JOIN users u ON a.user_id = u.id
                                ORDER BY a.created_at DESC
                                LIMIT 5
                            ")->fetchAll();
                            
                            foreach($activity as $item): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($item['username']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($item['action']) ?></td>
                                <td class="py-2 px-4 border-b"><?= date('M j, g:i a', strtotime($item['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <script src="assets/js/admin.js"></script>
</body>
</html>