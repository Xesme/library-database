<?php
    class Author
    {
        private $id;
        private $author_name;


        function __construct($author_name = '', $id = null)
        {
            $this->setAuthorName($author_name);
            $this->setId($id);
        }
        // getters and setters
        function getId()
        {
            return $this->id;
        }

        function getAuthorName()
        {
            return $this->author_name;
        }

        function setId($id)
        {
            $this->id = (int) $id;
        }

        function setAuthorName($author_name)
        {
            $this->author = (string) $author_name;
        }
        // CRUD functions

        function save()
        {
            $author_name = addslashes($this->getAuthorName());

            $GLOBALS['DB']->exec("INSERT INTO authors
                (author) VALUES
                ('$author_name');"
            );
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {

            $query = "SELECT * FROM authors ORDER BY author_name;";

            $output = array();
            $results = $GLOBALS['DB']->query($query);
            foreach ($results as $result) {
                $author = new Author(
                    $result['author_name'],
                    $result['id']
                );
                array_push($output, $author);
            }
            return $output;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors;");
        }

        static function findById($id)
        {
            $results = $GLOBALS['DB']->query("SELECT * FROM authors WHERE id = $id;");
            foreach ($results as $result) {
                $author = new Author(
                    $result['author_name'],
                    $result['id']
                );
            }
            return $author;
        }

        function update($author_name)
        {
            $this->setAuthorName(addslashes($author_name));

            $GLOBALS['DB']->exec(
                "UPDATE authors SET
                    author_name = '{$this->getAuthorName()}',
                WHERE id = {$this->getId()};"
            );
        }

        function delete()
        {
            $GLOBALS['DB']->exec(
                "DELETE FROM authors
                    WHERE id = {$this->getId()};"
            );
        }
    }
?>
