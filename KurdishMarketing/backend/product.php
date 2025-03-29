<?php
require_once 'config.php';

/**
 * Upload new product
 */
function uploadProduct($seller_id, $data, $file) {
    global $pdo;
    
    // Validate input
    $errors = [];
    if (empty($data['title'])) {
        $errors[] = 'Product title is required';
    }
    if (empty($data['price']) || !is_numeric($data['price']) || $data['price'] <= 0) {
        $errors[] = 'Valid price is required';
    }
    
    // Validate image
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Image upload failed';
    } elseif ($file['size'] > MAX_FILE_SIZE) {
        $errors[] = 'Image is too large (max 5MB)';
    } elseif (!in_array($file['type'], ALLOWED_TYPES)) {
        $errors[] = 'Only JPG, PNG, and GIF images are allowed';
    }
    
    if (!empty($errors)) {
        return ['errors' => $errors];
    }
    
    // Process image upload
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('product_') . '.' . $ext;
    $destination = UPLOAD_DIR . $filename;
    
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return ['errors' => ['Failed to save image']];
    }
    
    // Insert product
    $stmt = $pdo->prepare("
        INSERT INTO products 
        (seller_id, title, description, price, category, image_path) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $seller_id,
        $data['title'],
        $data['description'] ?? '',
        $data['price'],
        $data['category'] ?? 'other',
        'assets/images/products/' . $filename
    ]);
    
    return $success 
        ? ['success' => true, 'product_id' => $pdo->lastInsertId()] 
        : ['errors' => ['Failed to save product']];
}

/**
 * Get product by ID
 */
function getProductById($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT p.*, u.username as seller_name, u.email as seller_email 
        FROM products p
        JOIN users u ON p.seller_id = u.id
        WHERE p.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/**
 * Get products by seller
 */
function getProductsBySeller($seller_id, $limit = 10) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT * FROM products 
        WHERE seller_id = ? 
        ORDER BY created_at DESC 
        LIMIT ?
    ");
    $stmt->execute([$seller_id, $limit]);
    return $stmt->fetchAll();
}

/**
 * Search products
 */
function searchProducts($query = '', $filters = []) {
    global $pdo;
    
    $where = ["status = 'active'"];
    $params = [];
    
    // Search query
    if (!empty($query)) {
        $where[] = "(title LIKE ? OR description LIKE ?)";
        $search_term = "%$query%";
        $params[] = $search_term;
        $params[] = $search_term;
    }
    
    // Category filter
    if (!empty($filters['category'])) {
        $where[] = "category = ?";
        $params[] = $filters['category'];
    }
    
    // Price range
    if (!empty($filters['min_price'])) {
        $where[] = "price >= ?";
        $params[] = $filters['min_price'];
    }
    if (!empty($filters['max_price'])) {
        $where[] = "price <= ?";
        $params[] = $filters['max_price'];
    }
    
    $sql = "SELECT * FROM products";
    if (!empty($where)) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }
    $sql .= " ORDER BY created_at DESC LIMIT 100";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Delete product
 */
function deleteProduct($product_id, $seller_id) {
    global $pdo;
    
    // Verify product belongs to seller
    $stmt = $pdo->prepare("SELECT id, image_path FROM products WHERE id = ? AND seller_id = ?");
    $stmt->execute([$product_id, $seller_id]);
    $product = $stmt->fetch();
    
    if (!$product) {
        return false;
    }
    
    // Delete product
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $success = $stmt->execute([$product_id]);
    
    // Delete image file
    if ($success && !empty($product['image_path'])) {
        $image_path = __DIR__ . '/../' . $product['image_path'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    return $success;
}
?>