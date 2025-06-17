<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_auth(['hr']);

$page_title = 'Post Private Job';
include __DIR__ . '/../views/header.phtml';
?>

<h2>Post a New Private Job</h2>
<p>Form to post a private job would go here.</p>
<!-- Add a full form with CSRF token here -->

<?php include __DIR__ . '/../views/footer.phtml'; ?>
