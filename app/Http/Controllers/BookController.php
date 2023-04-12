<?php
/*
* @author Adenagbe Emmanuel Adedayo
* @github https://github.com/emmadedayo
* @linkedIn https://www.linkedin.com/in/adenagbe-adedayo/
* @email emmadenagbe@gmail.com
* @project hardes
* @created Wed, Apr 2023
* @Time 2:51 pm
*/

namespace App\Http\Controllers;
use App\Http\Requests\CreateBook;
use App\Http\Requests\UpdateBook;
use App\Http\Resources\BookResource;
use App\Http\Resources\IceFireResouce;
use App\Http\Response\ApiResponse;
use App\Models\Book;
use App\Repository\BookRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{

    protected BookRepository $bookRepository;
    protected ApiResponse $apiResponse;
    protected BookResource $bookResource;


    /**
     * BooksController constructor.
     * @param BookRepository $bookRepository
     * @param ApiResponse $apiResponse
     * @param BookResource $bookResource
     */
    public function __construct(
        BookRepository $bookRepository,
        ApiResponse $apiResponse,
        BookResource $bookResource
    )
    {
        $this->bookRepository = $bookRepository;
        $this->apiResponse = $apiResponse;
        $this->bookResource = $bookResource;
    }

    /**
     *
     *  Book Collection
     *
     * An Endpoint to get all Book in the system
     *
     * @param Request $request
     * @return JsonResponse
     * @apiResourceCollection \App\Http\Resources\v1\Book\BookResourceCollection
     * @apiResourceModel \App\Models\Book
     */
    public function index(Request $request): JsonResponse
    {

        if ($request->all()) {
            $books = $this->bookRepository->searchBookTable($request->all());
            if (is_string($books)) return $this->apiResponse->respondWithError($books);
        } else {
            $books = $this->bookRepository->getAllBooks();
        }
        return $this->apiResponse->respondWithDataStatusAndCodeOnly(
            $this->bookResource->transformCollection($books->toArray()));
    }


    /**
     * @group Book management
     *
     *  Books Collection
     *
     * An Endpoint to store book in the system
     *
     * @param CreateBook $request
     * @param Book $book
     * @return JsonResponse
     * @apiResourceCollection \App\Http\Resources\v1\Book\BookResourceCollection
     * @apiResourceModel \App\Models\Book
     */
    public function store(CreateBook $request, Book $book)
    {
        $book = $book->create($request->toArray());
        $book['hide_id'] = true;
        return $this->apiResponse->respondWithDataStatusAndCodeOnly(
            ['book' => $this->bookResource->transform($book)], Response::HTTP_CREATED);
    }


    /**
     * @group Book management
     *
     *  Books Collection
     *
     * An Endpoint to get single Book detail in the system
     *
     * @param Book $book
     * @return JsonResponse
     * @apiResourceCollection \App\Http\Resources\v1\Book\BookResourceCollection
     * @apiResourceModel \App\Models\Book
     */
    public function show(Book $book): JsonResponse
    {
        return $this->apiResponse->respondWithDataStatusAndCodeOnly(
            $this->bookResource->transformer($book));
    }

    /**
     * An Endpoint to update the specified resource from storage.
     *
     * @param UpdateBook $request
     * @return mixed
     */
    public function update(UpdateBook $request, $id): mixed
    {
        $updatedBook = $this->bookRepository->updateBook($request, $id);
        if (is_string($updatedBook)) return $this->apiResponse->respondWithError($updatedBook);

        return $this->apiResponse->respondWithNoPagination(
            $this->bookResource->transformer($updatedBook),
            "The book $updatedBook->name was updated successfully");
    }


    /**
     * An Endpoint to Remove the specified resource from storage.
     *
     * @param Book $book
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Book $book): mixed
    {
        //check if the book exist in the database before deleting it else display erro book has been deleted
        $book = $this->bookRepository->getBookById($book->id);
        if($book){
            $book->delete();
            return $this->apiResponse->deletedResponse("The book $book->name was deleted successfully");
        }else{
            return $this->apiResponse->respondWithError("The book has been deleted");
        }
    }


    /**
     * An Endpoint to Get a book from external storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function externalBook(Request $request): mixed
    {
        $bookName = $request->name;
        //checking if the book was supplied
        if (empty($bookName)) return $this->apiResponse->respondWithError('Invalid Book name supplied');
        //finding the book
        $bookCollection = $this->bookRepository->findBookByName($bookName);
        //checking if it throws error

        if (is_string($bookCollection)) return $this->apiResponse->respondWithError('Error fetching the book from the api');
        //returning the final data
        return $this->apiResponse->respondWithDataStatusAndCodeOnly(new IceFireResouce($bookCollection));
    }

}
