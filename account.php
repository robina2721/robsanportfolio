<?php
$host = 'localhost';
$db = 'robinadb';
$user = 'root'; 
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'update') {
        $id = intval($_POST['id']);
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "UPDATE users SET name='$name', email='$email', password='$password' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            header("location: login.php");
            echo "Account updated successfully.";
        } else {
            echo "Error updating account: " . $conn->error;
        }
    } elseif ($action === 'delete') {
        $id = intval($_POST['id']);

        $sql = "DELETE FROM users WHERE email=$email";

        if ($conn->query($sql) === TRUE) {
            header("location: login.php");
            echo "Account deleted successfully.";
        } else {
            echo "Error deleting account: " . $conn->error;
        }
    }
}

$conn->close();
?>
