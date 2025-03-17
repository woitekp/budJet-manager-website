<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class IncomeService
{
  public function __construct(private Database $db) {}

  public function getUserIncomes()
  {
    $searchTerm = addcslashes($_GET['s'] ?? '', '%_');

    return $this->db->query(
      "SELECT DATE_FORMAT(income.date, '%Y-%m-%d') as date, income.amount as amount, user_income_category.name as category, income.description as description,
        ROW_NUMBER() OVER (ORDER BY income.date, income.id) AS ordinal_number
       FROM income
       JOIN user_income_category
       ON income.user_income_category_id = user_income_category.id
       WHERE income.user_id = :user_id AND description LIKE :description
       ORDER BY income.date DESC, income.id DESC",
      [
        'user_id' => $_SESSION['user'],
        'description' => "%{$searchTerm}%"
      ]
    )->findall();
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
      "INSERT INTO income (user_id, user_income_category_id, amount, date, description)
       VALUES (:user_id, :user_income_category_id, :amount, :date, :description)",
      [
        'user_id' => $_SESSION['user'],
        'user_income_category_id' => $userIncomeCategoryId,
        'amount' => $formData['amount'],
        'date' => $formData['date'],
        'description' => $formData['description']
      ]
    );
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
