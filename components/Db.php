<?php


class Db
{
    public static function getConnection(){
        // Получаем название файла
        $paramsPath = ROOT.'/config/params.php';
        // Выбераем данные БД для использования
        $params = include($paramsPath);

        // Выполняем настройки подключение и возвращаем объект с подключением
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);
        return $db;
    }
}