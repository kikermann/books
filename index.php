<?php

require_once "vendor/autoload.php";
require_once "Books.php";

$books = new Books(new DOMDocument());
$books->loadDoc('books.xml');

print_r($books->getBooks());

$books->addBook(
    'Simon',
    "Simon's Adventures",
    101,
    '1-00-111'
);

$books->saveDoc('books2.xml');
$books->loadDoc('books2.xml');

print_r($books->getBooks());
