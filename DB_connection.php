<?php  

$sName = "localhost";  // Server name
$uName = "new_task";       // Username
$pass  = "";           // Password
$db_name = "new_task_db";  // Database name

try {
   
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
