<?php
    if (!isset($_SESSION)){
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['logout']) && $_POST['logout'] == "true") {
            session_unset();
            session_destroy();
            header('Location: index.php');
            exit;
        } 
    }
    
?>

<form action="logout.php" method="post">
    <input type="hidden" name="logout" value="true">
    <button type="submit" class="logout">Logout</button>
</form>