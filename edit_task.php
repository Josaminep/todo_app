<?php
session_start();

// Initialize tasks array if not set
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Load existing tasks into session for testing purposes (you can replace this with your own data)
if (empty($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [
        1 => ['title' => 'Task 1', 'description' => 'Description for Task 1', 'priority' => 'low', 'deadline' => '2024-10-19T12:00', 'status' => 'pending'],
        2 => ['title' => 'Task 2', 'description' => 'Description for Task 2', 'priority' => 'medium', 'deadline' => '2024-10-20T12:00', 'status' => 'completed'],
    ];
}

// Handle editing a task
$id = $_GET['id'] ?? null;

if ($id && isset($_SESSION['tasks'][$id])) {
    $task = $_SESSION['tasks'][$id];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = ucwords($_POST['title']);
        $description = ucwords($_POST['description']);
        $priority = ucfirst($_POST['priority']);
        $deadline = $_POST['deadline'];
        $status = ucfirst($_POST['status']);

        // Update task in the session
        $_SESSION['tasks'][$id] = [
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
            'deadline' => $deadline,
            'status' => $status
        ];

        $_SESSION['message'] = "Task updated successfully!";
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect if task ID is invalid
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
                    <input type="datetime-local" name="deadline" class="form-control" value="<?php echo htmlspecialchars($task['deadline']); ?>">
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
    const words = input.value.split(' ');
    const capitalizedWords = words.map(word => 
        word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
    );
    input.value = capitalizedWords.join(' ');
}
</script>

</body>
</html>
