<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Calculator</title>
</head>
<body>
    <h1>Expense Calculator</h1>
    <?php
        session_start();
        
        if (isset($_SESSION['login'])) {
            include('expenses.php');
        } else {
            if (isset($_GET['action']) && $_GET['action'] == 'register') {
                include('register.php');
            } else {
                include('login.php');
                echo '<br><a href="index.php?action=register">Register</a>';
            }
        }
    ?>
</body>
</html>