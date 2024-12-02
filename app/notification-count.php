<?php
session_start();
include "../DB_connection.php";

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Query to get the count of unread notifications
    $sql = "SELECT COUNT(*) AS unread_count FROM notifications WHERE recipient = :user_id AND is_read = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the result and echo the unread count
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $result['unread_count'];
} else {
    echo "0";  // If the user is not logged in
}
?>
