CREATE TABLE books
(
    id         INT(1) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    name       VARCHAR(255),
    about      VARCHAR(255),
    year       INT,
    author     VARCHAR(255),
    pages      INT,
    view_count INT default 0,
    like_count INT default 0,
    deleted_at timestamp
);