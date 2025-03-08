<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{
  public function __construct(private Database $db) {}

  public function createExpense(array $formData)
  {
    $this->db->query(
      "INSERT INTO expense (user_id, amount, date, comment)
       VALUES (:user_id, :amount, :date, :comment)",
      [
        'user_id' => $_SESSION['user'],
        'amount' => $formData['amount'],
        'date' => $formData['date'],
        'comment' => $formData['comment']
      ]
    );
  }

  public function createIncome(array $formData)
  {
    $this->db->query(
      "INSERT INTO income (user_id, amount, date, comment)
       VALUES (:user_id, :amount, :date, :comment)",
      [
        'user_id' => $_SESSION['user'],
        'amount' => $formData['amount'],
        'date' => $formData['date'],
        'comment' => $formData['comment']
      ]
    );
  }
}
