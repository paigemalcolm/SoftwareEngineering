<?php 
session_start();

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Notification.php";

    // Retrieve the user's ID from the session
    $id = $_SESSION['id'];

    // Fetch notifications
    $notifications = get_all_my_notifications($conn, $id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php" ?>
    <div class="body">
        <?php include "inc/nav.php" ?>
        <section class="section-1">
            <h4 class="title">All Notifications</h4>

            <?php if (isset($_GET['success'])) { ?>
                <div class="success" role="alert">
                    <?php echo htmlspecialchars(stripcslashes($_GET['success'])); ?>
                </div>
            <?php } ?>

            <?php if ($notifications && count($notifications) > 0) { ?>
                <table class="main-table">
                    <tr>
                        <th>#</th>
                        <th>Message</th>
                        <th>Type</th>
                        <th>Date</th>
                    </tr>
                    <?php $i = 0; foreach ($notifications as $notification) { ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= htmlspecialchars($notification['message']) ?></td>
                            <td><?= htmlspecialchars($notification['type']) ?></td>
                            <td><?= htmlspecialchars($notification['date']) ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h3>You have no notifications</h3>
            <?php } ?>
        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navList li:nth-child(4)");
        active.classList.add("active");
    </script>
</body>
</html>
<?php 
} else { 
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}
?>
