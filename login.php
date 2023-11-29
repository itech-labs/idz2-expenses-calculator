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
            } else {
                $_SESSION['tmpMessage'] = 'Invalid password. Try again';
            }
        } else {
            $_SESSION['tmpMessage'] = 'User not found. Try again';
        }
        header('Location: index.php');
        exit;
    }
?>

<form action="login.php" method="post">
    <h2>Login</h2>
    <?php 
        if(isset($_SESSION['tmpMessage'])) {
            echo "<p>{$_SESSION['tmpMessage']}</p> <br>";
            unset($_SESSION['tmpMessage']);
        }
    ?>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Login</button>
</form>