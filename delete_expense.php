<?php
    
    if (!isset($_SESSION)){
        session_start();
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

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $file_name = "expensesData\\{$_SESSION['login']}.txt";

        $oldExpenses = parseExpensesData($_SESSION['login']);
        $updatedData = '';
        foreach ($oldExpenses as $expense) {
            if($expense['id'] != $id){
                $updatedData .= "{$expense['name']},{$expense['amount']},{$expense['id']}\n";
            }
        }
        file_put_contents($file_name, $updatedData);

        header('Location: index.php');
        exit;
    }
?>
