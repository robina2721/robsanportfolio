<?php
session_start();
if(!isset($_SESSION['username'])){
   session_start();
   header("location:home.html");
}

$name = $email = $phone_number =$subject=$comment= "";
$name_error = $email_error = $phone_number_error =$subject_error=$comment_error= "";


$servername = "localhost"; 
$dbusername = "root"; 
$dbpassword = "password"; 
$dbname = "robinadb"; 

$con=mysqli_connect("localhost","root","","robinadb");
if(!$con)
{
    echo"failed to connect";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $name_error = "Name is required";
    } else {
        $name = validate_input($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $email_error = "Email is required";
    } else {
        $email = validate_input($_POST["email"]);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Invalid email format";
        }
    }
   
    if (empty($_POST["phone_number"])) {
        $phone_number__error = "Message is required";
    } else {
        $phone_number = validate_input($_POST["phone_number"]);
    }

   
    if (empty($_POST["subject"])) {
        $subject_error = "Message is required";
    } else {
        $subject = validate_input($_POST["subject"]);
    }

    
    if (empty($_POST["comment"])) {
        $comment_error = "Message is required";
    } else {
        $comment = validate_input($_POST["comment"]);
    }

   
    if (empty($name_error) && empty($email_error) && empty($phone_number_error) && empty($subject_error) && empty($comment_error)) {
        
        $sql = "INSERT INTO contact (name, email,phone_number,subject,comment) VALUES ('$name', '$email', '$phone_number', '$subject','$comment')";

        if (mysqli_query($con, $sql)) {
          
            echo "Comment submitted successfully";
        } else {
            
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
}


$con->close();

function validate_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>