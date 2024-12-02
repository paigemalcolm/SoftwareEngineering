<?php 

function insert_task($conn, $data) {
    // Insert a new task into the database
    $sql = "INSERT INTO tasks (title, description, status_id, due_date, created_by) VALUES(?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

function get_tasks_by_condition($conn, $condition = '') {
    
    $sql = "SELECT * FROM tasks WHERE 1=1 " . $condition . " ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([]);
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
}

function count_tasks($conn) {
    // Count total tasks
    $sql = "SELECT COUNT(*) FROM tasks";
    $stmt = $conn->prepare($sql);
    $stmt->execute([]);
    return $stmt->fetchColumn();
}

function count_tasks_due_today($conn) {
    $sql = "SELECT COUNT(*) FROM tasks WHERE due_date = CURDATE() AND status_id != (SELECT id FROM status WHERE name = 'completed')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function count_tasks_overdue($conn) {
    // Count overdue tasks
    $sql = "SELECT COUNT(*) FROM tasks WHERE due_date < CURDATE() AND status_id != (SELECT id FROM status WHERE name = 'completed')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([]);
    return $stmt->fetchColumn();
}

function count_tasks_NoDeadline($conn) {
    // Count tasks that have no deadline
    $sql = "SELECT COUNT(*) FROM tasks WHERE status_id != (SELECT id FROM status WHERE name = 'completed') AND (due_date IS NULL OR due_date = '0000-00-00')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([]);
    return $stmt->fetchColumn();
}

function delete_task($conn, $data) {
    // Delete task by ID
    $sql = "DELETE FROM tasks WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    return $stmt->rowCount() > 0;
}

function update_task($conn, $data) {
    
    $sql = "UPDATE tasks SET title = ?, description = ?, status_id = ?, due_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

function update_task_status($conn, $data) {
    try {
        
        if (count($data) !== 2) {
            throw new Exception("Data array must contain exactly 2 elements: status_id and task id.");
        }

        $sql = "UPDATE tasks SET status_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);

        return $stmt->rowCount() > 0; 
    } catch (PDOException $e) {
        error_log($e->getMessage());  
        echo "Error: " . $e->getMessage();
        return false;
    } catch (Exception $e) {
        error_log($e->getMessage());  
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function get_task_by_id($conn, $id) {
    // Fetch a task by its ID
    $sql = "SELECT * FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return ($stmt->rowCount() > 0) ? $stmt->fetch() : null;
}

function get_all_tasks($conn) {
    // Get all tasks
    return get_tasks_by_condition($conn, ''); 
}

function get_all_tasks_due_today($conn) {
    // Get tasks that are due today
    return get_tasks_by_condition($conn, "AND due_date = CURDATE() AND status_id != (SELECT id FROM status WHERE name = 'completed')");
}

function get_all_tasks_overdue($conn) {
    // Get tasks that are overdue
    return get_tasks_by_condition($conn, "AND due_date < CURDATE() AND status_id != (SELECT id FROM status WHERE name = 'completed')");
}

function get_all_tasks_NoDeadline($conn) {
    // Get tasks that have no deadline
    return get_tasks_by_condition($conn, "AND (due_date IS NULL OR due_date = '0000-00-00') AND status_id != (SELECT id FROM status WHERE name = 'completed')");
}

function get_all_tasks_by_id($conn, $user_id) {
    $sql = "SELECT * FROM tasks WHERE created_by = ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

function count_my_tasks($conn, $id) {
    // Count tasks created by a specific user
    $sql = "SELECT COUNT(*) FROM tasks WHERE created_by = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

function count_my_tasks_due_today($conn, $id) {
    // Count tasks due today for a specific user
    $sql = "SELECT COUNT(*) FROM tasks WHERE created_by = ? AND due_date = CURDATE() AND status_id != (SELECT id FROM status WHERE name = 'completed')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

function count_my_tasks_overdue($conn, $id) {
    // Count overdue tasks for a specific user
    $sql = "SELECT COUNT(*) FROM tasks WHERE created_by = ? AND due_date < CURDATE() AND status_id != (SELECT id FROM status WHERE name = 'completed')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

function count_my_tasks_NoDeadline($conn, $id) {
    // Count tasks with no deadline for a specific user
    $sql = "SELECT COUNT(*) FROM tasks WHERE created_by = ? AND (due_date IS NULL OR due_date = '0000-00-00') AND status_id != (SELECT id FROM status WHERE name = 'completed')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

function count_my_pending_tasks($conn, $id) {
    $sql = "
        SELECT COUNT(*) 
        FROM tasks 
        WHERE created_by = ? AND status_id = (SELECT id FROM status WHERE name = 'pending')
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

function count_my_in_progress_tasks($conn, $id){
    $sql = "
        SELECT COUNT(*) 
        FROM tasks t
        INNER JOIN status s ON t.status_id = s.id
        WHERE s.name = 'in_progress' AND t.created_by = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

function count_my_completed_tasks($conn, $id){
    $sql = "
        SELECT COUNT(*) 
        FROM tasks t
        INNER JOIN status s ON t.status_id = s.id
        WHERE s.name = 'completed' AND t.created_by = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

?>

