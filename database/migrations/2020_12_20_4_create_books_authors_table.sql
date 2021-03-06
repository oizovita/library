CREATE TABLE books_authors
(
    book_id   integer NOT NULL,
    author_id integer NOT NULL,
    PRIMARY KEY (book_id, author_id),
    FOREIGN KEY (book_id) REFERENCES books (id) on delete cascade,
    FOREIGN KEY (author_id) REFERENCES authors (id) on delete cascade
) ENGINE = InnoDB;