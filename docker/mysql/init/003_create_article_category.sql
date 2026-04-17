CREATE TABLE IF NOT EXISTS article_category (
    article_id  INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,

    PRIMARY KEY (article_id, category_id),

    CONSTRAINT fk_ac_article
        FOREIGN KEY (article_id)
        REFERENCES articles (id)
        ON DELETE CASCADE,

    CONSTRAINT fk_ac_category
        FOREIGN KEY (category_id)
        REFERENCES categories (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
