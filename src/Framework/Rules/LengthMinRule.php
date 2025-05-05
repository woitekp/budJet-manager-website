<?php

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class LengthMinRule implements RuleInterface
{
  public function validate(array $data, string $field, array $params): bool
  {
    if (empty($params[0])) {
      throw new InvalidArgumentException('Minimum length not spicified');
    }

    $length = (int) $params[0];

    return strlen($data[$field]) > $length;
  }

  public function getMessage(array $data, string $field, array $params): string
  {

    if ($params[0] > 1)
      $nounForm = 'characters';
    else
      $nounForm = 'character';

    return "Minimum {$params[0]} {$nounForm} required";
  }
}
