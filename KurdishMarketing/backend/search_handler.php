<?php
require_once 'config.php';
require_once 'product.php';

// Process search request
$search_results = [];
$query = $_GET['q'] ?? '';
$category = $_GET['category'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

// Build filters
$filters = [];
if (!empty($category)) $filters['category'] = $category;
if (!empty($min_price)) $filters['min_price'] = (float)$min_price;
if (!empty($max_price)) $filters['max_price'] = (float)$max_price;

// Perform search
$search_results = searchProducts($query, $filters);

// Return JSON if AJAX request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($search_results);
    exit;
}
?>