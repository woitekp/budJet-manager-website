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
    unset($_SESSION['user']);

    session_regenerate_id();
  }
}
