<?php

include_once ROOT.'/models/News.php';


class NewsController
{
    public function actionIndex(){

        $newsList = array();
        $newsList = News::getNewsList();

        require_once ROOT.'/views/news/index.php';

        return true;
    }
    public function actionView($id){

        $item = News::getNewsItemById($id);
        var_dump($item);

        return true;
    }
}