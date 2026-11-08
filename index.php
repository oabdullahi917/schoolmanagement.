<?php
require_once __DIR__ . '/config/database.php';

// If already logged in, send to their dashboard
if (!empty($_SESSION['user_id'])) {
    redirect(role_dashboard($_SESSION['role']));
}

function role_dashboard($role) {
    return match ($role) {
        'admin'      => 'admin/dashboard.php',
        'teacher'    => 'teacher/dashboard.php',
        'student'    => 'student/dashboard.php',
        'parent'     => 'parent/dashboard.php',
        'accountant' => 'accountant/dashboard.php',
        default      => 'index.php',
    };
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Please enter username and password.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND status = 1 LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role']      = $user['role'];
            $_SESSION['is_super_admin'] = (int)($user['is_super_admin'] ?? 0);
            redirect(role_dashboard($user['role']));
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - <?= SITE_NAME ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background: linear-gradient(135deg,#667eea,#764ba2); min-height:100vh; }
  .login-card { max-width: 420px; margin: 8vh auto; border-radius: 15px; }
</style>
</head>
<body>
<div class="container">
  <div class="card login-card shadow-lg">
    <div class="card-body p-4">
      <h3 class="text-center mb-4">🎓 <?= SITE_NAME ?></h3>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
      <?php endif; ?>

      <form method="post" autocomplete="off">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100">Login</button>
      </form>

      <p class="text-muted text-center mt-3 small">Default: admin / admin123</p>
    </div>
  </div>
</div>
</body>
</html>