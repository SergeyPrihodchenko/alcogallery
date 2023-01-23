<?php

require_once './vendor/autoload.php';

use Alco\Market\Class\DIContainer\DIContainer;
use Alco\Market\Class\Repository\TokensRepository;
use Alco\Market\Class\Repository\UsersRepository;

$container = new DIContainer();

$pdo = new PDO('sqlite:./db.db');

$container->bind(
    UsersRepository::class,
    new UsersRepository($pdo)
);

$container->bind(
    TokensRepository::class,
    new TokensRepository($pdo)
);

return $container;