<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookSearchRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Customer;
use App\Services\BookService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookController extends Controller
{
    public function __construct(private readonly BookService $bookService)
    {
    }

    public function index(BookSearchRequest $request): ResourceCollection
    {
        $books = $this->bookService->search($request->validated('query'));

        return BookResource::collection($books->with('customer')->select(['id', 'customer_id', 'title'])->paginate(20));
    }

    public function show(Book $book): BookResource
    {
        return new BookResource($book->load('customer'));
    }

    /**
     * @throws Exception
     */
    public function borrow(Book $book, Customer $customer): JsonResponse
    {
        $this->bookService->borrow($book, $customer);

        return new JsonResponse(['success' => true]);
    }

    /**
     * @throws Exception
     */
    public function drop(Book $book): JsonResponse
    {
        $this->bookService->drop($book);

        return new JsonResponse(['success' => true]);
    }
}
