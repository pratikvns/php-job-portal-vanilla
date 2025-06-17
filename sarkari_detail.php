<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(404); echo "Invalid ID."; exit; }

$pdo = DB::getInstance();
$stmt = $pdo->prepare("
    SELECT sn.*, d.name as department_name, q.name as qualification_name
    FROM sarkari_notifications sn
    LEFT JOIN departments d ON sn.department_id = d.id
    LEFT JOIN qualifications q ON sn.qualification_id = q.id
    WHERE sn.id = ? AND sn.is_moderated = 1
");
$stmt->execute([$id]);
$notification = $stmt->fetch();

if (!$notification) { http_response_code(404); echo "Notification not found."; exit; }

$stmt_sub = $pdo->prepare("SELECT * FROM sarkari_sub_posts WHERE notification_id = ? ORDER BY id ASC");
$stmt_sub->execute([$id]);
$sub_posts = $stmt_sub->fetchAll();

$page_title = e($notification['title']);
include __DIR__ . '/views/header.phtml';
?>

<article class="job-detail">
    <header>
        <h1><?= e($notification['title']) ?></h1>
        <p class="meta">
            <strong>Type:</strong> <?= e(ucfirst($notification['type'])) ?> |
            <strong>Posted:</strong> <?= e(date('M d, Y', strtotime($notification['posted_at']))) ?>
        </p>
    </header>

    <div class="job-body">
        <p><strong>Department:</strong> <?= e($notification['department_name'] ?? 'N/A') ?></p>
        <p><strong>Qualification:</strong> <?= e($notification['qualification_name'] ?? 'N/A') ?></p>

        <h3>Description</h3>
        <div><?= nl2br(e($notification['description'])) ?></div>

        <?php if (!empty($sub_posts)): ?>
        <h3>Post Details</h3>
        <ul>
            <?php foreach ($sub_posts as $post): ?>
                <li>
                    <strong><?= e($post['title']) ?>:</strong>
                    <?= e($post['details'] ?? '') ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

    <footer>
        <?php if ($notification['official_link']): ?>
            <a href="<?= e($notification['official_link']) ?>" class="button" target="_blank" rel="noopener noreferrer">Official Link</a>
        <?php endif; ?>
         <?php if ($notification['upload_path']): ?>
            <a href="/<?= e($notification['upload_path']) ?>" class="button" target="_blank">Download Notification PDF</a>
        <?php endif; ?>
    </footer>
</article>

<?php include __DIR__ . '/views/footer.phtml'; ?>
