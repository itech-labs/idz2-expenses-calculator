<?php
    if (!isset($_SESSION)){
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $expense_name = $_POST['expense_name'];
        $expense_amount = $_POST['expense_amount'];
        $expense_id = uniqid();

        $data = "$expense_name,$expense_amount,$expense_id\n";
        $file_name = "expensesData\\{$_SESSION['login']}.txt";

        file_put_contents($file_name, $data, FILE_APPEND);

        header('Location: index.php');
        exit;
    }

    function parseExpensesData($username) {
        $file_name = "expensesData\\{$username}.txt";
    
        if (file_exists($file_name)) {
            $contents = file_get_contents($file_name);
            $lines = explode("\n", $contents);
            $expenses = [];
    
            foreach ($lines as $line) {
                $expenseData = explode(',', $line);
                if (count($expenseData) === 3) {
                    $expenses[] = [
                        'name' => $expenseData[0],
                        'amount' => $expenseData[1],
                        'id' => $expenseData[2]
                    ];
                }
            }
    
            return $expenses;
        }
    
        return [];
    }

    function calculateExpensesAmount($expenses) {
        $totalAmount = 0;
    
        foreach ($expenses as $expense) {
            $totalAmount += $expense['amount'];
        }
    
        return $totalAmount;
    }

    $expenses = parseExpensesData($_SESSION['login']);

    $totalAmount = calculateExpensesAmount($expenses);
?>

<div>
    <form action="expenses.php" method="post">
        <h3>Add Expense</h3>
        <input type="text" name="expense_name" placeholder="Expense name" pattern="^(?! )[^\d]*(?<=\S)$" required>
        <input type="number" min="0" name="expense_amount" placeholder="Expense amount" required>
        <button type="submit">Add Expense</button>
    </form>

    <div class="list">
        <?php
            include('logout.php');
            if (!empty($expenses)) {
                echo "<h3>Total expenses: </h3>";
                echo $totalAmount;
                echo "<h3>List of expenses</h3>";

                echo "<table>";
                echo "<tr><th>Name</th><th>Amount</th><th>Action</th></tr>";

                foreach ($expenses as $expense) {
                    echo "<tr>";
                    echo "<td>{$expense['name']}</td>";
                    echo "<td>{$expense['amount']}</td>";
                    echo "<td><a class='delete-link' href='delete_expense.php?id={$expense['id']}' onclick='return confirm(\"Are you sure you want to delete the expense: {$expense['name']}?\")'>X</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<br>";
            } else {
                echo "<p>No expenses yet.</p>";
            }
        ?>
    </div>
</div>


