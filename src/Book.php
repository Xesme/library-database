<?php
    class Book
    {
        private $id;
        private $title;
        private $publishing;
        private $synopsis;
        private $genre_id;

        function __construct($title = '', $publishing = '', $synopsis = '', $genre_id = null, $id = null)
        {
            $this->setTitle($title);
            $this->setPublishing($publishing);
            $this->setSynopsis($synopsis);
            $this->setGenreId($genre_id);
            $this->setId($id);
        }

        function getId()
        {
            return $this->id;
        }

        function getGenreId()
        {
            return $this->genre_id;
        }

        function getTitle()
        {
            return $this->title;
        }

        function getPublishing()
        {
            return $this->publishing;
        }

        function getSynopsis()
        {
            return $this->synopsis;
        }

        function setId($id)
        {
            $this->id = (int) $id;
        }

        function setGenreId($genre_id)
        {
            $this->genre_id = $genre_id;
        }

        function setTitle($title)
        {
            $this->title = (string) $title;
        }

        function setPublishing($publishing)
        {
            $this->publishing = (string) $publishing;
        }

        function setSynopsis($synopsis)
        {
            $this->synopsis = (string) $synopsis;
        }

        function save()
        {
            $title = addslashes($this->getTitle());
            $synopsis = addslashes($this->getSynopsis());

            $GLOBALS['DB']->exec("INSERT INTO Books
                (title, publishing, synopsis, genre_id) VALUES
                ('$title', '{$this->getPublishing()}', '$synopsis', {$this->getGenreId()});"
            );
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll($genre_id = null)
        {
            if ($genre_id) {
                $query = "SELECT * FROM books WHERE genre_id = $genre_id ORDER BY title;";
            } else {
                $query = "SELECT * FROM books ORDER BY title;";
            }

            $output = array();
            $results = $GLOBALS['DB']->query($query);
            foreach ($results as $result) {
                $book = new Book(
                    $result['title'],
                    $result['publishing'],
                    $result['synopsis'],
                    $result['genre_id'],
                    $result['id']
                );
                array_push($output, $book);
            }
            return $output;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
        }

        static function findById($id)
        {
            $results = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = $id;");
            foreach ($results as $result) {
                $book = new Book(
                    $result['title'],
                    $result['publishing'],
                    $result['synopsis'],
                    $result['genre_id'],
                    $result['id']
                );
            }
            return $book;
        }

        function update($title, $publishing, $synopsis)
        {
            $this->setTitle(addslashes($title));
            $this->setPublishing($publishing);
            $this->setSynopsis(addslashes($synopsis));

            $GLOBALS['DB']->exec(
                "UPDATE books SET
                    title = '{$this->getTitle()}',
                    publishing = '{$this->getPublishing()}',
                    synopsis = '{$this->getSynopsis()}',
                    genre_id = {$this->getGenreId()}
                WHERE id = {$this->getId()};"
            );
        }

        function delete()
        {
            $GLOBALS['DB']->exec(
                "DELETE FROM books
                    WHERE id = {$this->getId()};"
            );
        }
    }
?>
