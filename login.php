<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'])) {
        $errors[] = 'Invalid CSRF token. Please try again.';
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (!$email || empty($password)) {
            $errors[] = 'Email and password are required.';
        } else {
            $pdo = DB::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['is_sarkari_hr'] = (bool)$user['is_sarkari_hr'];
                $_SESSION['last_regen'] = time();

                switch ($user['role']) {
                    case 'admin': header('Location: /admin/dashboard'); break;
                    case 'hr': header('Location: /hr/dashboard'); break;
                    default: header('Location: /user/dashboard'); break;
                }
                exit();
            } else {
                $errors[] = 'Invalid email or password, or account is not active.';
            }
        }
    }
}

$page_title = 'Login';
include __DIR__ . '/views/header.phtml';
?>

<h2>Login to Your Account</h2>

<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?><p><?= e($error) ?></p><?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="/login" method="post" id="login-form">
    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Login</button>
</form>

<?php include __DIR__ . '/views/footer.phtml'; ?>
