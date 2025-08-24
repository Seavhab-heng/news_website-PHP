<?php
session_start();
include '../includes/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'] ?: $post['image'];
    if ($image && $_FILES['image']['name']) {
        move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $image);
    }
    $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ?, image = ? WHERE id = ?");
    $stmt->execute([$title, $content, $image, $id]);
    header("Location: posts.php");
    exit;
}
?>
<h2>Edit Post</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
    <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
    <input type="file" name="image">
    <?php if ($post['image']): ?>
        <img src="../assets/images/<?php echo $post['image']; ?>" width="100">
    <?php endif; ?>
    <button type="submit">Update Post</button>
</form>
