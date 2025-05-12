<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
  public function __construct(private Database $db) {}

  public function isEmailTaken(string $email)
  {
    $emailCount = $this->db->query(
      "SELECT COUNT(*) FROM user WHERE email = :email",
      ['email' => $email]
    )->count();

    if ($emailCount > 0) {
      throw new ValidationException(['email' => ['Email taken']]);
    }
  }

  public function create(array $formData)
  {
    $this->db->query(
      "INSERT INTO user (email, password, username) VALUES (:email, :password, :username)",
      [
        'email' => $formData['email'],
        'password' => password_hash($formData['password'], PASSWORD_BCRYPT, ['cost' => 12]),
        'username' => $formData['username']
      ]
    );
    session_regenerate_id();

    $_SESSION['user'] = $this->db->id();

    $this->insertDefaults();
  }

  public function login(array $formData)
  {
    $user =  $this->db->query(
      "SELECT * FROM user WHERE email = :email",
      [
        'email' => $formData['email']
      ]
    )->find();

    $passwordMatch = password_verify($formData['password'], $user['password'] ?? '');

    if (!$user || !$passwordMatch) {
      throw new ValidationException(['password' => ['Invalid credentials']]);
    }

    session_regenerate_id();
    $_SESSION['user'] = $user['id'];
  }

  public function logout()
  {
    session_destroy();

    // destroy original cookie
    $params = session_get_cookie_params();
    setcookie(
      'PHPSESSID',
      '',
      1,  // set expiration time in the past (alternatively: time() - SOME_NUMBER_IN_THE_PAST)
      $params['path'],
      $params['domain'],
      $params['secure'],
      $params['httponly']
    );
  }

  private function insertDefaults()
  {

    $this->db->query(
      "INSERT INTO user_income_category (user_id, name) SELECT :user_id, name FROM income_category_default",
      [
        'user_id' => $_SESSION['user']
      ]
    );

    $this->db->query(
      "INSERT INTO user_expense_category (user_id, name) SELECT :user_id, name FROM expense_category_default",
      [
        'user_id' => $_SESSION['user']
      ]
    );

    $this->db->query(
      "INSERT INTO user_payment_method (user_id, name) SELECT :user_id, name FROM payment_method_default",
      [
        'user_id' => $_SESSION['user']
      ]
    );
  }
}
