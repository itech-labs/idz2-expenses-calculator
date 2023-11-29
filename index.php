<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Expense Calculator</title>
</head>
<body>
    <!-- // TODO: check if username already exists -->
    <div class="container">
        <h1>Expense Calculator</h1>
        <?php
            session_start();
            
            if (isset($_SESSION['login'])) {
                include('expenses.php');
                echo '<form action="logout.php" method="post">';
                echo '<button type="submit">Logout</button>';
                echo '</form>';
            } else {
                if (isset($_GET['action']) && $_GET['action'] == 'register') {
                    include('register.php');
                } else {
                    include('login.php');
                    echo '<br><a href="index.php?action=register">Register</a>';
                }
            }
        ?>
    </div>
</body>
</html>