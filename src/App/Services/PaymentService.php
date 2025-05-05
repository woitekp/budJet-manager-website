<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class PaymentService
{
  public function __construct(private Database $db) {}

  public function createPaymentMethod(string $name)
  {
    $this->db->query(
      "INSERT INTO user_payment_method (name, user_id)
      VALUES (:name, :user_id)",
      [
        'name' => $name,
        'user_id' => $_SESSION['user'],
      ]
    );
  }

  public function getUserPaymentMethods(bool $enumerate = false)
  {
    $paymentMethods = array();
    $query = $this->db->query(
      "SELECT id, name, ROW_NUMBER() OVER(ORDER BY name) as ordinal_number
       FROM user_payment_method WHERE user_id = :user ORDER BY name",
      [
        'user' => $_SESSION['user']
      ]
    );

    while ($row = $query->find()) {
      array_push($paymentMethods, $row);
    }

    if (! $enumerate)
      $paymentMethods = array_map(function ($category) {
        return $category['name'];
      }, $paymentMethods);

    return $paymentMethods;
  }

  public function getUserPaymentMethod(int $methodId)
  {
    return $this->db->query(
      "SELECT id, name
      FROM user_payment_method
      WHERE id = :id AND user_id = :user_id",
      [
        'id' => (int) $methodId,
        'user_id' => $_SESSION['user']
      ]
    )->find();
  }

  public function updatePaymentMethod(array $formData, int $methodId)
  {
    $this->db->query(
      "UPDATE user_payment_method
      SET name = :name
      WHERE id = :id AND user_id = :user_id",
      [
        'name' => $formData['name'],
        'id' => $methodId,
        'user_id' => $_SESSION['user'],
      ]
    );
  }

  public function deletePaymentMethod(int $methodId)
  {
    $this->db->query(
      "DELETE FROM user_payment_method
      WHERE id = :id AND user_id = :user_id",
      [
        'id' => $methodId,
        'user_id' => $_SESSION['user']
      ]
    );
  }

  public function userPaymentMethodExists(string $name)
  {
    $nameCount = $this->db->query(
      "SELECT COUNT(*) FROM user_payment_method
      WHERE name = :name AND user_id = :user_id",
      [
        'name' => $name,
        'user_id' => $_SESSION['user']
      ]
    )->count();

    return ($nameCount > 0);
  }
}
