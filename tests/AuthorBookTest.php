<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/AuthorBook.php";

$server = 'mysql:host=localhost:8889;dbname=library_test';
$userTitle = 'root';
$password = 'root';
$DB = new PDO($server, $userTitle, $password);


class AuthorBookBookTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        AuthorBook::deleteAll();
    }

    function test_AuthorBook_get_set_construct()
    {
        // Arrange
        $author_book1 = new AuthorBook(2, 1);

        // Act
        $author_book2 = new AuthorBook(3, 1);
        $author_book2->setAuthorId($author_book1->getAuthorId());
        $author_book2->setBookId($author_book1->getBookId());

        // Assert
        $this->assertEquals(
            $author_book1, $author_book2
        );
    }

    function test_AuthorBook_getAll()
    {
        // Arrange
        $author_book1 = new AuthorBook(4,5);
        $author_book2 = new AuthorBook(23,11);

        // Act
        $author_book1->save();
        $author_book2->save();
        $all_authorbooks = AuthorBook::getAll();

        // Assert
        $this->assertEquals([$author_book1, $author_book2], $all_authorbooks);
    }

    function test_AuthorBook_getAll_delete_all_depends_on_teardown()
    {
        // Arrange
        $author_book1 = new AuthorBook(4,5);
        $author_book2 = new AuthorBook(23,11);
        $author_book3 = new AuthorBook(7,3);


        // Act
        $author_book1->save();
        $author_book2->save();
        $author_book3->save();
        $all_authorbooks = AuthorBook::getAll();

        // Assert
        $this->assertEquals([$author_book1, $author_book2, $author_book3], $all_authorbooks);
    }

    function test_AuthorBook_findById()
    {
        // Arrange
        $author_book1 = new AuthorBook(4,5);
        $author_book2 = new AuthorBook(23,11);
        $author_book3 = new AuthorBook(7,3);
        $author_book1->save();
        $author_book2->save();
        $author_book3->save();

        // Act
        $found_author_book = AuthorBook::findById($author_book2->getId());

        // Assert
        $this->assertEquals($author_book2, $found_author_book);
    }


    function test_AuthorBook_delete()
    {
        // Arrange
        $author_book1 = new AuthorBook(4,5);
        $author_book2 = new AuthorBook(23,11);
        $author_book3 = new AuthorBook(7,3);
        $author_book1->save();
        $author_book2->save();
        $author_book3->save();

        // Act
        $author_book1->delete();

        // Assert
        $this->assertEquals([$author_book2, $author_book3], AuthorBook::getAll());
    }
}
?>
