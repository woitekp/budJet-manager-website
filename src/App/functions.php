<?php

declare(strict_types=1);

//echo '<pre>' . __FILE__ . '</pre>';

function dump_and_die(mixed $var)
{
  echo "<pre>";
  var_dump ($var);
  echo "</pre>";
  die(); // do not render the rest of the page
}

function escape(mixed $value): string
{
  return htmlspecialchars((string )$value);
}

function redirectTo(string $path)
{
  header("Location: {$path}");
  http_response_code(302);
  exit;
}