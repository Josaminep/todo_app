<?php
session_start(); // Start the session

// Retrieve tasks from session
$tasks = isset($_SESSION['tasks']) ? $_SESSION['tasks'] : [];

// Check if an ID is provided for editing
if (!isset($_GET['id']) || !isset($tasks[$_GET['id']])) {
    header("Location: index.php"); // Redirect if no valid ID
    exit();
}

// Get the task to be edited
$taskIndex = intval($_GET['id']);
$task = $tasks[$taskIndex];

// Handle form submission for editing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    // Update the task details
    $tasks[$taskIndex] = [
        'title' => $title,
        'description' => $description,
        'priority' => $priority,
        'deadline' => $deadline,
    ];

    // Save the updated tasks back to the session
    $_SESSION['tasks'] = $tasks;

    // Set a session variable for success message
    $_SESSION['message'] = "Task successfully updated!";
    
    header("Location: index.php"); // Redirect after updating
    exit(); // Ensure no further code is executed after the redirect
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
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($task['title']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" required><?php echo htmlspecialchars($task['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select name="priority" class="form-control">
                        <option value="Low" <?php echo $task['priority'] == 'Low' ? 'selected' : ''; ?>>Low</option>
                        <option value="Medium" <?php echo $task['priority'] == 'Medium' ? 'selected' : ''; ?>>Medium</option>
                        <option value="High" <?php echo $task['priority'] == 'High' ? 'selected' : ''; ?>>High</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="datetime-local" name="deadline" class="form-control" value="<?php echo htmlspecialchars($task['deadline']); ?>">
                </div>
                <button type="submit" class="btn btn-success">Update Task</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
        <div class="card-footer text-center">
            <?php echo date("Y"); ?> - Josaminep | Todo List Application
        </div>
    </div>
</div>
</body>
</html>
