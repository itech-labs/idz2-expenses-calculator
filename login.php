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
        $tmpMessageObj = new stdClass();

        if (isset($usersData[$enteredUsername])){
            $storedPasswordHash = $usersData[$enteredUsername];

            if (password_verify($enteredPassword, $storedPasswordHash)) {
                $_SESSION['login'] = $enteredUsername;
            } else {
                $tmpMessageObj->description = 'Invalid password. Try again';
                $tmpMessageObj->type = 'error';
                $_SESSION['tmpMessage'] = json_encode($tmpMessageObj);
            }
        } else {
            $tmpMessageObj->description = 'User not found. Try again';
            $tmpMessageObj->type = 'error';
            $_SESSION['tmpMessage'] = json_encode($tmpMessageObj);
        }
        header('Location: index.php');
        exit;
    }
?>

<form action="login.php" method="post">
    <h2>Login</h2>
    <?php 
        if(isset($_SESSION['tmpMessage'])) {
            $tmpMessageObj = json_decode($_SESSION['tmpMessage']);
            if($tmpMessageObj->type == "error"){
                echo "<p class='error'>";
            } else {
                echo "<p class='success'>";
            }
            echo "{$tmpMessageObj->description}</p> <br>";

            unset($_SESSION['tmpMessage']);
        }
    ?>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>