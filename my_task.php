<?php
session_start();
if (isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

    // Fetch tasks specific to the logged-in user by default
    $tasks = get_all_tasks_by_id($conn, $_SESSION['id']);

    // Status mapping
    $status_map = [
        1 => 'Pending',
        2 => 'In Progress',
        3 => 'Completed'
    ];
} else {
    // Redirect to login if session is not found
    $em = "Please log in first!";
    header("Location: login.php?error=$em");
    exit();
}

// Check for task filters based on due date
$text = "All Tasks";
$num_task = 0;

if (isset($_GET['due_date'])) {
    if ($_GET['due_date'] == "Due Today") {
        $text = "Due Today";
        $tasks = get_all_tasks_due_today_by_user($conn, $_SESSION['id']);
        $num_task = count_tasks_due_today_by_user($conn, $_SESSION['id']);
    } elseif ($_GET['due_date'] == "Overdue") {
        $text = "Overdue";
        $tasks = get_all_tasks_overdue_by_user($conn, $_SESSION['id']);
        $num_task = count_tasks_overdue_by_user($conn, $_SESSION['id']);
    } elseif ($_GET['due_date'] == "No Deadline") {
        $text = "No Deadline";
        $tasks = get_all_tasks_NoDeadline_by_user($conn, $_SESSION['id']);
        $num_task = count_tasks_NoDeadline_by_user($conn, $_SESSION['id']);
    }
} else {
    $tasks = get_all_tasks_by_id($conn, $_SESSION['id']);
    $num_task = count_my_tasks($conn, $_SESSION['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
   <title>My Tasks</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <input type="checkbox" id="checkbox">
   <?php include "inc/header.php"; ?>
   <div class="body">
       <?php include "inc/nav.php"; ?>
       <section class="section-1">
           <h4 class="title">My Tasks - <?= htmlspecialchars($text) ?></h4>
           <?php if (isset($_GET['success'])) { ?>
               <div class="success" role="alert">
                   <?= stripcslashes($_GET['success']); ?>
               </div>
           <?php } ?>

           <?php if (!empty($tasks)) { ?>
               <table class="main-table">
                   <tr>
                       <th>#</th>
                       <th>Title</th>
                       <th>Description</th>
                       <th>Status</th>
                       <th>Due Date</th>
                       <th>Action</th>
                   </tr>
                   <?php $i = 0; foreach ($tasks as $task) { ?>
                       <tr>
                           <td><?= ++$i ?></td>
                           <td><?= htmlspecialchars($task['title']) ?></td>
                           <td><?= htmlspecialchars($task['description']) ?></td>
                           <td><?= $status_map[$task['status_id']] ?? 'Unknown' ?></td>
                           <td><?= htmlspecialchars($task['due_date']) ?></td>
                           <td>
                               <a href="edit-task.php?id=<?= htmlspecialchars($task['id']) ?>" class="edit-btn">Edit</a>
                               <a href="delete-task.php?id=<?= htmlspecialchars($task['id']) ?>" class="delete-btn" 
                                  onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                           </td>
                       </tr>
                   <?php } ?>
               </table>
           <?php } else { ?>
               <h3>No tasks available</h3>
           <?php } ?>
       </section>
   </div>

<script type="text/javascript">
   var active = document.querySelector("#navList li:nth-child(2)");
   active.classList.add("active");
</script>

</body>
</html>
<?php 
exit();
?>
