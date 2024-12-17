<?php
include('db.php');
$email = $password = "";
$email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, name, email, password FROM users WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $name, $email, $hashed_password);
                    if ($stmt->fetch()) {
                        
                        if (password_verify($password, $hashed_password)) {
                           
                            session_start();
                            $_SESSION['id'] = $id;
                            $_SESSION['name'] = $name;
                            $_SESSION['email'] = $email;
                            header("location: home.html"); 
                            exit();
                        } else {
                            $password_err = "The password you entered is incorrect.";
                        }
                    }
                } else {
                    $email_err = "No account found with that email.";
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
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body> 
    <div class="login-container"> <h2>Login to Your Account</h2> 
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="login-form"> 
        <div class="form-group"> <label for="email">Email</label> 
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
         <span class="error"><?php echo $email_err; ?></span> 
    </div> 
    <div class="form-group"> 
        <label for="password">Password</label> 
        <input type="password" id="password" name="password" required>
         <span class="error"><?php echo $password_err; ?></span>
         </div> 
         <center><button type="submit" class="submit-btn">Login</button></center>
         <br><br><br>
         <p class="signup-link">Don't have an account? <a href="signup.php">Sign up here</a></p> 
         <p class="signup-link">forgot password? <a href="customize.php">reset</a></p>


         </div>
        </form>
    
     </div>
     </body> 
</html>
