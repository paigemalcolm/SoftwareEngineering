<?php 
session_start();

if (isset($_SESSION['id'])) {   

    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['status']) && isset($_POST['due_date'])) {
        include "../DB_connection.php";
        
        
        function validate_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        // Validate input
        $title = validate_input($_POST['title']);
        $description = validate_input($_POST['description']);
        $status = validate_input($_POST['status']);  // Status field added
        $due_date = validate_input($_POST['due_date']);
        
        
        if (empty($title)) {
            $em = "Title is required";
            header("Location: ../create_task.php?error=" . urlencode($em));
            exit();
        } elseif (empty($description)) {
            $em = "Description is required";
            header("Location: ../create_task.php?error=" . urlencode($em));
            exit();
        } else {
            
            $created_by = $_SESSION['id']; 
        
            include "Model/Task.php";
            include "Model/Notification.php";
        
            
            $status = empty($status) ? 'pending' : $status;
        
            
            $data = array($title, $description, $status, $due_date, $created_by);
        
            try {
                 
                insert_task($conn, $data);

                
                $notif_data = array(
                    'message' => "$title: A new task has been created", 
                    'recipient' => $created_by, 
                    'type' => 'New Task Created', 
                    'date' => date('Y-m-d H:i:s'), 
                    'is_read' => 0 
                );
                
                // Insert notification into the database
                insert_notification($conn, $notif_data);
            
        
                $em = "Task created successfully";
                header("Location: ../create_task.php?success=" . urlencode($em));
                exit();
            } catch (Exception $e) {
                
                $em = "Error occurred: " . $e->getMessage();
                header("Location: ../create_task.php?error=" . urlencode($em));
                exit();
            }
        }
    
    } else {
        
        $em = "Unknown error occurred";
        header("Location: ../create_task.php?error=" . urlencode($em));
        exit();
    }

} else { 
    
    header("Location: ../create_task.php");
    exit();
}
?>
