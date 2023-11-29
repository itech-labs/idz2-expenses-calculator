<?php
    if (!isset($_SESSION)){
        session_start();
    }

    function getUsersData() {
        $file = 'users_data.txt';
    
        if (file_exists($file)) {
            $contents = file_get_contents($file);
            $lines = explode("\n", $contents);
            $usersData = [];
    
            foreach ($lines as $line) {
                $userData = explode(',', $line);
                if (count($userData) === 2) {
                    $usersData[$userData[0]] = $userData[1];
                }
            }
    
            return $usersData;
        }
    
        return [];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $tmpMessageObj = new stdClass();

        $usersData = getUsersData();
        if (isset($usersData[$username])) {
            $tmpMessageObj->description = 'Username already exists. Please choose another one.';
            $tmpMessageObj->type = 'error';
            $_SESSION['tmpMessage'] = json_encode($tmpMessageObj);
            header('Location: index.php');
            exit;
        }

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