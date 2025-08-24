<?php
session_start();
include '../includes/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Create Ad
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $title = $_POST['title'];
    $ad_code = $_POST['ad_code'];
    $position = $_POST['position'];
    $stmt = $pdo->prepare("INSERT INTO ads (title, ad_code, position) VALUES (?, ?, ?)");
    $stmt->execute([$title, $ad_code, $position]);
}

// Delete Ad
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM ads WHERE id = ?");
    $stmt->execute([$id]);
}

// Fetch Ads
$stmt = $pdo->query("SELECT * FROM ads ORDER BY created_at DESC");
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Manage Ads</h2>
<form method="POST">
    <input type="text" name="title" placeholder="Ad Title" required>
    <textarea name="ad_code" placeholder="Ad Code (e.g., Google AdSense script)" required></textarea>
    <select name="position" required>
        <option value="sidebar">Sidebar</option>
        <option value="header">Header</option>
        <option value="footer">Footer</option>
    </select>
    <button type="submit" name="create">Add Ad</button>
</form>
<table>
    <tr><th>Title</th><th>Position</th><th>Actions</th></tr>
    <?php foreach ($ads as $post): ?>
        <tr>
            <td><?php echo htmlspecialchars($post['title']); ?></td>
            <td><?php echo htmlspecialchars($post['position']); ?></td>
            <td>
                <a href="?delete=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
