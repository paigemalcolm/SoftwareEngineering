<?php
session_start();

if (!isset($_SESSION['id'])) {  
    header("Location: login.php");
    exit();
}

include "DB_connection.php";
include "app/Model/Task.php";
include "app/Model/User.php";

$text = "All Tasks";

if (isset($_GET['due_date']) && $_GET['due_date'] == "Due Today") {
    $text = "Due Today";
    $tasks = get_all_tasks_due_today($conn);
    $num_task = count_tasks_due_today($conn);
} elseif (isset($_GET['due_date']) && $_GET['due_date'] == "Overdue") {
    $text = "Overdue";
    $tasks = get_all_tasks_overdue($conn);
    $num_task = count_tasks_overdue($conn);
} elseif (isset($_GET['due_date']) && $_GET['due_date'] == "No Deadline") {
    $text = "No Deadline";
    $tasks = get_all_tasks_NoDeadline($conn);
    $num_task = count_tasks_NoDeadline($conn);
} else {
    $tasks = get_all_tasks($conn);
    $num_task = count_tasks($conn);
}

$users = get_all_users($conn);

// Status mapping
$status_map = [
    1 => 'Pending',
    2 => 'In Progress',
    3 => 'Completed'
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Tasks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php"; ?>
    <div class="body">
        <?php include "inc/nav.php"; ?>
        <section class="section-1">
            <h4 class="title-2">
                <a href="create_task.php" class="btn">Create Task</a>
                <a href="tasks.php?due_date=Due Today">Due Today</a>
                <a href="tasks.php?due_date=Overdue">Overdue</a>
                <a href="tasks.php?due_date=No Deadline">No Deadline</a>
                <a href="tasks.php">All Tasks</a>
            </h4>
            <h4 class="title-2"><?= htmlspecialchars($text) ?> (<?= $num_task ?>)</h4>

            <?php if (isset($_GET['success'])) { ?>
                <div class="success">
                    <?= htmlspecialchars(stripslashes($_GET['success'])); ?>
                </div>
            <?php } ?>

            <?php if (!empty($tasks)) { ?>
                <table class="main-table">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php $i = 0; foreach ($tasks as $task) { ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= htmlspecialchars($task['title']) ?></td>
                            <td><?= htmlspecialchars($task['description']) ?></td>
                            <td><?= empty($task['due_date']) ? "No Deadline" : htmlspecialchars($task['due_date']) ?></td>
                            <td><?= $status_map[$task['status']] ?? 'Unknown' ?></td>
                            <td>
                                <a href="edit-task.php?id=<?= urlencode($task['id']) ?>" class="edit-btn">Edit</a>
                                <a href="delete-task.php?id=<?= urlencode($task['id']) ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h3>Empty</h3>
            <?php } ?>
        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navList li:nth-child(4)");
        active.classList.add("active");
    </script>
</body>
</html>
