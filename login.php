<?php 
session_start();
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

include 'DB_connection.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = $_POST['user_name'];
    $password = $_POST['password'];

    
    if (empty($username) || empty($password)) {
        $error = "Username and Password are required!";
        header("Location: login.php?error=$error");
        exit();
    }

   
   $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
   $stmt->bindParam(1, $username, PDO::PARAM_STR);
   $stmt->execute();

 
 if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


       
        if (password_verify($password, $user['password'])) {
          
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: index.php");
            exit();
        } else {
            
            $error = "Incorrect password.";
            header("Location: login.php?error=$error");
            exit();
        }
    } else {
      
        $error = "No user found with that username.";
        header("Location: login.php?error=$error");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TASK MANAGEMENT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        body {
            margin: 10;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #639273; 
        }

        .login-body form {
            width: 100%;
            max-width: 400px; 
            background-color: #b7fdcf;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: bold;
        }

        .btn {
            width: 100%; 
        }

        .help-block {
            text-align: right; 
        }
    </style>
</head>
<body class="login-body d-flex align-items-center justify-content-center">
    <form method="POST" action="login.php" class="shadow">
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php } ?>

        <div class="form-group mb-3">
            <label for="user_name" class="form-label">User Name</label>
            <input type="text" class="form-control" name="user_name" id="user_name" required>
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        
        <button type="submit" name="login" class="btn btn-info">LOGIN</button>
        <div class="mt-3 text-center">
            <a href="signup.php">Sign up here</a>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html> 

