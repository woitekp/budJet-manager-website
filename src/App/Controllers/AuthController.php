<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, UserService};


class AuthController
{
  public function __construct(
    private TemplateEngine $view,
    private ValidatorService $validatorService,
    private UserService $userService
  ) {}

  public function registerView()
  {
    echo $this->view->render('/registration.php');
  }

  public function register()
  {
    $this->validatorService->validateRegister($_POST);
    $this->userService->isEmailTaken($_POST['email']);
    $this->userService->create($_POST);
    redirectTo('/balance');
  }

  public function loginView()
  {
    echo $this->view->render('/login.php');
  }

  public function login()
  {
    $this->validatorService->validateLogin($_POST);
    $this->userService->login($_POST);
    redirectTo('/balance');
  }

  public function logout()
  {
    $this->userService->logout();
    redirectTo('/login');
  }

  public function accountView()
  {
    echo $this->view->render('/account/account.php');
  }

  public function passwordChangeView()
  {
    echo $this->view->render('/account/password.php');
  }

  public function passwordChange()
  {
    $this->validatorService->validatePassword($_POST);
    $this->userService->passwordChange($_POST);
    redirectTo('/account');
  }

  public function deleteAccountView()
  {
    echo $this->view->render('/account/delete.php');
  }

  public function deleteAccount()
  {
    $this->userService->logout();
    $this->userService->deleteUser();
    redirectTo('/login');
  }
}
