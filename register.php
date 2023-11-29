<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!file_exists('users_data.txt')) {
            fopen('users_data.txt', 'w');
        }

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
</form>