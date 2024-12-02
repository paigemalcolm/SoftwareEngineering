<?php
session_start();
include 'DB_connection.php'; 

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $full_name = $_POST['full_name'];
    $username = $_POST['user_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    
    if (empty($full_name) || empty($username) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required!";
        header("Location: signup.php?error=" . urlencode($error));
        exit();
    }

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
        header("Location: signup.php?error=" . urlencode($error));
        exit();
    }

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        // Username already exists
        $error = "Username is already taken!";
        header("Location: signup.php?error=" . urlencode($error));
        exit();
    }
    
    
    $stmt = $conn->prepare("INSERT INTO users (full_name, username, password) VALUES (:full_name, :username, :password)");
    $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Success
        $success = "User registered successfully!";
        header("Location: signup.php?success=" . urlencode($success));
        exit();
    } else {
        // Failed to insert user
        $error = "An error occurred while registering the user!";
        header("Location: signup.php?error=" . urlencode($error));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Task Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #639273; /* Light blue background */
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            background-color: #b7fdcf;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h4 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group input:focus {
            outline-color: #4b93d8;
        }

        .btn {
            width: 100%;
            background-color: #4b93d8;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #2c6fbf;
        }

        .help-block {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-center a {
            text-decoration: none;
            color: #4b93d8;
        }

        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h4>User Signup</h4>
        <form method="POST" action="signup.php">
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" id="full_name" placeholder="Full Name" required>
            </div>

            <div class="form-group">
                <label for="user_name">Username</label>
                <input type="text" name="user_name" id="user_name" placeholder="Username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
            </div>

            <button type="submit" class="btn">Sign Up</button>

            <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
