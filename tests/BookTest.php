<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Book.php";

$server = 'mysql:host=localhost:8889;dbname=library_test';
$userTitle = 'root';
$password = 'root';
$DB = new PDO($server, $userTitle, $password);


class BookTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Book::deleteAll();
    }

    function test_Book_get_set_construct()
    {
        // Arrange
        $book1 = new Book('King James', '1943-02-20', 'Holy Bible', 1);

        // Act
        $book2 = new Book();
        $book2->setTitle($book1->getTitle());
        $book2->setPublishing($book1->getPublishing());
        $book2->setSynopsis($book1->getSynopsis());
        $book2->setGenreId($book1->getGenreId());

        // Assert
        $this->assertEquals(
            'King James-1943-02-20-Holy Bible-1',
            $book2->getTitle() . '-' . $book2->getPublishing() . '-' . $book2->getSynopsis() . '-' . $book2->getGenreId()
        );
    }

    function test_Book_getAll_all_genre()
    {
        // Arrange
        $book1 = new Book('King James', '1943-02-20', 'Holy Bible', 1);
        $book2 = new Book('Alice and Wonderland', '1949-02-20', 'Fanciful', 2);

        // Act
        $book1->save();
        $book2->save();
        $all_books = Book::getAll();

        // Assert
        $this->assertEquals([$book2, $book1], $all_books);
    }

    function test_Book_getAll_one_genre_delete_all_depends_on_teardown()
    {
        // Arrange
        $book1 = new Book('King James', '1943-02-20', 'Holy Bible', 1);
        $book2 = new Book('Alice and Wonderland', '1949-02-20', 'Fanciful', 2);
        $book3 = new Book('Catcher in the Rye', '1958-02-20', 'Youthful attitude', 2);

        // Act
        $book1->save();
        $book2->save();
        $book3->save();
        $all_books = Book::getAll(2);

        // Assert
        $this->assertEquals([$book2, $book3], $all_books);
    }

    function test_Book_findById()
    {
        // Arrange
        $book1 = new Book('King James', '1943-02-20', 'Holy Bible', 1);
        $book2 = new Book('Alice and Wonderland', '1949-02-20', 'Fanciful', 2);
        $book3 = new Book('Catcher in the Rye', '1958-02-20', 'Youthful attitude', 2);
        $book1->save();
        $book2->save();
        $book3->save();

        // Act
        $found_book = Book::findById($book2->getId());

        // Assert
        $this->assertEquals($book2, $found_book);
    }

    function test_Book_update()
    {
        // Arrange
        $book1 = new Book('King James', '1943-02-20', 'Holy Bible', 1);
        $book2 = new Book('Alice and Wonderland', '1949-02-20', 'Fanciful', 2);
        $book3 = new Book('Catcher in the Rye', '1958-02-20', 'Youthful attitude', 2);
        $book1->save();
        $book2->save();
        $book3->save();

        // Act
        $book1->update('King James Bible', '1943-02-22', 'Religious Text');
        $found_book = Book::findById($book1->getId());

        // Assert
        $this->assertEquals(
            'King James Bible-1943-02-22-Religious Text-1',
            $found_book->getTitle() . '-' . $found_book->getPublishing() . '-' . $found_book->getSynopsis() . '-' . $found_book->getGenreId()
        );
    }

    function test_Book_delete()
    {
        // Arrange
        $book1 = new Book('King James', '1943-02-20', 'Holy Bible', 1);
        $book2 = new Book('Alice and Wonderland', '1949-02-20', 'Fanciful', 2);
        $book3 = new Book('Catcher in the Rye', '1958-02-20', 'Youthful attitude', 2);
        $book1->save();
        $book2->save();
        $book3->save();

        // Act
        $book1->delete();

        // Assert
        $this->assertEquals([$book2, $book3], Book::getAll());
    }
}
?>
