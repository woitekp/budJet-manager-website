<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class BalanceService
{
  public function __construct(private Database $db) {}

  public function getUserExpenses($startDate, $endDate)
  {
    $params = [
      'user_id' => $_SESSION['user'],
      'start_date' => $startDate,
      'end_date' => $endDate
    ];

    // notice the reversed sort order in ROW_NUMBER OVER compared to the ORDER BY clause
    // as records are displayed in reversed order (from the newest)
    return $this->db->query(
      "SELECT DATE_FORMAT(expense.date, '%Y-%m-%d') as date, expense.amount, user_expense_category.name AS category, user_payment_method.name as payment, expense.description as description,
        ROW_NUMBER() OVER (ORDER BY expense.date, expense.id) AS ordinal_number
      FROM expense
      INNER JOIN user_expense_category ON expense.user_expense_category_id=user_expense_category.id
      INNER JOIN user_payment_method ON expense.user_payment_method_id=user_payment_method.id
      WHERE expense.user_id = :user_id AND date BETWEEN :start_date AND :end_date
      ORDER BY date DESC, expense.id DESC",
      $params
    )->findall();
  }

  public function getUserIncomes($startDate, $endDate)
  {
    $params = [
      'user_id' => $_SESSION['user'],
      'start_date' => $startDate,
      'end_date' => $endDate
    ];

    // notice the reversed sort order in ROW_NUMBER OVER compared to the ORDER BY clause
    // as records are displayed in reversed order (from the newest)
    return $this->db->query(
      "SELECT DATE_FORMAT(income.date, '%Y-%m-%d') as date, income.amount, user_income_category.name AS category, income.description as description,
        ROW_NUMBER() OVER (ORDER BY income.date, income.id) AS ordinal_number
      FROM income
      INNER JOIN user_income_category ON income.user_income_category_id=user_income_category.id
      WHERE income.user_id = :user_id AND date BETWEEN :start_date AND :end_date
      ORDER BY date DESC, income.id DESC",
      $params
    )->findall();
  }

  public function getUserIncomesByCategories($startDate, $endDate)
  {
    $params = [
      'user_id' => $_SESSION['user'],
      'start_date' => $startDate,
      'end_date' => $endDate
    ];

    return $this->db->query(
      "SELECT
      user_income_category.name as category,
      SUM(income.amount) AS category_sum,
      SUM(SUM(income.amount))
        OVER (ORDER BY category_sum DESC, category ASC) AS running_category_sum
      FROM user_income_category
      INNER JOIN
        (SELECT * FROM income WHERE date BETWEEN :start_date AND :end_date) AS income
      ON user_income_category.id = income.user_income_category_id
      WHERE user_income_category.user_id = :user_id
      GROUP BY category
      ORDER BY category_sum DESC, category ASC",
      $params
    )->findall();
  }

  public function getUserExpensesByCategories($startDate, $endDate)
  {
    $params = [
      'user_id' => $_SESSION['user'],
      'start_date' => $startDate,
      'end_date' => $endDate
    ];

    return $this->db->query(
      "SELECT
      user_expense_category.name as category,
      SUM(expense.amount) AS category_sum,
      SUM(SUM(expense.amount))
        OVER (ORDER BY category_sum DESC, category ASC) AS running_category_sum
      FROM user_expense_category
      INNER JOIN
        (SELECT * FROM expense WHERE date BETWEEN :start_date AND :end_date) AS expense
      ON user_expense_category.id = expense.user_expense_category_id
      WHERE user_expense_category.user_id = :user_id
      GROUP BY category
      ORDER BY category_sum DESC, category ASC",
      $params
    )->findall();
  }

  public function getUserBalance()
  {
    return 'balance';
  }
}
