<?php 
session_start();


if (isset($_SESSION['id'])) { 
    include "DB_connection.php";  
    include "app/Model/User.php"; 

    
    $users = get_all_users($conn);  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php"; ?>
    <div class="body">
        <?php include "inc/nav.php"; ?>
        <section class="section-1">
            <h4 class="title">Create Task</h4>
            <form class="form-1" method="POST" action="app/add-task.php">
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
                    <input type="text" name="title" class="input-1" placeholder="Title" required><br>
                </div>
                <div class="input-holder">
                    <label>Description</label>
                    <textarea name="description" class="input-1" placeholder="Description"></textarea><br>
                </div>
                <div class="input-holder">
                    <label>Due Date</label>
                    <input type="date" name="due_date" class="input-1"><br>
                </div>
                <div class="input-holder">
                    <label>Status</label>
                    <select name="status" class="input-1" required>
                        <option value="" disabled selected>Select status</option>
                        <option value="1">Pending</option>
                        <option value="2">In Progress</option>
                        <option value="3">Completed</option>
                    </select><br>
                </div>
                <button type="submit" class="edit-btn">Create Task</button>
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
    
    header("Location: login.php");
    exit();
} 
?>
