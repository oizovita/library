# Library

## Local development

Install requirements
``` bash
composer install
```

Copy file config.example.php to config.php

For create admin, please use **auth_user** and **auth_password** variables in the config.php file. 

Start migrations:
``` bash
php database/migrate.php
```