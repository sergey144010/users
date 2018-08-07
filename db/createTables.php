<?php

$appPath = dirname(dirname(__FILE__));
$config = require $appPath . '/db/config.php';
if(is_file($appPath . '/db/config_local.php')){
    $config = require $appPath . '/db/config_local.php';
};
$pdo = new \PDO($config['dsn'], $config['user'], $config['pass']);
$pdo->query(
"
CREATE TABLE IF NOT EXISTS users(
id int(11) not null auto_increment,
name varchar(255) not null,
mail varchar(50),
phone varchar(50),
primary key(id)
)
engine = innodb
CHARACTER SET utf8
COLLATE utf8_general_ci;
"
);
