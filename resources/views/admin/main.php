<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="book_block">
            <div class="row">
                <div class="col-md-7">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Название книги</th>
                            <th scope="col">Авторы</th>
                            <th scope="col">Год</th>
                            <th scope="col">Кликов</th>
                            <th scope="col">Захотели</th>
                            <th scope="col">Действие</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($this->books['data'] as $book) { ?>

                            <tr>
                                <td data-bs-toggle="modal"
                                    data-bs-target="#exampleModal_<?= $book["name"] ?>"><?= $book["name"] ?></td>
                                <div class="modal" id="exampleModal_<?= $book["name"] ?>" tabindex="-1"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Редактирование
                                                    книги <?= $book["name"] ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <form action="admin/books/<?= $book["id"] ?>" method="post">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <img src="/images/books/<?= $book["id"] ?>.jpg"
                                                                     alt="Responsive image" class="img-responsive">
                                                            </div>
                                                            <div class="input-group">
                                                                <input type="file" name="file" class="form-control"
                                                                       id="file_modal">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="name" class="form-control"
                                                                       value="<?= $book["name"] ?>"
                                                                       placeholder="название">
                                                            </div>

                                                            <div class="input-group mb-3">
                                                                <input type="number" name="year" class="form-control"
                                                                       value="<?= $book["year"] ?>" placeholder="год">
                                                            </div>
                                                            <?php foreach (explode(', ',
                                                                $book["authors"]) as $author) { ?>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="authors[]"
                                                                           class="form-control"
                                                                           value="<?= $author ?>" placeholder="автор">
                                                                </div>
                                                            <?php } ?>
                                                            <div class="input-group">
                                                            <textarea class="form-control" name="about"
                                                                      placeholder="описание книги"
                                                                      aria-label="With textarea"><?= $book["about"] ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                        Отменить
                                                    </button>
                                                    <input type="submit" class="btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <td><?= $book["authors"] ?></td>
                                <td><?= $book["year"] ?></td>
                                <td><?= $book["view_count"] ?></td>
                                <td><?= $book["like_count"] ?></td>
                                <td>
                                    <button type="submit" class="btn btn-link" onclick="deleteBook(<?= $book["id"] ?>)">
                                        Удалить
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination col-md-4 offset-md-4">
                            <?php for ($i = 1; $i <= $this->books['meta']['total_page']; $i++) { ?>
                                <li class="page-item"><a class="page-link" href="?page=<?= $i ?>""><?= $i ?></a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-5">
                    <div class="card " style="width: 100%; height: 100%; padding: 10px 15px">
                        <form action="/admin/books" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text" name="name" required class="form-control"
                                               placeholder="название книги"
                                               aria-describedby="basic-addon1">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="number" name="year" required class="form-control"
                                               placeholder="год издания"
                                               aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="file" name="file" class="form-control" id="file" accept=".jpg, .jpeg, .png">
                                    </div>
                                    <div class="row">
                                        <span id="output"></span>
                                    </div>
                                </div>
                                <div class=" col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text" name="authors[]" class="form-control" placeholder="автор"
                                               aria-describedby="basic-addon1">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" name="authors[]" class="form-control" placeholder="автор"
                                               aria-describedby="basic-addon2">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" name="authors[]" class="form-control" placeholder="автор"
                                               aria-describedby="basic-addon2">
                                    </div>

                                    <div class="input-group">
                                    <textarea class="form-control" placeholder="описание книги"
                                              aria-label="With textarea"></textarea>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success">Success</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/admin.js"></script>
</section>

