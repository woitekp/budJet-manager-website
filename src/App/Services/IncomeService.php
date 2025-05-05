<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class IncomeService
{
  public function __construct(private Database $db) {}

  public function getUserIncomes(int $length, int $offset, string $searchTerm)
  {
    $params = [
      'user_id' => $_SESSION['user'],
      'description' => "%{$searchTerm}%"
    ];

    return $this->db->query(
      "SELECT income.id, DATE_FORMAT(income.date, '%Y-%m-%d') as date, income.amount as amount, user_income_category.name as category, income.description as description,
        ROW_NUMBER() OVER (ORDER BY income.date, income.id) AS ordinal_number,
      count(*) OVER() AS records_count
      FROM income
      JOIN user_income_category
      ON income.user_income_category_id = user_income_category.id
      WHERE income.user_id = :user_id AND description LIKE :description
      ORDER BY income.date DESC, income.id DESC
      LIMIT {$length} OFFSET {$offset}",
      $params
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

  public function getUserIncome(int $incomeId)
  {
    return $this->db->query(
      "SELECT income.id, DATE_FORMAT(income.date, '%Y-%m-%d') as date, income.amount as amount, user_income_category.name as category, income.description as description
      FROM income
      JOIN user_income_category
      ON income.user_income_category_id = user_income_category.id
      WHERE income.id = :id AND income.user_id = :user_id",
      [
        'id' => (int) $incomeId,
        'user_id' => $_SESSION['user']
      ]
    )->find();
  }

  public function updateIncome(array $formData, int $incomeId)
  {
    $userIncomeCategoryId = $this->db->query(
      "SELECT id FROM user_income_category WHERE name = :category and user_id = :user_id",
      [
        'category' => $formData['category'],
        'user_id' => $_SESSION['user']
      ]
    )->find()['id'];

    $this->db->query(
      "UPDATE income
      SET user_income_category_id = :user_income_category_id,
          amount = :amount,
          date = :date,
          description = :description
      WHERE id = :id AND user_id = :user_id",
      [
        'user_income_category_id' => $userIncomeCategoryId,
        'amount' => $formData['amount'],
        'date' => $formData['date'],
        'description' => $formData['description'],
        'user_id' => $_SESSION['user'],
        'id' => $incomeId
      ]
    );
  }


  public function deleteIncome(int $incomeId)
  {
    $this->db->query(
      "DELETE FROM income
      WHERE id = :id AND user_id = :user_id",
      [
        'id' => $incomeId,
        'user_id' => $_SESSION['user']
      ]
    );
  }

  public function createIncomeCategory(string $name)
  {
    $this->db->query(
      "INSERT INTO user_income_category (name, user_id)
      VALUES (:name, :user_id)",
      [
        'name' => $name,
        'user_id' => $_SESSION['user'],
      ]
    );
  }

  public function getUserIncomeCategories(bool $enumerate = false)
  {
    $categories = array();
    $query = $this->db->query(
      "SELECT id, name, ROW_NUMBER() OVER (ORDER BY name) AS ordinal_number
       FROM user_income_category WHERE user_id = :user ORDER BY name",
      [
        'user' => $_SESSION['user']
      ]
    );
    while ($row = $query->find()) {
      array_push($categories, $row);
    }

    if (!$enumerate)
      $categories = array_map(function ($category) {
        return $category['name'];
      }, $categories);

    return $categories;
  }

  public function getUserIncomeCategory(int $categoryId)
  {
    return $this->db->query(
      "SELECT id, name
      FROM user_income_category
      WHERE id = :id AND user_id = :user_id",
      [
        'id' => (int) $categoryId,
        'user_id' => $_SESSION['user']
      ]
    )->find();
  }

  public function updateIncomeCategory(array $formData, int $categoryId)
  {
    $this->db->query(
      "UPDATE user_income_category
      SET name = :name
      WHERE id = :id AND user_id = :user_id",
      [
        'name' => $formData['name'],
        'id' => $categoryId,
        'user_id' => $_SESSION['user'],
      ]
    );
  }

  public function deleteIncomeCategory(int $categoryId)
  {
    $this->db->query(
      "DELETE FROM user_income_category
      WHERE id = :id AND user_id = :user_id",
      [
        'id' => $categoryId,
        'user_id' => $_SESSION['user']
      ]
    );
  }

  public function userIncomeCategoryExists(string $name)
  {
    $nameCount = $this->db->query(
      "SELECT COUNT(*) FROM user_income_category
      WHERE name = :name AND user_id = :user_id",
      [
        'name' => $name,
        'user_id' => $_SESSION['user']
      ]
    )->count();

    return ($nameCount > 0);
  }

  public function countIncomesInCategory(int $categoryId)
  {
    return $this->db->query(
      "SELECT COUNT(*)
      FROM income
      WHERE income.user_income_category_id = :category_id AND income.user_id = :user_id",
      [
        'category_id' => $categoryId,
        'user_id' => $_SESSION['user']
      ]
    )->count();
  }
}
