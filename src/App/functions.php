<?php

declare(strict_types=1);

function dump_and_die(mixed $var) {
  echo "<pre>";
  var_dump ($var);
  echo "</pre>";
  die(); // do not render the rest of the page
}
