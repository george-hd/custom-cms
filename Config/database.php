<?php

$cfg['default']['connection_string'] = 'mysql:host=localhost;dbname=aaaaaaaaa';
//$cfg['default']['connection_string'] = 'mysql:host=localhost;dbname=gamedb';
$cfg['default']['user_name'] = 'root';
$cfg['default']['password'] = '';
$cfg['default']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND]="SET NAMES 'UTF8'";
$cfg['default']['pdo_options'][PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;

return $cfg;