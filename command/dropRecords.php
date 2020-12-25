<?php
require __DIR__ . '/../vendor/autoload.php';

use Core\DB;

$config = include(__DIR__ . '/../config.php');

$db = DB::connection(
    $config['driver'],
    $config['port'],
    $config['host'],
    $config['database'],
    $config['username'],
    $config['password']
);

$db->delete('books')->where('deleted_at', null, 'is not')->exec();