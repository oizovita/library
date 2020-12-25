<?php

namespace Src\Controllers;

use Src\Models\Book;
use Core\Request;
use Core\View;
use Exception;

/**
 * Class ItemController
 */
class BookController
{
    public const PER_PAGE = 18;

    /**
     * @var Book
     */
    private Book $book;
    /**
     * @var View
     */
    private View $view;

    /**
     * ItemController constructor.
     */
    public function __construct()
    {
        $this->book = new Book();
        $this->view = new View();
    }

    /**
     * Get all items
     *
     * @param  Request  $request
     * @return false|string
     * @throws Exception
     */
    public function index(Request $request)
    {
        $query = $this->book->query()
            ->select($this->book->getTable(),
                ["books.id id, books.name name, year, GROUP_CONCAT(authors.name ORDER BY authors.name SEPARATOR ', ') author"])
            ->leftJoin('books_authors', 'books.id', '=', 'books_authors.book_id')
            ->leftJoin('authors', 'authors.id', '=', 'books_authors.author_id')
            ->where('deleted_at', null, 'is')
            ->groupBy('books.id', 'books.name');

        if ($request->search) {
            $query->where('books.name', "%$request->search%", 'LIKE');
        }

        return $this->view->render('books.books', [
            'books' => $query->paginate($request->per_page ?? self::PER_PAGE, $request->page ?? 1)
        ]);
    }

    /**
     * Get one item by id
     *
     * @param  Request  $request
     * @param $id
     * @return false|string
     * @throws Exception
     */
    public function show(Request $request, int $id)
    {
        $book = $this->book->query()
            ->select($this->book->getTable(),
                ["books.id id, books.name name, year, GROUP_CONCAT(authors.name ORDER BY authors.name SEPARATOR ', ') author, pages, about"])
            ->leftJoin('books_authors', 'books.id', '=', 'books_authors.book_id')
            ->leftJoin('authors', 'authors.id', '=', 'books_authors.author_id')
            ->where('books.id', $id)
            ->where('deleted_at', null, 'is')
            ->groupBy('books.id', 'books.name')
            ->first();

        if (!$book) {
            return $this->view->render('errors.404');
        }

        return $this->view->render('books.book', ['book' => $book]);
    }

    /**
     * Update book by id
     *
     * @param  Request  $request
     * @param $id
     * @return false|string
     * @throws Exception
     */
    public function update(Request $request, int $id)
    {

        if ($request->view_count) {
            $this->book->query()
                ->update($this->book->getTable(), ['view_count' => 1], true)
                ->where('id', $id)->exec();
        }

        if ($request->like_count) {
            $this->book->query()
                ->update($this->book->getTable(), ['like_count' => 1], true)
                ->where('id', $id)->exec();
        }

        return json_encode(['status' => 200]);
    }

}