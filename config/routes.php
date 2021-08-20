<?php
// Для того что бы мы попали на запрос у коготорго есть доп параметры, такой роут пишем в начале массива, так как мы находим роут по первому совпадению
return array(
    'mvc/news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2', // используем регулярку
    'mvc/news/([0-9]+)' => 'news/view/$1', // используем регулярку
    'mvc/news' => 'news/index',
    'mvc/product' => 'product/index'
);
