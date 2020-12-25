<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="book_block col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="id" book-id="<?= $this->book["id"] ?>">
                <div id="bookImg" class="col-xs-12 col-sm-3 col-md-3 item" style="
    margin:;
">
                    <img src="/images/books/<?= $this->book["id"] ?>.jpg" alt="Responsive image" class="img-responsive">
                </div>
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 info">
                    <div class="bookInfo col-md-12">
                        <div id="title" class="titleBook"><?= $this->book["name"] ?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="bookLastInfo">
                            <div class="bookRow"><span class="properties">автор:</span><span
                                        id="author"><?= $this->book["author"] ?></span></div>
                            <div class="bookRow"><span class="properties">год:</span><span
                                        id="year"><?= $this->book["year"] ?></span></div>
                            <div class="bookRow"><span class="properties">страниц:</span><span
                                        id="pages"><?= $this->book["pages"] ?></span></div>
                        </div>
                    </div>
                    <div class="btnBlock col-xs-12 col-sm-12 col-md-12">
                        <button type="button" class="btnBookID btn-lg btn btn-success"
                                onclick="incrementLikeCount(<?= $this->book["id"] ?>)">Хочу читать!
                        </button>
                    </div>
                    <div class="bookDescription col-xs-12 col-sm-12 col-md-12 hidden-xs hidden-sm">
                        <h4>О книге</h4>
                        <hr>
                        <p id="description"><?= $this->book["about"] ?></p>
                    </div>
                </div>
                <div class="bookDescription col-xs-12 col-sm-12 col-md-12 hidden-md hidden-lg">
                    <h4>О книге</h4>
                    <hr>
                    <p class="description"><?= $this->book["about"] ?></p>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/book.js"></script>
</section>
