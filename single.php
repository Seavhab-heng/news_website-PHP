<?php
include 'includes/config.php';
include 'includes/header.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);
if ($post):
?>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <?php if ($post['image']): ?>
        <img src="assets/images/<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>">
    <?php endif; ?>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    <p><small>Posted on: <?php echo $post['created_at']; ?></small></p>
<?php else: ?>
    <p>Article not found.</p>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
