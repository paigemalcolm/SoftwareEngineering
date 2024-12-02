<?php
session_start();
if (isset($_SESSION['id'])) {
    include "../DB_connection.php";
    include "../app/Model/User.php";

   
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['full_name'], $_POST['user_name'], $_POST['password'], $_POST['id'])) {
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['user_name'];
        $password = $_POST['password'];

       
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $update_result = update_user($conn, [$full_name, $username, $hashed_password, $id]);

        if ($update_result) {
           
            header("Location: ../edit-user.php?id=$id&success=Profile updated successfully");
        } else {
            
            header("Location: ../edit-user.php?id=$id&error=Error updating profile");
        }
        exit();
    } else {
        
        header("Location: ../edit-user.php?id=" . $_POST['id'] . "&error=Missing form data");
        exit();
    }
} else {
   
    header("Location: login.php");
    exit();
}
?>
