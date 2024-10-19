<?php
include 'config.php';
session_start();

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = ucwords($_POST['title']);
    $description = ucwords($_POST['description']);
    $priority = ucfirst($_POST['priority']);  // Only first letter capital
    $deadline = $_POST['deadline'];
    $status = ucfirst($_POST['status']); // Only first letter capital

    // Update task with the new details, including status
    $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, priority = ?, deadline = ?, status = ? WHERE id = ?");
    $stmt->execute([$title, $description, $priority, $deadline, $status, $id]);

    $_SESSION['message'] = "Task updated successfully!";

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Edit Task</title>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h3>Edit Task</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" oninput="capitalizeFirstLetter(this)" value="<?php echo htmlspecialchars(ucwords($task['title'])); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" oninput="capitalizeFirstLetter(this)"><?php echo htmlspecialchars(ucwords($task['description'])); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select name="priority" class="form-control">
                        <option value="low" <?php echo ($task['priority'] == 'low') ? 'selected' : ''; ?>>Low</option>
                        <option value="medium" <?php echo ($task['priority'] == 'medium') ? 'selected' : ''; ?>>Medium</option>
                        <option value="high" <?php echo ($task['priority'] == 'high') ? 'selected' : ''; ?>>High</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="datetime-local" name="deadline" class="form-control" oninput="capitalizeFirstLetter(this)" value="<?php echo $task['deadline']; ?>">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="pending" <?php echo ($task['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="index.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
        <div class="card-footer text-center">
            <?php echo date("Y"); ?> - Josaminep | Todo List Application
        </div>
    </div>
</div>

<script>
function capitalizeFirstLetter(input) {
    const words = input.value.split(' '); // Split the input into words
    const capitalizedWords = words.map(word => 
        word.charAt(0).toUpperCase() + word.slice(1).toLowerCase() // Capitalize the first letter and make the rest lowercase
    );
    input.value = capitalizedWords.join(' '); // Join the capitalized words back into a string
}
</script>

</body>
</html>
