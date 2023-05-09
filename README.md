SimpleHTML - PHP библиотека для генерации HTML-кода. Она содержит класс HtmlBuilder, который предоставляет методы для построения различных элементов HTML, таких как теги, изображения, ссылки, списки, таблицы, а также для добавления стилей.

Метод style() позволяет добавлять CSS стили внутрь тега style. Методы openTag() и closeTag() используются для создания открывающего и закрывающего тегов. Методы addContent() и tag() добавляют содержимое в тег. Методы link() и image() генерируют ссылки и изображения соответственно. Метод listUl() создает список с маркерами, а метод table() генерирует таблицу с заголовками и строками.

Класс HtmlBuilder также имеет метод display(), который выводит готовый HTML-код на экран. Библиотека SimpleHTML предоставляет удобный способ для генерации HTML-кода в PHP-приложениях.

Пример кода:


```php
<?php

require_once('./SimpleHTML/builder.php');



$page = new HtmlBuilder();



$page->style('body', ['background' => '#056']);

$page->openTag('html');



// Head section

$page->openTag('head');

$page->tag('title', 'My Page');

$page->closeTag('head');



// Body section

$page->openTag('body', ['style' => 'color: white;']);



$page->tag('h1', 'Добро пожаловать на мою страницу!');



$page->image('chips.png', 'chips', ['width' => '300px']);



$page->tag('h2', 'Моя любимая еда:');

$page->listUl(['Чипсы', 'Энергетики', 'Дошираки']);



$headers = ['Имя', 'Возраст', 'Профессия'];

$rows = [

    ['Сергей', 18, 'Разработчик'],

    ['Вячеслав', 25, 'Помощник']

];

$page->table($headers, $rows);



$page->closeTag('body');

$page->closeTag('html');



$page->display();

?>
```

