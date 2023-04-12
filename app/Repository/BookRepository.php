<?php
/*
* @author Adenagbe Emmanuel Adedayo
* @github https://github.com/emmadedayo
* @linkedIn https://www.linkedin.com/in/adenagbe-adedayo/
* @email emmadenagbe@gmail.com
* @project hardes
* @created Wed, Apr 2023
* @Time 2:39 pm
*/

namespace App\Repository;

use App\Models\Book;
use App\Service\BookService;
use Illuminate\Database\Eloquent\Collection;

class BookRepository
{

    private Book $book;
    private BookService $bookService;

    /**
     * BookRepository constructor.
     * @param Book $book
     * @param BookService $bookService
     */
    public function __construct(Book $book, BookService $bookService)
    {
        $this->book = $book;
        $this->bookService = $bookService;
    }


    /**
     * functions to get all books
     *
     * @return Book[]|Collection
     */
    public function getAllBooks(): Collection|array
    {
        return $this->book->all();
    }

//     get single book in the application

    /**
     * @param $table_field
     * @param $query
     * @return mixed
     */
    public function getSingleBook($table_field, $query): mixed
    {
        return $this->book->where($table_field, $query)->first();
    }


    /**
     * function to update user details
     *
     * @param $request
     * @return Book
     */
    public function updateBook($request, $id): Book|string
    {
        $book = $this->getSingleBook('id', $id);
        if (!$book)
            return 'Book to be updated not found';
        $book->update($request->toArray());
        return $book;
    }


    /**
     * function to get find a book by its name
     *
     * @param $name
     * @return array
     */
    public function findBookByName($name): array|string
    {
        $query = self::filterInput($name);

        $books = $this->bookService->getFilteredBooks('name', $name);

        if (is_string($books)) return $books;

        return $books;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function filterInput($query): mixed
    {
        return str_replace('"', '', $query);
    }


    /**
     * @param $query
     * @return mixed|string
     */
    public function searchBookTable($query): mixed
    {
        if (self::isSearchableFieldsSupplied($query)) {

            $key = array_key_first($query);

            if ($key == 'release_date') return self::searchTableByDate($key, $query[$key]);

            return self::searchTableByColumn($key, $query[$key]);
        }

        return 'invalid search key supplied';
    }


    /**
     * @param $table
     * @param $query
     * @return mixed
     */
    public function searchTableByColumn($table, $query): mixed
    {
        return $this->book->where($table, 'LIKE', "%$query%")->get();
    }

    /**
     * @param $table
     * @param $query
     * @return mixed
     */
    public function searchTableByDate($table, $query): mixed
    {
        return $this->book->whereDate($table, $query)->get();
    }

    /**
     * @param $data
     * @return int
     */
    public function isSearchableFieldsSupplied($data): int
    {
        return count(array_intersect(array_keys($data), Book::$searchableFields));
    }

    public function getBookById(mixed $id)
    {
        return $this->book->find($id);
    }

}
