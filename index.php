<?php
include 'config.php';
session_start(); // Start the session

// Fetch new tasks from the database
$stmtNew = $pdo->prepare("SELECT * FROM tasks WHERE status = 'New' ORDER BY created_at DESC");
$stmtNew->execute();
$newTasks = $stmtNew->fetchAll(PDO::FETCH_ASSOC);

// Fetch completed tasks from the database
$stmtCompleted = $pdo->prepare("SELECT * FROM tasks WHERE status = 'Completed' ORDER BY created_at DESC");
$stmtCompleted->execute();
$completedTasks = $stmtCompleted->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to the custom CSS if needed -->
    <title>Todo List Application</title>
    <style>
        body, html {
            padding: 0;
            margin: 0;
            overflow-x: hidden; /* Disable horizontal scroll */
        }
        .table-responsive {
            margin-bottom: 15px;
            max-width: 100%; /* Ensure table doesn't exceed container width */
        }
        .card-footer {
            font-size: 0.9rem; /* Slightly smaller font for mobile */
        }
        @media (max-width: 576px) {
            .btn {
                padding: 0.3rem 0.5rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header text-center">
            <h3>Todo List</h3>
        </div>
        <div class="card-body">
            
            <?php if (isset($_SESSION['message'])): ?>
                <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); // Clear the message after displaying
                    ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <a href="add_task.php" class="btn btn-success mb-3">Add Task</a>

            <!-- Tabs for New and Completed tasks -->
            <ul class="nav nav-tabs" id="taskTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#newTasks">New</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#completedTasks">Completed</a>
                </li>
            </ul>

            <?php
                $stmtPending = $pdo->prepare("SELECT * FROM tasks WHERE status = 'Pending' ORDER BY created_at DESC");
                $stmtPending->execute();
                $pendingTasks = $stmtPending->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="tab-content">
                <div id="newTasks" class="tab-pane fade show active">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Priority</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingTasks as $task): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                                        <td><?php echo htmlspecialchars($task['description']); ?></td>
                                        <td><?php echo htmlspecialchars($task['priority']); ?></td>
                                        <td><?php echo htmlspecialchars($task['deadline']); ?></td>
                                        <td><?php echo htmlspecialchars($task['status']); ?></td>
                                        <td>
                                        <a href="edit_task.php?id=<?php echo $task['id']; ?>"style="margin-bottom: 5px" class="btn btn-success btn-sm">Edit</a>
                                        <a href="delete_task.php?id=<?php echo $task['id']; ?>"style="margin-bottom: 5px" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
                    $stmtPending = $pdo->prepare("SELECT * FROM tasks WHERE status = 'Completed' ORDER BY created_at DESC");
                    $stmtPending->execute();
                    $pendingTasks = $stmtPending->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div id="completedTasks" class="tab-pane fade">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Priority</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($completedTasks as $task): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                                        <td><?php echo htmlspecialchars($task['description']); ?></td>
                                        <td><?php echo htmlspecialchars($task['priority']); ?></td>
                                        <td><?php echo htmlspecialchars($task['deadline']); ?></td>
                                        <td><?php echo htmlspecialchars($task['status']); ?></td>
                                        <td><?php echo htmlspecialchars($task['created_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted text-center">
            <?php echo date("Y"); ?> - Josaminep | Todo List Application
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#alertMessage').alert('close'); 
        }, 3000); 
    });
</script>
</body>
</html>
