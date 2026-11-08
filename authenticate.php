<?php
// authenticate.php — logic-only include used by index.php if you split it
require_once __DIR__ . '/config/database.php';

function attempt_login(mysqli $conn, string $username, string $password): ?array {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND status = 1 LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return null;
}