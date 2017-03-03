<?php
    class AuthorBook
    {
        private $id;
        private $author_id;
        private $book_id;


        function __construct($author_id = null, $book_id = null, $id = null)
        {
            $this->setAuthorId($author_id);
            $this->setBookId($book_id);
            $this->setId($id);
        }
        // getters and setters
        function getId()
        {
            return $this->id;
        }

        function getAuthorId()
        {
            return $this->author_id;
        }

        function getBookId()
        {
            return $this->book_id;
        }

        function setId($id)
        {
            $this->id = (int) $id;
        }

        function setAuthorId($author_id)
        {
            $this->author_id = (string) $author_id;
        }

        function setBookId($book_id)
        {
            $this->book_id = (string) $book_id;
        }

        // CRUD functions

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books
                (author_id, book_id) VALUES
                ({$this->getAuthorId()}, {$this->getBookId()});"
            );
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $output = array();
            $query = "SELECT * FROM authors_books;";

            $results = $GLOBALS['DB']->query($query);
            foreach ($results as $result) {
                $author_book = new AuthorBook(
                    $result['author_id'],
                    $result['book_id'],
                    $result['id']
                );
                array_push($output, $author_book);
            }
            return $output;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors_books;");
        }

        static function findById($id)
        {
            $results = $GLOBALS['DB']->query("SELECT * FROM authors_books WHERE id = $id;");
            foreach ($results as $result) {
                $author_book = new AuthorBook(
                    $result['author_id'],
                    $result['book_id'],
                    $result['id']
                );
            }
            return $author_book;
        }

        function delete()
        {
            $GLOBALS['DB']->exec(
                "DELETE FROM authors_books
                    WHERE id = {$this->getId()};"
            );
        }
    }
?>
