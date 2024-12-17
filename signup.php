<?php

include('db.php');

$name = $email = $password = $confirm_password = "";
$name_err = $email_err = $password_err = $confirm_password_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
       
    }

    if (empty(trim($_POST["confirm-password"]))) {
        $confirm_password_err = "Please confirm your password.";
    } else {
        $confirm_password = trim($_POST["confirm-password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Passwords did not match.";
        }
    }

    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $email_err = "This email is already taken.";
                } else {
                  
                    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

                    if ($stmt = $conn->prepare($sql)) {
                    
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        $stmt->bind_param("sss", $name, $email, $password_hash);
                        if ($stmt->execute()) {
                            
                            header("location: login.php"); 
                            exit();
                        } else {
                            echo "Something went wrong. Please try again later.";
                        }
                    }
                }
            }
            $stmt->close();
        }
    }

    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="signup-container">
        <h2>Create an Account</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="signup-form">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
                <span class="error"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                <span class="error"><?php echo $confirm_password_err; ?></span>
            </div>
            <button type="submit" class="submit-btn">Sign Up</button>
            
            <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>
