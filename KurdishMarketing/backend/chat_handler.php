<?php
require_once 'config.php';

/**
 * Get conversation between users about a product
 */
function getConversation($user1_id, $user2_id, $product_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT m.*, 
               u1.username as sender_name,
               u2.username as receiver_name
        FROM messages m
        JOIN users u1 ON m.sender_id = u1.id
        JOIN users u2 ON m.receiver_id = u2.id
        WHERE ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?))
        AND product_id = ?
        ORDER BY created_at ASC
    ");
    $stmt->execute([$user1_id, $user2_id, $user2_id, $user1_id, $product_id]);
    return $stmt->fetchAll();
}

/**
 * Send a message
 */
function sendMessage($sender_id, $receiver_id, $product_id, $message) {
    global $pdo;
    
    if (empty($message)) {
        return ['error' => 'Message cannot be empty'];
    }
    
    $stmt = $pdo->prepare("
        INSERT INTO messages 
        (sender_id, receiver_id, product_id, message) 
        VALUES (?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([$sender_id, $receiver_id, $product_id, $message]);
    
    return $success 
        ? ['success' => true, 'message_id' => $pdo->lastInsertId()] 
        : ['error' => 'Failed to send message'];
}

/**
 * Get user's conversations list
 */
function getConversationsList($user_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT DISTINCT 
            LEAST(sender_id, receiver_id) as user1,
            GREATEST(sender_id, receiver_id) as user2,
            product_id,
            MAX(created_at) as last_message_time
        FROM messages
        WHERE ? IN (sender_id, receiver_id)
        GROUP BY user1, user2, product_id
        ORDER BY last_message_time DESC
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['error' => 'Not authenticated']);
        exit;
    }
    
    switch ($_POST['action']) {
        case 'send':
            $response = sendMessage(
                $_SESSION['user_id'],
                (int)$_POST['receiver_id'],
                (int)$_POST['product_id'],
                trim($_POST['message'])
            );
            break;
            
        case 'get':
            $response = getConversation(
                $_SESSION['user_id'],
                (int)$_POST['other_user_id'],
                (int)$_POST['product_id']
            );
            break;
            
        default:
            $response = ['error' => 'Invalid action'];
    }
    
    echo json_encode($response);
    exit;
}
?>