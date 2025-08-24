<?php
include 'includes/config.php';
include 'includes/header.php';
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Latest News</h1>
<div class="container">
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <h2><a href="single.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h2>
            <?php if ($post['image']): ?>
                <img src="assets/images/<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>">
            <?php endif; ?>
            <p><?php echo substr($post['content'], 0, 200); ?>...</p>
        </div>
    <?php endforeach; ?>
    <!-- Display Ads -->
    <?php
    $adStmt = $pdo->query("SELECT * FROM ads WHERE position = 'sidebar'");
    $ads = $adStmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($ads as $ad): ?>
        <div class="ad"><?php echo $ad['ad_code']; ?></div>
    <?php endforeach; ?>
</div>
<?php include 'includes/footer.php'; ?>
