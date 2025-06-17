<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_auth(['admin']);

require_once __DIR__ . '/../includes/db.php';
$pdo = DB::getInstance();
$stmt = $pdo->query("SELECT id, name, email, role, is_sarkari_hr, status FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();

$page_title = 'Manage Users';
include __DIR__ . '/../views/header.phtml';
?>

<h2>Manage Users</h2>
<p>Here you can manage all users and grant Sarkari posting rights to HRs.</p>

<table class="data-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Sarkari HR</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= e($user['name']) ?></td>
                <td><?= e($user['email']) ?></td>
                <td><?= e(ucfirst($user['role'])) ?></td>
                <td><?= $user['is_sarkari_hr'] ? 'Yes' : 'No' ?></td>
                <td><?= e(ucfirst($user['status'])) ?></td>
                <td>
                    <?php if ($user['role'] === 'hr' && $user['status'] === 'active'): ?>
                        <button class="toggle-sarkari-hr" data-userid="<?= $user['id'] ?>">
                            <?= $user['is_sarkari_hr'] ? 'Revoke Sarkari Access' : 'Grant Sarkari Access' ?>
                        </button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../views/footer.phtml'; ?>
