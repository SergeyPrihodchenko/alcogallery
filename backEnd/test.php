<?php

// echo hash('sha3-256', 'admin' . 'Vinokurow');

$pdo = new PDO('sqlite:db.sqlite');

$statement = $pdo->query('SELECT id_user FROM tokens WHERE id_user = 3');

var_dump($statement->fetch(PDO::FETCH_ASSOC));