<?php 

function get_all_users($conn){
	$sql = "SELECT * FROM users";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	// Return an empty array if no users are found
	return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
}


function insert_user($conn, $data){
	$sql = "INSERT INTO users (full_name, username, password) VALUES(?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}

function update_user($conn, $data) {
    $sql = "UPDATE users SET full_name = ?, username = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Execute the query with the provided data
    $stmt->execute($data);

    // Return true if the update was successful, false otherwise
    return $stmt->rowCount() > 0;
}



function delete_user($conn, $data){
	$sql = "DELETE FROM users WHERE id=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}

function get_user_by_id($conn, $id){
	$sql = "SELECT * FROM users WHERE id =?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	// Return user data if found, otherwise return an empty array
	return ($stmt->rowCount() > 0) ? $stmt->fetch() : [];
}

function update_profile($conn, $data){
	$sql = "UPDATE users SET full_name=?, password=? WHERE id=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}

function count_users($conn) {
    // Query to select all user IDs from the users table
    $sql = "SELECT id FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    
    return $stmt->rowCount(); 
}

?>
