<?php
session_start();
include '../includes/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<h1>Admin Dashboard</h1>
<ul>
    <li><a href="posts.php">Manage Posts</a></li>
    <li><a href="ads.php">Manage Ads</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
