<?php



class News
{
    public static function getNewsList(){
        // Запрос к БД используя новый метод PDO()
        /*
         * 2. Создаем обьект класа PDO и вызываем метод query, в который передаем запрос SQL
         * 3. Мы проходимся по елементам которые возвращает цикл while (в $row = $result->fetch() хранится только рдна строка, что бы вывести все - цикл.)
         */
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
    }


    public static function getNewsItemById($id){
        $id = intval($id); //Возвращает целое значение переменной
        if ($id){
            // Запрос к БД
            $db = Db::getConnection();
            $result = $db->query("SELECT `id`, `name`, `date` FROM news WHERE `id` =" .$id);
            //$result->setFetchMode(PDO::FETCH_NUM); // индексы елементов в форме номеров колонок
            $result->setFetchMode(PDO::FETCH_ASSOC); // индексы номеров названий

            $newsItem = $result->fetch();
            return $newsItem;
        }
    }
}