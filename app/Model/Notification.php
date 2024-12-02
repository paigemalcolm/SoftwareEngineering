<?php  

// Function to get all notifications for a specific user
function get_all_my_notifications($conn, $id) {
    $sql = "SELECT * FROM notifications WHERE recipient = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
}

// Function to count unread notifications for a user
function count_notification($conn, $id) {
    $sql = "SELECT id FROM notifications WHERE recipient = ? AND is_read = 0";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->rowCount();
}

// Function to insert a new notification
function insert_notification($conn, $notif_data) {
    $sql = "INSERT INTO notifications (message, recipient, type, date, is_read) 
            VALUES (:message, :recipient, :type, :date, :is_read)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':message', $notif_data['message'], PDO::PARAM_STR);
    $stmt->bindValue(':recipient', $notif_data['recipient'], PDO::PARAM_INT);
    $stmt->bindValue(':type', $notif_data['type'], PDO::PARAM_STR);
    $stmt->bindValue(':date', $notif_data['date'], PDO::PARAM_STR);
    $stmt->bindValue(':is_read', $notif_data['is_read'], PDO::PARAM_INT);

    try {
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Insert Error: " . $e->getMessage());
        return false;
    }
}

// Function to mark a specific notification as read
function notification_make_read($conn, $recipient_id, $notification_id) {
    $sql = "UPDATE notifications SET is_read = 1 WHERE id = ? AND recipient = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$notification_id, $recipient_id]);
}
?>
