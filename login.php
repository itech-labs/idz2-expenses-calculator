<?php 
    if (!isset($_SESSION)) {
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

    $usersData = getUsersData();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $enteredUsername = $_POST['username'];
        $enteredPassword = $_POST['password'];

        if (isset($usersData[$enteredUsername])){
            $storedPasswordHash = $usersData[$enteredUsername];

            if (password_verify($enteredPassword, $storedPasswordHash)) {
                $_SESSION['login'] = $enteredUsername;
                header('Location: index.php');
                exit;
            } else {
                echo 'Invalid password';
            }
        } else {
            echo 'User not found';
        }
        
    }
?>

<form action="login.php" method="post">
    <h2>Login</h2>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Login</button>
</form>