<?php

namespace Src\Controllers;

use Core\View;
use Src\Models\Book;
use Core\Request;
use Exception;
use Src\Models\Author;

/**
 * Class AdminController
 * @package Src\Controllers
 */
class AdminController
{
    public const PER_PAGE = 4;

    /**
     * @var View
     */
    private View $view;

    /**
     * @var Book
     */
    private Book $book;

    /**
     * @var Author
     */
    private Author $author;

    /**
     * ItemController constructor.
     */
    public function __construct()
    {
        $this->book = new Book();
        $this->author = new Author();
        $this->view = new View();
    }

    /**
     * Get all items
     *
     * @param  Request  $request
     * @return false|string
     * @throws Exception|Exception
     */
    public function index(Request $request)
    {
        $query = $this->book->query()
            ->select($this->book->getTable(),
                ["books.id id, books.name name, year, view_count, like_count, about, GROUP_CONCAT(authors.name ORDER BY authors.name SEPARATOR ', ' ) authors"])
            ->leftJoin('books_authors', 'books.id', '=', 'books_authors.book_id')
            ->leftJoin('authors', 'authors.id', '=', 'books_authors.author_id')
            ->where('deleted_at', null, 'is')
            ->groupBy('books.id', 'books.name');

        if ($request->search) {
            $query->where('books.name', "%$request->search%", 'LIKE');
        }

        return $this->view->render('admin.main', [
            'books' => $query->paginate(self::PER_PAGE, $request->page ?? 1)
        ]);
    }

    /**
     * @param  Request  $request
     * @throws Exception
     */
    public function create(Request $request)
    {
        $data = $request->validated();
        $authors = [];
        if (isset($data['authors'])) {
            foreach ($data['authors'] as $author) {
                if ($author !== '') {
                    $authors[] = $this->author->create(['name' => $author]);
                }
            }
            unset($data['authors']);
        }

        $book = $this->book->create($data);
        foreach ($authors as $author) {
            $this->book->query()->insert('books_authors',
                ['book_id' => $book['id'], 'author_id' => $author['id']])->exec();
        }

        if (isset($_FILES['file'])) {
            $fileType = $imageFileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            move_uploaded_file($_FILES['file']['tmp_name'], "images/books/$book[id].$fileType");
        }

        header('Location: /admin');
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
        $data = $request->validated();
        if (isset($data['authors'])) {
            unset($data['authors']);
        }

        $this->book->query()->update($this->book->getTable(), $data)->where('id', $id)->exec();

        header('Location: /admin');
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @throws Exception
     */
    public function delete(Request $request, int $id)
    {
        $this->book->query()
            ->update($this->book->getTable(), ['deleted_at' => date('Y-m-d H:i:s')])
            ->where('id', $id)
            ->exec();
    }
}