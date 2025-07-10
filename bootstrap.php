<?php
define('BASE_PATH', realpath(__DIR__));
define('UTILS_PATH', realpath(BASE_PATH . '/utils'));
define('DATABASE_PATH', realpath(BASE_PATH . '/database'));
define('STATIC_DATA_PATH', realpath(BASE_PATH . '/staticDatas'));
define('DUMMIES_PATH', realpath(BASE_PATH . '/staticDatas/dummies'));

chdir(BASE_PATH);
