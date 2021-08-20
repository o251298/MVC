<?php
// ОСНОВНЫЕ ЗАДАЧТИ РОУТЕРА
/*
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
 */

class Router
{
    private $routes; // массив, в котором хранятся маршруты, будем получать его и з файла routes.php.

    // Получить строку запроса
    /**
     * @return string
     */
    private function getURI(){
        if (!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/'); // Функция trim() удаляет пробелы и другие предопределенные символы в левой и в правой части строки.
        }
    }

    public function __construct(){
        // 1. Путь к роутам
        $routerPath = ROOT.'/config/routes.php';
        // 2. Присвоить свойству $routes массив, который хранится в файле Конструкция include предназначена для включения файлов в код сценария PHP во время исполнения сценария PHP.
        $this->routes = include($routerPath);
    }
    public function run(){
        $uri = $this->getURI();
        // Проверить наличие такого запроса в routes.php.
        foreach ($this->routes as $uriPattern => $path){
            /*
             * Мы проходимся по массиву $routes, у которого ключ $uriPattern является запросом,
             * а $path это путь обработчика.
             * echo "<br> $uriPattern -> $path";
             */
            // сравнить $uriPattern и $uri, если == то в переменной $path мі можем увидеть контроллер и екшин, который будет обрабатывать запрос.

            if (preg_match("~$uriPattern~", $uri)){ // испульзуем знак Тильды, что бы не было конфликов с "/" который передается в массиве $routes.
                // Если есть совпадения, определить какой контроллер и екшин обрабатывает запрос


                $internalRoute = preg_replace("~$uriPattern~", $path, $uri); // мы меняем путь к обработчику

                // Разделим строку по /, что бы узнать какой метод и контроллер будем вызывать
                $segments = explode('/', $internalRoute);
                // Получаем имя контроллера
                // array_shift() извлекает первое значение массива array и возвращает его, сокращая размер array на один элемент.
                $controllerName = ucfirst(array_shift($segments)).'Controller'; // ProductController //ucfirst(string) делает первую строку с большой буквы
                $actionName = 'action'.ucfirst(array_shift($segments));
                $param = $segments;
                // Подключить файл контроллера
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                //file_exists -- Проверить наличие указанного файла или каталога
                if (file_exists($controllerFile)){
                    include_once($controllerFile); // подключаем файл с контроллером

                    $controllerObj = new $controllerName;
                    $result = call_user_func_array(array($controllerObj, $actionName), $param); // call_user_func_array --  Вызывает пользовательскую функцию с массивом параметров
                    if ($result != null){
                        // если результата нету - обрываем поиск
                        break;
                    }
                }
            }
        }
    }
}