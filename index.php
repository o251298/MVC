<?php
// Front Controller

//$string = 'День: 21, Месяц: 12, год 2013';
//$string = '21-12-2012';
//$pattern = '/([0-9]{2})-([0-9]{2})-([0-9]{4})/';
//$replace = 'Day $1, mouth $2, year $3';
//$res = preg_replace($pattern, $replace, $string);
//echo $res;
//$string = 'День: 22, Месяц: 10, год 2033';
//$pattern = '/День: ([0-9]{2}), Месяц: ([0-9]{2}), год ([0-9]{4})/';
//$replace = '$1 - $2 - $3';
//$res = preg_replace($pattern, $replace, $string);
//echo $res;


// 1 Общие настройки, включение отображения ошибок
ini_set('display_errors', 1); // Отображение ошибок
error_reporting(E_ALL); // Отображение всех ошибок

// 2 Подключение файлов системы
define('ROOT', dirname(__FILE__));
include_once(ROOT.'/components/Router.php');
include_once(ROOT.'/components/Db.php');

// 3 Вызов роутера
$router = new Router;
$router->run();

// 4 Подключение к БД
