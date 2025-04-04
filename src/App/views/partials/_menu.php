<?php
$cso = 'class="selected-option"';
?>

<ul class="menu">
  <li>
    <a href="/incomes" <?php if ($_SERVER['REQUEST_URI'] == '/incomes') echo $cso ?>>
      Incomes
    </a>
  </li>

  <li>
    <a href="/income" <?php if ($_SERVER['REQUEST_URI'] == '/income') echo $cso ?>>
      Add income
    </a>
  </li>

  <li>
    <a href="/expenses" <?php if ($_SERVER['REQUEST_URI'] == '/expenses') echo $cso ?>>
      Expenses
    </a>
  </li>

  <li>
    <a href="/expense" <?php if ($_SERVER['REQUEST_URI'] == '/expense') echo $cso ?>>
      Add expense
    </a>
  </li>

  <li>
    <a href="/balance" <?php if ($_SERVER['REQUEST_URI'] == '/balance') echo $cso ?>>
      Show Balance
    </a>
  </li>

  <li>
    <a href="/settings" <?php if ($_SERVER['REQUEST_URI'] == '/settings') echo $cso ?>>
      Settings
    </a>
  </li>

  <li>
    <a href="/logout">
      Sign out
    </a>
  </li>
</ul>