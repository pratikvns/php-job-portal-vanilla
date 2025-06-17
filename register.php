<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$errors = [];
$success_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     if (!verify_csrf_token($_POST['csrf_token'])) {
        $errors[] = 'Invalid CSRF token. Please try again.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $role = in_array($_POST['role'], ['user', 'hr']) ? $_POST['role'] : 'user';

        if (empty($name) || !$email || empty($password)) $errors[] = 'All fields are required.';
        if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters long.';

        if (empty($errors)) {
            $pdo = DB::getInstance();
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $errors[] = 'An account with this email already exists.';
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $status = ($role === 'hr') ? 'pending_verification' : 'active';

                $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, role, status) VALUES (?, ?, ?, ?, ?)");
                if ($stmt->execute([$name, $email, $password_hash, $role, $status])) {
                    $success_message = ($role === 'hr')
                        ? 'HR account created! Please check your email for verification.'
                        : 'Account created successfully! You can now log in.';
                    $_POST = [];
                } else {
                    $errors[] = 'Failed to create account. Please try again.';
                }
            }
        }
    }
}

$page_title = 'Register';
include __DIR__ . '/views/header.phtml';
?>

<h2>Create an Account</h2>

<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?><p><?= e($error) ?></p><?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($success_message): ?>
    <div class="success"><p><?= e($success_message) ?></p></div>
<?php else: ?>
<form action="/register" method="post" id="register-form">
    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required value="<?= e($_POST['name'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
        <label>Register as:</label>
        <label><input type="radio" name="role" value="user" checked> Job Seeker (User)</label>
        <label><input type="radio" name="role" value="hr"> Recruiter (HR)</label>
    </div>
    <button type="submit">Register</button>
</form>
<?php endif; ?>

<?php include __DIR__ . '/views/footer.phtml'; ?>
