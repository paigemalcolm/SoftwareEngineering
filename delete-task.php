<?php 
session_start();
if (isset($_SESSION['id'])) {  
    include "DB_connection.php";
    include "app/Model/Task.php";
    
    if (!isset($_GET['id'])) {
         header("Location: tasks.php");
         exit();
    }
    $id = $_GET['id'];
    $task = get_all_tasks($conn);

    if ($task == 0) {
         header("Location: tasks.php");
         exit();
    }

    
    $data = array($id);
    delete_task($conn, $data);
    $sm = "Deleted Successfully";
    header("Location: my_task.php?success=$sm");
    exit();

} else { 
    
    header("Location: login.php");
    exit();
}
?>
