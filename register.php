<?php
    if (!isset($_SESSION)){
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $tmpMessageObj = new stdClass();

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $data = "$username,$hashed_password\n";
        file_put_contents('users_data.txt', $data, FILE_APPEND);

        $tmpMessageObj->description = 'Registration was successful!';
        $tmpMessageObj->type = 'success';
        $_SESSION['tmpMessage'] = json_encode($tmpMessageObj);
        header('Location: index.php');
        exit;
    }
?>

<form action="register.php" method="post">
    <h2>Register</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
    <br>
    <a href="index.php">Back</a>
</form>