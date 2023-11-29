<?php
    if (!isset($_SESSION)){
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $expense_name = $_POST['expense_name'];
        $expense_amount = $_POST['expense_amount'];

        $data = "$expense_name,$expense_amount\n";
        $file_name = "expensesData\\{$_SESSION['login']}.txt";

        file_put_contents($file_name, $data, FILE_APPEND);

        header('Location: index.php');
    }
?>

<div>
    <form action="expenses.php" method="post">
        <h3>Add Expense</h3>
        <label for="expense_name">Expense Name:</label>
        <input type="text" name="expense_name" id="expense_name" required>
        <label for="expense_amount">Expense Amount:</label>
        <input type="number" min="0" name="expense_amount" id="expense_amount" required>
        <button type="submit">Add Expense</button>
    </form>
</div>


