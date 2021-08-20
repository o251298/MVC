# АЛГОРИТМ СОЗДАНИЯ MVC МОДЕЛИ

Структура проекта
- controller
  /NewsController.php
- models
  /News.php
- view
  /news/index.php
- components
  /Router.php
  /DB.php
- config
  /params.php
  /routes.php
- index.php
- .htaccess



#index.php
1. Общие настройки, включение отображения ошибок
2. Подключение файлов системы 
// Подключение к БД
3. Вызов роутера

#Router.php

 ОСНОВНЫЕ ЗАДАЧТИ РОУТЕРА
* 1. АНАЛИЗ ЗАПРОСА
    * а) Получить строку запроса
    * б) возвратить строку запроса
    * в) Подключить данные из массива и перенести их в массив роуты в компоненте Роут
    * г) Получить все доступные запросы из массива роутов в виде ключ(паттерн_запроса) и значение (путь_к_обработчику)
    * д) Сравнить запрос пользователя и паттерн_запроса, в путь_к_обработчику хранится инфа о контроллере и екшене
* 2. ПОДКЛЮЧЕНИЕ КОНТРОЛЛЕРОВ
    * а) После получения путь_к_обработчику разделить эту строчку в массив
    * б) Выбрать имя контроллера и переобразовать к виду ProductController
    * в) Выбрать имя екшена и переобразовать к виду actionIndex
    * г) Получить имя полного доступа к контроллеру к виду http://localhost/controllers/NewsController.php
    * д) Если такой файл существует в директории - подключаем данный файл
* 3. ПЕРЕДАЧА УПРАВЛЕНИЯ КОНТРОЛЛЕРУ
    * а) Передать новому обьекту $controllerObject класс с именем $controllerName
    * б) Теперь мы имеем доступ к методам контроллера

#Db.php

1. Получаем название файла
2. Выбераем данные БД для использования
3. Выполняем настройки подключение и возвращаем объект с подключением

#params
Для того что бы мы попали на запрос у коготорго есть доп параметры, такой роут пишем в начале массива, так как мы находим роут по первому совпадению


    'mvc/news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2', // используем регулярку
    'mvc/news/([0-9]+)' => 'news/view/$1', // используем регулярку
    'mvc/news' => 'news/index',
    'mvc/product' => 'product/index'

#News.php
Запрос к БД используя новый метод PDO()
      
 1. Создаем обьект класа PDO и вызываем метод query, в который передаем запрос SQL
 2. Мы проходимся по елементам которые возвращает цикл while (в $row = $result->fetch() хранится только рдна строка, что бы вывести все - цикл.)
       
        $db = Db::getConnection();
        $newsList = array();
        $result = $db->query("SELECT `id`, `name`, `date` FROM news");
        $i = 0;
        while ($row = $result->fetch()){
            $newsList[$i]['id'] = $row['id'];
            $newsList[$i]['name'] = $row['name'];
            $newsList[$i]['date'] = $row['date'];
            $i++;
        }
        return $newsList;
