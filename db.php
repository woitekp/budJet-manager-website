<?php

include __DIR__ . '/src/Framework/Database.php';

use Framework\Database;

$db = new Database(
  'mysql',
  [
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'personal_budget'
  ],
  'root',
  ''
);

$sqlFile = file_get_contents('./database.sql');
$db->query($sqlFile);
