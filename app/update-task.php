<?php 
session_start();

if (isset($_SESSION['id'])) {  

    if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['status']) && isset($_POST['due_date'])) {
        include "../DB_connection.php";
        function validate_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Validate and sanitize input
        $title = validate_input($_POST['title']);
        $description = validate_input($_POST['description']);
        $status = validate_input($_POST['status']);  
        $id = validate_input($_POST['id']);
        $due_date = validate_input($_POST['due_date']);

        // Input validation
        if (empty($title)) {
            $em = "Title is required";
            header("Location: ../edit-task.php?error=" . urlencode($em) . "&id=$id");
            exit();
        } elseif (empty($description)) {
            $em = "Description is required";
            header("Location: ../edit-task.php?error=" . urlencode($em) . "&id=$id");
            exit();
        } elseif (empty($status)) {  
            $em = "Status is required";
            header("Location: ../edit-task.php?error=" . urlencode($em) . "&id=$id");
            exit();
        } else {
            include "Model/Task.php";

           
            $sql = "SELECT id FROM tasks WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                $em = "Task not found";
                header("Location: ../edit-task.php?error=" . urlencode($em) . "&id=$id");
                exit();
            }

            // Update the task
            $data = array($title, $description, $status, $due_date, $id);
            update_task($conn, $data);  

            $em = "Task updated successfully";
            header("Location: ../edit-task.php?success=" . urlencode($em) . "&id=$id");
            exit();
        }
    } else {
        $em = "Unknown error occurred";
        header("Location: ../edit-task.php?error=" . urlencode($em));
        exit();
    }
} else { 
    $em = "First login";
    header("Location: ../login.php?error=" . urlencode($em));
    exit();
}
?>
