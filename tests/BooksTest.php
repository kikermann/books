<?php

require_once "vendor/autoload.php";
require_once "Books.php";

class BooksTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var string $docLocation
     */
    private $docLocation = 'books.xml';
    
    protected function _before()
    {
        $this->tester = new Books(new DOMDocument());
    }

    protected function _after()
    {
        if (file_exists('books2.xml')) {
            unlink('books2.xml');
        }
    }

    // tests
    public function testLoadDocument()
    {
        $this->assertTrue($this->tester->loadDoc($this->docLocation));
    }

    public function testLoadDocumentFailsWithEmptyPath()
    {
        $docLocation = '';
        $this->assertFalse($this->tester->loadDoc($docLocation));
    }

    public function testLoadDocumentFailsWithInvalidPath()
    {
        $docLocation = '';
        $this->assertFalse($this->tester->loadDoc($docLocation));
    }

    public function testGetBooks()
    {
        $books = [
            [
                'author' => 'Paul',
                'title' => "Paul's Adventures",
                'pages' => '10',
                'code' => '1-00-01'
            ],
            [
                'author' => 'Adetomi',
                'title' => "Adetomi's Adventures",
                'pages' => '20',
                'code' => '1-00-10'
            ]
        ];

        $this->tester->loadDoc($this->docLocation);
        $this->assertEquals($books, $this->tester->getBooks());
    }

    public function testAddBook()
    {
        $newBook = [
            'author' => 'Simon',
            'title' => "Simon's Adventures",
            'pages' => 101,
            'code' => '1-00-101'
        ];

        $books = [
            [
                'author' => 'Paul',
                'title' => "Paul's Adventures",
                'pages' => '10',
                'code' => '1-00-01'
            ],
            [
                'author' => 'Adetomi',
                'title' => "Adetomi's Adventures",
                'pages' => '20',
                'code' => '1-00-10'
            ],
            $newBook
        ];

        $this->tester->loadDoc($this->docLocation);
        $this->tester->addBook(
            $newBook['author'],
            $newBook['title'],
            $newBook['pages'],
            $newBook['code']
        );

        $this->assertEquals($books, $this->tester->getBooks());
    }

    public function testSaveDoc()
    {
        $this->assertEquals(22, $this->tester->saveDoc('books2.xml'));
    }
}