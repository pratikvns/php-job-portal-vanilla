<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_sarkari_hr();

$page_title = 'Post Sarkari Notification';
include __DIR__ . '/../views/header.phtml';
?>

<h2>Post a New Sarkari Notification (Job/Result/Admit Card)</h2>
<p>Form to post a sarkari notification would go here.</p>
<!-- Add a full form with CSRF token and file upload capabilities here -->

<?php include __DIR__ . '/../views/footer.phtml'; ?>
