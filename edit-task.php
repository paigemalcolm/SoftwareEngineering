<?php 
session_start();

// Check if the user is logged in
if (isset($_SESSION['id'])) { 
    include "DB_connection.php";  
    include "app/Model/Task.php"; 

    
    if (!isset($_GET['id'])) {
        header("Location: tasks.php?error=" . urlencode("No task ID provided"));
        exit();
    }

    $task_id = $_GET['id'];
    $task = get_task_by_id($conn, $task_id); 

    
    if (!$task || $task['created_by'] != $_SESSION['id']) {
        header("Location: tasks.php?error=" . urlencode("Task not found or unauthorized access"));
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php"; ?>
    <div class="body">
        <?php include "inc/nav.php"; ?>
        <section class="section-1">
            <h4 class="title">Edit Task</h4>
            <form class="form-1" method="POST" action="app/update-task.php">
                <?php if (isset($_GET['error'])) { ?>
                    <div class="danger" role="alert">
                        <?= htmlspecialchars(stripslashes($_GET['error'])) ?>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['success'])) { ?>
                    <div class="success" role="alert">
                        <?= htmlspecialchars(stripslashes($_GET['success'])) ?>
                    </div>
                <?php } ?>

                <div class="input-holder">
                    <label>Title</label>
                    <input type="text" name="title" class="input-1" value="<?= htmlspecialchars($task['title']) ?>" required><br>
                </div>
                <div class="input-holder">
                    <label>Description</label>
                    <textarea name="description" class="input-1" required><?= htmlspecialchars($task['description']) ?></textarea><br>
                </div>
                <div class="input-holder">
                    <label>Due Date</label>
                    <input type="date" name="due_date" class="input-1" value="<?= htmlspecialchars($task['due_date']) ?>" required><br>
                </div>
                <div class="input-holder">
                    <label>Status</label>
                    <select name="status" class="input-1" required>
                        <option value="1" <?= $task['status_id'] == 1 ? 'selected' : '' ?>>Pending</option>
                        <option value="2" <?= $task['status_id'] == 2 ? 'selected' : '' ?>>In Progress</option>
                        <option value="3" <?= $task['status_id'] == 3 ? 'selected' : '' ?>>Completed</option>
                    </select><br>
                </div>

                <input type="hidden" name="id" value="<?= htmlspecialchars($task['id']) ?>">
                <button type="submit" class="edit-btn">Update Task</button>
            </form>
        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navList li:nth-child(3)");
        active.classList.add("active");
    </script>
</body>
</html>

<?php 
} else { 
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
} 
?>
