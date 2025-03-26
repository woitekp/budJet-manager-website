<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{
  DateFormatRule,
  EmailRule,
  LengthMaxRule,
  MatchRule,
  NumericRule,
  RequiredRule,
};


class ValidatorService
{
  private Validator $validator;

  public function __construct()
  {
    $this->validator = new Validator();

    $this->validator->addRule('dateFormat', new DateFormatRule());
    $this->validator->addRule('email', new EmailRule());
    $this->validator->addRule('lengthMax', new LengthMaxRule());
    $this->validator->addRule('match', new MatchRule());
    $this->validator->addRule('numeric', new NumericRule());
    $this->validator->addRule('required', new RequiredRule());
  }

  public function validateRegister(array $formData)
  {
    $this->validator->validate($formData, [
      'username' => ['required'],
      'email' => ['required', 'email'],
      'password' => ['required'],
      'confirmPassword' => ['required', 'match:password']
    ]);
  }

  public function validateLogin(array $formData)
  {
    $this->validator->validate($formData, [
      'email' => ['required',  'email'],
      'password' => ['required']
    ]);
  }

  public function validateExpense(array $formData)
  {
    $this->validator->validate($formData, [
      'amount' => ['required', 'numeric'],
      'date' => ['required', 'dateFormat:Y-m-d'],
      'category' => ['required'],
      'payment' => ['required'],
      'description' => ['lengthMax:255']
    ]);
  }

  public function validateIncome(array $formData)
  {
    $this->validator->validate($formData, [
      'amount' => ['required', 'numeric'],
      'date' => ['required', 'dateFormat:Y-m-d'],
      'category' => ['required'],
      'description' => ['lengthMax:255']
    ]);
  }
}
