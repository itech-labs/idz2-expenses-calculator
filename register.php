<?php
    if (!isset($_SESSION)){
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $data = "$username,$hashed_password\n";
        file_put_contents('users_data.txt', $data, FILE_APPEND);

        header('Location: index.php');
    }
?>

<form action="register.php" method="post">
    <h2>Register</h2>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Register</button>
    <a href="index.php">Back</a>
</form>