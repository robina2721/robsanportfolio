<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <link rel="stylesheet" href="css/customize.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Account Management</h1>
        </header>

        <section>
            <h2>Update Account</h2>
            <form action="account.php" method="post" class="form">
                <input type="hidden" name="action" value="update">
                <label for="id">User Email:</label>
                <input type="email" id="id" name="id" required><br>
                
                <label for="name">New Username:</label>
                <input type="text" id="name" name="name" required><br>
                
                <label for="email">New Email:</label>
                <input type="email" id="email" name="email" required><br>
                
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" required><br>
                
                <button type="submit" class="btn">Update Account</button>
            </form>
        </section>

        <section>
            <h2>Delete Account</h2>
            <form action="account.php" method="post" class="form">
                <input type="hidden" name="action" value="delete">
                <label for="delete_id">User email:</label>
                <input type="email" id="delete_id" name="id" required><br>
                
                <button type="submit" class="btn btn-danger">Delete Account</button>
            </form>
        </section>
    </div>
</body>
</html>
