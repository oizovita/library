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

$fileName = date("Y-m-d_H-i") . "_dump.sql";
$folderName = __DIR__ . "/../database/dump";
if ($config['driver'] === 'mysql') {
    $command = "mysqldump --user=$config[username] --password=$config[password] --host=$config[host] $config[database] > $folderName/$fileName";
}

exec($command);