<?php
session_start(); 


if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}


$inactive = 600; 
if (isset($_SESSION['timeout']) && (time() - $_SESSION['timeout']) > $inactive) {
    session_unset(); 
    session_destroy(); 
    header("Location: login.php"); 
    exit();
}
$_SESSION['timeout'] = time(); 

include "DB_connection.php";
include "app/Model/Task.php";
include "app/Model/User.php";


$num_my_task = count_my_tasks($conn, $_SESSION['id']);
$overdue_task = count_my_tasks_overdue($conn, $_SESSION['id']);
$nodeadline_task = count_my_tasks_NoDeadline($conn, $_SESSION['id']);
$pending = count_my_pending_tasks($conn, $_SESSION['id']);
$in_progress = count_my_in_progress_tasks($conn, $_SESSION['id']);
$completed = count_my_completed_tasks($conn, $_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php"; ?>
    <div class="body">
        <?php include "inc/nav.php"; ?>
        <section class="section-1">
            <div class="dashboard">
                <div class="dashboard-item">
                    <i class="fa fa-tasks"></i>
                    <span><?= htmlspecialchars($num_my_task) ?> My Tasks</span>
                </div>
                <div class="dashboard-item">
                    <i class="fa fa-window-close-o"></i>
                    <span><?= htmlspecialchars($overdue_task) ?> Overdue</span>
                </div>
                <div class="dashboard-item">
                    <i class="fa fa-clock-o"></i>
                    <span><?= htmlspecialchars($nodeadline_task) ?> No Deadline</span>
                </div>
                <div class="dashboard-item">
                    <i class="fa fa-square-o"></i>
                    <span><?= htmlspecialchars($pending) ?> Pending</span>
                </div>
                <div class="dashboard-item">
                    <i class="fa fa-spinner"></i>
                    <span><?= htmlspecialchars($in_progress) ?> In Progress</span>
                </div>
                <div class="dashboard-item">
                    <i class="fa fa-check-square-o"></i>
                    <span><?= htmlspecialchars($completed) ?> Completed</span>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
       
        var active = document.querySelector("#navList li:nth-child(1)");
        active.classList.add("active");
    </script>
</body>
</html>
