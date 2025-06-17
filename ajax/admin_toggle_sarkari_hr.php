<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/auth_check.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Authentication required.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid User ID.']);
    exit;
}

require_once __DIR__ . '/../includes/db.php';
$pdo = DB::getInstance();

try {
    $stmt = $pdo->prepare("SELECT is_sarkari_hr FROM users WHERE id = ? AND role = 'hr'");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if (!$user) {
         echo json_encode(['success' => false, 'message' => 'HR user not found.']);
         exit;
    }

    $new_status = $user['is_sarkari_hr'] ? 0 : 1;

    $update_stmt = $pdo->prepare("UPDATE users SET is_sarkari_hr = ? WHERE id = ?");
    $update_stmt->execute([$new_status, $user_id]);

    echo json_encode([
        'success' => true,
        'message' => 'Permission updated successfully.',
        'new_status_text' => $new_status ? 'Revoke Sarkari Access' : 'Grant Sarkari Access'
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
}
