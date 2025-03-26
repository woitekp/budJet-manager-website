<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class ExpenseService
{
  public function __construct(private Database $db) {}

  public function getUserExpenses(int $length, int $offset, string $searchTerm)
  {
    $params = [
      'user_id' => $_SESSION['user'],
      'description' => "%{$searchTerm}%"
    ];

    return $this->db->query(
      "SELECT expense.id, DATE_FORMAT(expense.date, '%Y-%m-%d') as date, expense.amount as amount, user_expense_category.name as category,  user_payment_method.name as payment, expense.description as description,
      ROW_NUMBER() OVER (ORDER BY expense.date, expense.id) AS ordinal_number,
      count(*) OVER() AS records_count
      FROM expense
      JOIN user_expense_category
      ON expense.user_expense_category_id = user_expense_category.id
      JOIN user_payment_method
      ON expense.user_payment_method_id = user_payment_method.id
      WHERE expense.user_id = :user_id AND description LIKE :description
      ORDER BY expense.date DESC, expense.id DESC
      LIMIT {$length} OFFSET {$offset}",
      $params
    )->findall();
  }

  public function createExpense(array $formData)
  {
    $userExpenseCategoryId = $this->db->query(
      "SELECT id FROM user_expense_category WHERE name = :category and user_id = :user_id",
      [
        'category' => $formData['category'],
        'user_id' => $_SESSION['user']
      ]
    )->find()['id'];

    $userPaymentMethod = $this->db->query(
      "SELECT id FROM user_payment_method WHERE name = :payment and user_id = :user_id",
      [
        'payment' => $formData['payment'],
        'user_id' => $_SESSION['user']
      ]
    )->find()['id'];

    $this->db->query(
      "INSERT INTO expense (user_id, user_expense_category_id, user_payment_method_id, amount, date, description)
       VALUES (:user_id, :user_expense_category_id, :user_payment_method_id, :amount, :date, :description)",
      [
        'user_id' => $_SESSION['user'],
        'user_expense_category_id' => $userExpenseCategoryId,
        'user_payment_method_id' => $userPaymentMethod,
        'amount' => $formData['amount'],
        'date' => $formData['date'],
        'description' => $formData['description']
      ]
    );
  }

  public function getUserExpenseCategories()
  {
    $categories = array();
    $query = $this->db->query(
      "SELECT name FROM user_expense_category WHERE user_id = :user",
      [
        'user' => $_SESSION['user']
      ]
    );
    while ($row = $query->find()) {
      array_push($categories, $row['name']);
    }

    return $categories;
  }

  public function getUserPaymentMethods()
  {
    $paymentMethods = array();
    $query = $this->db->query(
      "SELECT name FROM user_payment_method WHERE user_id = :user",
      [
        'user' => $_SESSION['user']
      ]
    );
    while ($row = $query->find()) {
      array_push($paymentMethods, $row['name']);
    }

    return $paymentMethods;
  }
  
  public function getUserExpense(string $expenseId)
  {
    return $this->db->query(
      "SELECT expense.id, DATE_FORMAT(expense.date, '%Y-%m-%d') as date, expense.amount as amount, user_expense_category.name as category, user_payment_method.name as payment, expense.description as description
      FROM expense
      JOIN user_expense_category
      ON expense.user_expense_category_id = user_expense_category.id
      JOIN user_payment_method
      ON expense.user_payment_method_id = user_payment_method.id
      WHERE expense.id = :id AND expense.user_id = :user_id",
      [
        'id' => (int) $expenseId,
        'user_id' => $_SESSION['user']
      ]
    )->find();
  }

  public function updateExpense(array $formData, int $expenseId)
  {
    $userExpenseCategoryId = $this->db->query(
      "SELECT id FROM user_expense_category WHERE name = :category and user_id = :user_id",
      [
        'category' => $formData['category'],
        'user_id' => $_SESSION['user']
      ]
    )->find()['id'];
    
    $userPaymentMethodId = $this->db->query(
      "SELECT id FROM user_payment_method WHERE name = :payment and user_id = :user_id",
      [
        'payment' => $formData['payment'],
        'user_id' => $_SESSION['user']
      ]
    )->find()['id'];


    $this->db->query(
      "UPDATE expense
      SET user_expense_category_id = :user_expense_category_id,
          user_payment_method_id = :user_payment_method_id,  
          amount = :amount,
          date = :date,
          description = :description
      WHERE id = :id AND user_id = :user_id",
      [
        'user_expense_category_id' => $userExpenseCategoryId,
        'user_payment_method_id' => $userPaymentMethodId,
        'amount' => $formData['amount'],
        'date' => $formData['date'],
        'description' => $formData['description'],
        'user_id' => $_SESSION['user'],
        'id' => $expenseId
      ]
    );
  }
}
