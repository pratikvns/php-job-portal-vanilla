<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_auth(['user']);

$page_title = 'User Dashboard';
include __DIR__ . '/../views/header.phtml';
?>

<h2>My Dashboard</h2>
<p>Welcome, <?= e($_SESSION['name']) ?>!</p>

<div class="user-menu">
    <ul>
        <li><a href="#">Edit Profile</a></li>
        <li><a href="#">View Job Suggestions</a></li>
        <li><a href="#">My Applications</a></li>
    </ul>
</div>

<?php include __DIR__ . '/../views/footer.phtml'; ?>
