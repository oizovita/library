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

$db->sql(
    "CREATE TABLE IF NOT EXISTS migrations(
        id   TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
        PRIMARY KEY (id),
        migration VARCHAR(255)
    );"
);

const DIR = __DIR__ . '/migrations';

$files = scandir(DIR);

foreach ($files as $file) {
    if (!($file === '.' || $file === '..')) {
        if (!$db->select('migrations', ['*'])->where('migration', $file)->exec()) {
            $db->sql(file_get_contents(__DIR__ . "/migrations/$file"));
            $db->insert('migrations', ['migration' => $file])->exec();
        }
    }
}

