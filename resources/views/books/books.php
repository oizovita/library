<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php foreach ($this->books['data'] as $book) { ?>
            <div data-book-id="<?= $book['id'] ?>" class="book_item col-xs-5 col-sm-3 col-md-2 col-lg-2">
                <div class="book">
                    <a href="books/<?= $book["id"] ?>" onclick="incrementViewCount(<?= $book["id"] ?>)">
                        <img src="images/books/<?= $book["id"] ?>.jpg"
                             alt=<?= $book["name"] ?>>
                        <div data-title=<?= $book["name"] ?> class="blockI" style="height: 46px;">
                            <div data-book-title=<?= $book["name"] ?> class="title size_text
                            "><?= $book["name"] ?>
                        </div>
                        <div data-book-author=<?= $book["author"] ?> class="author"><?= $book["author"] ?></div>
                    </a>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>
    <?php if ($this->books['meta']['total_page'] > 1) { ?>
        <div class="row">
            <nav class="col-md-5 offset-md-5">
                <ul class="pagination">
                    <li class="page-item <?php if ($this->books['meta']['page'] <= 1) {
                        echo 'disabled';
                    } ?>"
                    ">
                    <a class="page-link"
                       href="?page=<?= $this->books['meta']['page'] - 1 ?>">Previous</a>
                    </li>
                    <li class="page-item <?php if ($this->books['meta']['page'] >= $this->books['meta']['total_page']) {
                        echo 'disabled';
                    } ?>"
                    ">
                    <a class="page-link" href="?page=<?= $this->books['meta']['page'] + 1 ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php } ?>
    <script src="/js/book.js"></script>
</section>

