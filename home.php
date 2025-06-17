<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pdo = DB::getInstance();

function get_sarkari_posts($pdo, $type, $limit = 5) {
    $stmt = $pdo->prepare("SELECT id, title, posted_at FROM sarkari_notifications WHERE type = ? AND is_moderated = 1 AND (expiry_date >= CURDATE() OR expiry_date IS NULL) ORDER BY posted_at DESC LIMIT ?");
    $stmt->execute([$type, $limit]);
    return $stmt->fetchAll();
}

$sarkari_jobs = get_sarkari_posts($pdo, 'job');
$sarkari_results = get_sarkari_posts($pdo, 'result');
$sarkari_admit_cards = get_sarkari_posts($pdo, 'admit_card');

$page_title = 'Latest Sarkari and Private Jobs';
include __DIR__ . '/views/header.phtml';
?>

<div class="homepage-content">
    <p>Welcome to the ultimate job portal for both government (Sarkari) and private sector opportunities. Find your dream job today!</p>
</div>

<div class="job-sections">
    <section class="job-section">
        <h2>Latest Sarkari Jobs</h2>
        <ul>
            <?php foreach ($sarkari_jobs as $job): ?>
                <li><a href="/sarkari/<?= e($job['id']) ?>"><?= e($job['title']) ?></a></li>
            <?php endforeach; ?>
        </ul>
        <!-- AJAX Load More button can be added here -->
    </section>

    <section class="job-section">
        <h2>Latest Sarkari Results</h2>
        <ul>
            <?php foreach ($sarkari_results as $result): ?>
                <li><a href="/sarkari/<?= e($result['id']) ?>"><?= e($result['title']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="job-section">
        <h2>Latest Sarkari Admit Cards</h2>
        <ul>
            <?php foreach ($sarkari_admit_cards as $card): ?>
                <li><a href="/sarkari/<?= e($card['id']) ?>"><?= e($card['title']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </section>
</div>

<?php include __DIR__ . '/views/footer.phtml'; ?>
