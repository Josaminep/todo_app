<?php
session_start(); // Start the session

// Check for success message and clear it after displaying
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

// Retrieve tasks from session
$tasks = isset($_SESSION['tasks']) ? $_SESSION['tasks'] : [];

// Handle delete request
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']); // Sanitize the input
    if (isset($tasks[$deleteId])) {
        unset($tasks[$deleteId]); // Remove the task
        $_SESSION['message'] = "Task deleted successfully!";
        $_SESSION['tasks'] = array_values($tasks); // Re-index array
        header("Location: index.php"); // Redirect to avoid re-submission
        exit();
    }
}

// Save tasks back to the session after potential deletion
$_SESSION['tasks'] = $tasks;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Task List</title>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h3>Task List</h3>
        </div>
        <div class="card-body">
            <?php if ($message): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <a href="add_task.php" class="btn btn-success mb-3">Add New Task</a> <!-- Move the button here -->

            <?php if (empty($tasks)): ?>
                <p class="text-center">No tasks added yet.</p>
            <?php else: ?>
                <div class="table-responsive"> <!-- Added responsive wrapper for the table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Priority</th>
                                <th>Deadline</th>
                                <th>Actions</th> <!-- New column for actions -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $index => $task): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                                    <td><?php echo htmlspecialchars($task['priority']); ?></td>
                                    <td><?php echo htmlspecialchars($task['deadline']); ?></td>
                                    <td>
                                        <a href="edit_task.php?id=<?php echo $index; ?>"style="margin-bottom: 5px" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?delete=<?php echo $index; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <div class="card-footer text-center">
            <?php echo date("Y"); ?> - Josaminep | Todo List Application
        </div>
    </div>
</div>

</body>
</html>
