<?php
$selectedOption = 'class="selected-option"';
$path = parse_url($_SERVER['REQUEST_URI'])['path'];
?>

<ul class="menu">
  <li>
    <a href="/incomes" <?php if ($path == '/incomes') echo $selectedOption ?>>
      Incomes
    </a>
  </li>

  <li>
    <a href="/income" <?php if ($path == '/income') echo $selectedOption ?>>
      Add income
    </a>
  </li>

  <li>
    <a href="/expenses" <?php if ($path == '/expenses') echo $selectedOption ?>>
      Expenses
    </a>
  </li>

  <li>
    <a href="/expense" <?php if ($path == '/expense') echo $selectedOption ?>>
      Add expense
    </a>
  </li>

  <li>
    <a href="/balance" <?php if ($path == '/balance') echo $selectedOption ?>>
      Show Balance
    </a>
  </li>

  <li>
    <a href="/settings" <?php if ($path == '/settings') echo $selectedOption ?>>
      Settings
    </a>
  </li>

  <li>
    <a href="/logout">
      Sign out
    </a>
  </li>
</ul>