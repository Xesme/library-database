<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Author.php";

$server = 'mysql:host=localhost:8889;dbname=library_test';
$userTitle = 'root';
$password = 'root';
$DB = new PDO($server, $userTitle, $password);


class AuthorTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Author::deleteAll();
    }

    function test_Author_get_set_construct()
    {
        // Arrange
        $author1 = new Author('Charles Dickenson');

        // Act
        $author2 = new Author();
        $author2->setAuthorName($author1->getAuthorName());

        // Assert
        $this->assertEquals(
            'Charles Dickenson',
            $author2->getAuthorName()
        );
    }

    function test_Author_getAll()
    {
        // Arrange
        $author1 = new Author('Charles Dickenson');
        $author2 = new Author('Oliver Sacks');

        // Act
        $author1->save();
        $author2->save();
        $all_authors = Author::getAll();

        // Assert
        $this->assertEquals([$author1, $author2], $all_authors);
    }

    function test_Author_getAll_delete_all_depends_on_teardown()
    {
        // Arrange
        $author1 = new Author('Charles Dickenson');
        $author2 = new Author('Oliver Sacks');
        $author3 = new Author('Mary Shelly');


        // Act
        $author1->save();
        $author2->save();
        $author3->save();
        $all_authors = Author::getAll();

        // Assert
        $this->assertEquals([$author1, $author3, $author2], $all_authors);
    }

    function test_Author_getAll_with_search_expression()
    {
        // Arrange
        $author1 = new Author('Charles Dickenson');
        $author2 = new Author('Oliver Wolf Sacks');
        $author3 = new Author('Mary Shelly');


        // Act
        $author1->save();
        $author2->save();
        $author3->save();
        $searched_authors = Author::getAll('%wolf%');

        // Assert
        $this->assertEquals([$author2], $searched_authors);
    }

    function test_Author_findById()
    {
        // Arrange
        $author1 = new Author('Charles Dickenson');
        $author2 = new Author('Oliver Sacks');
        $author3 = new Author('Mary Shelly');
        $author1->save();
        $author2->save();
        $author3->save();

        // Act
        $found_author = Author::findById($author2->getId());

        // Assert
        $this->assertEquals($author2, $found_author);
    }

    function test_Author_update()
    {
        // Arrange
        $author1 = new Author('Charles Dickenson');
        $author2 = new Author('Oliver Sacks');
        $author3 = new Author('Mary Shelly');
        $author1->save();
        $author2->save();
        $author3->save();

        // Act
        $author1->update('Charles Q. Dickenson');
        $found_author = Author::findById($author1->getId());

        // Assert
        $this->assertEquals(
            'Charles Q. Dickenson',
            $found_author->getAuthorName()
        );
    }

    function test_Author_delete()
    {
        // Arrange
        $author1 = new Author('Charles Dickenson');
        $author2 = new Author('Oliver Sacks');
        $author3 = new Author('Mary Shelly');
        $author1->save();
        $author2->save();
        $author3->save();

        // Act
        $author1->delete();

        // Assert
        $this->assertEquals([$author3, $author2], Author::getAll());
    }
}
?>
