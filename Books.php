<?php

class Books {

    /**
     * @var DOMDocument $dom
     */
    private $dom;

    /**
     * @param   DOMDocument $dom
     */
    public function __construct(DOMDocument $dom)
    {
        $this->dom = $dom;
    }

    /**
     * @param   string  $docLocation
     *
     * @return  boolean
     */
    public function loadDoc($docLocation)
    {
        try {
            return $this->dom->load($docLocation);
        } catch (\Exception $e) {
        }

        return false;
    }

    /**
     * Get books from XML
     *
     * @return array
     */
    public function getBooks()
    {
        $bookNodes = $this->dom->getElementsByTagName('book');
        $books = [];

        foreach($bookNodes as $domNode) {
            $book = [];

            foreach($domNode->childNodes as $dn) {
                if ($dn->nodeName === 'author') {
                    $book['author'] = $dn->nodeValue;
                }

                if ($dn->nodeName === 'pages') {
                    $book['pages'] = $dn->nodeValue;
                }

                if ($dn->nodeName === 'title') {
                    $book['title'] = $dn->nodeValue;
                }

                if ($dn->nodeName === 'code') {
                    $book['code'] = $dn->nodeValue;
                }
            }

            $books[] = $book;
        }

        return $books;
    }

    /**
     * Add a book to the XML doc
     *
     * @param   string  $author
     * @param   string  $title
     * @param   int     $pages
     * @param   string  $code
     *
     * @return  boolean
     */
    public function addBook($author, $title, $pages, $code)
    {
        $newFragment = $this->dom->createDocumentFragment();
        $newFragment->appendXML("<book><author>$author</author><title>$title</title><pages>$pages</pages><code>$code</code></book>");

        $books = $this->dom->getElementsByTagName('books');
        $books[0]->appendChild($newFragment);
    }

    public function saveDoc($docName = 'books.xml')
    {
        return $this->dom->save($docName);
    }
}
