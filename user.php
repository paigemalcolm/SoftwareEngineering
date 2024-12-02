<?php 
session_start();

if (isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/User.php";

    
    $user = get_user_by_id($conn, $_SESSION['id']); 

    if (!$user) { 
        $em = "User not found.";
        header("Location: login.php?error=$em");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php"; ?>
    <div class="body">
        <?php include "inc/nav.php"; ?>
        <section class="section-1">
            
            <?php if (isset($_GET['success'])) { ?>
                <div class="success">
                    <?php echo stripcslashes($_GET['success']); ?>
                </div>
            <?php } ?>
            
            <table class="main-table">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td>
                        <a href="edit-user.php?id=<?= $user['id'] ?>" class="edit-btn">Edit</a>
                        
                    </td>
                </tr>
            </table>
        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navList li:nth-child(2)");
        active.classList.add("active");
    </script>
</body>
</html>
<?php 
} else {
    // Redirect to login if session not set
    $em = "Please login first.";
    header("Location: login.php?error=$em");
    exit();
}
?>
