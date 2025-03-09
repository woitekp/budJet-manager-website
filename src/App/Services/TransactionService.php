<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{
  public function __construct(private Database $db) {}

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
      "INSERT INTO expense (user_id, user_expense_category_id, user_payment_method_id, amount, date, comment)
       VALUES (:user_id, :user_expense_category_id, :user_payment_method_id, :amount, :date, :comment)",
      [
        'user_id' => $_SESSION['user'],
        'user_expense_category_id' => $userExpenseCategoryId,
        'user_payment_method_id' => $userPaymentMethod,
        'amount' => $formData['amount'],
        'date' => $formData['date'],
        'comment' => $formData['comment']
      ]
    );
  }

  public function getUserExpenses()
  {
    return $this->db->query(
      "SELECT * FROM expense where user_id = :user_id",
      [
        'user_id' => $_SESSION['user']
      ]
    )->findall();
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

  public function getuserPaymentMethods()
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

  public function createIncome(array $formData)
  {
    $userIncomeCategoryId = $this->db->query(
      "SELECT id FROM user_income_category WHERE name = :category and user_id = :user_id",
      [
        'category' => $formData['category'],
        'user_id' => $_SESSION['user']
      ]
    )->find()['id'];

    $this->db->query(
      "INSERT INTO income (user_id, user_income_category_id, amount, date, comment)
       VALUES (:user_id, :user_income_category_id, :amount, :date, :comment)",
      [
        'user_id' => $_SESSION['user'],
        'user_income_category_id' => $userIncomeCategoryId,
        'amount' => $formData['amount'],
        'date' => $formData['date'],
        'comment' => $formData['comment']
      ]
    );
  }

  public function getUserIncomes()
  {
    return $this->db->query(
      "SELECT * FROM income where user_id = :user_id",
      [
        'user_id' => $_SESSION['user']
      ]
    )->findall();
  }

  public function getUserIncomeCategories()
  {
    $categories = array();
    $query = $this->db->query(
      "SELECT name FROM user_income_category WHERE user_id = :user",
      [
        'user' => $_SESSION['user']
      ]
    );
    while ($row = $query->find()) {
      array_push($categories, $row['name']);
    }

    return $categories;
  }
}
