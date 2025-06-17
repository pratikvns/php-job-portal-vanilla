<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_auth(['admin']);

$page_title = 'Admin Dashboard';
include __DIR__ . '/../views/header.phtml';
?>

<h2>Admin Dashboard</h2>
<p>Welcome, <?= e($_SESSION['name']) ?>!</p>

<div class="admin-menu">
    <ul>
        <li><a href="/admin/manage_users">Manage Users & HR Permissions</a></li>
        <li><a href="#">Moderate Sarkari Posts</a></li>
        <li><a href="#">View All Jobs & Applications</a></li>
        <li><a href="#">View HR Chat Logs</a></li>
    </ul>
</div>

<?php include __DIR__ . '/../views/footer.phtml'; ?>
