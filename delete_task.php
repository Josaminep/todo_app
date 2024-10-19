<?php
include 'config.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['message'] = "Task deleted successfully!";

    header("Location: index.php");
    exit();
}
?>
