<?php
include 'config.php';
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    $stmt = $pdo->prepare("INSERT INTO tasks (title, description, priority, deadline) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $description, $priority, $deadline]);

    // Set a session variable for success message
    $_SESSION['message'] = "Task successfully added!";
    
    header("Location: index.php");
    exit(); // Ensure no further code is executed after the redirect
}
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Add Task</title>
    </head>
    <body>
                <div class="container mt-5">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3>Add New Task</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                            <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" required oninput="capitalizeFirstLetter(this)">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" oninput="capitalizeFirstLetter(this)"></textarea>
                </div>
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select name="priority" class="form-control">
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="datetime-local" name="deadline" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Add Task</button>
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
</script>

</body>
</html>
