<?php
session_start();
include '../includes/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Create Post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $image);
    }
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, image, user_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $content, $image, $_SESSION['user_id']]);
}

// Delete Post
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$id]);
}

// Fetch Posts
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Manage Posts</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="content" placeholder="Content" required></textarea>
    <input type="file" name="image">
    <button type="submit" name="create">Add Post</button>
</form>
<table>
    <tr><th>Title</th><th>Actions</th></tr>
    <?php foreach ($posts as $post): ?>
        <tr>
            <td><?php echo htmlspecialchars($post['title']); ?></td>
            <td>
                <a href="edit_post.php?id=<?php echo $post['id']; ?>">Edit</a>
                <a href="?delete=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
