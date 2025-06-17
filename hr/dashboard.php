<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_auth(['hr']);

$page_title = 'HR Dashboard';
include __DIR__ . '/../views/header.phtml';
?>

<h2>HR Dashboard</h2>
<p>Welcome, <?= e($_SESSION['name']) ?>!</p>

<div class="hr-menu">
    <ul>
        <li><a href="/hr/post_private_job">Post a New Private Job</a></li>
        <li><a href="#">Manage My Private Jobs</a></li>
        <?php if ($_SESSION['is_sarkari_hr']): ?>
            <li class="sarkari-feature"><a href="/hr/post_sarkari_job">Post Sarkari Notification</a></li>
            <li class="sarkari-feature"><a href="#">Manage My Sarkari Posts</a></li>
        <?php endif; ?>
        <li><a href="#">Chat with other HRs</a></li>
        <li><a href="#">Recommend an Employee</a></li>
    </ul>
</div>

<?php include __DIR__ . '/../views/footer.phtml'; ?>
