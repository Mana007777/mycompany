<?php
require_once 'config.php';

/**
 * Get all users
 */
function getAllUsers($limit = 50) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT id, username, email, role, created_at 
        FROM users 
        ORDER BY created_at DESC 
        LIMIT ?
    ");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

/**
 * Get all products
 */
function getAllProducts($limit = 50) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT p.*, u.username as seller_name 
        FROM products p
        JOIN users u ON p.seller_id = u.id
        ORDER BY p.created_at DESC 
        LIMIT ?
    ");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

/**
 * Delete user (admin only)
 */
function deleteUser($user_id) {
    global $pdo;
    
    // Start transaction
    $pdo->beginTransaction();
    
    try {
        // Delete user's products first
        $stmt = $pdo->prepare("SELECT id, image_path FROM products WHERE seller_id = ?");
        $stmt->execute([$user_id]);
        $products = $stmt->fetchAll();
        
        foreach ($products as $product) {
            if (!empty($product['image_path'])) {
                $image_path = __DIR__ . '/../' . $product['image_path'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }
        
        // Delete user
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

/**
 * Toggle product status
 */
function toggleProductStatus($product_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        UPDATE products 
        SET status = IF(status = 'active', 'inactive', 'active') 
        WHERE id = ?
    ");
    return $stmt->execute([$product_id]);
}
?>