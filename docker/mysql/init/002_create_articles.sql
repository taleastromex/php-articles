CREATE TABLE IF NOT EXISTS articles (
    id          INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(255)  NOT NULL,
    slug        VARCHAR(255)  NOT NULL UNIQUE,
    description TEXT          NOT NULL,
    content     LONGTEXT      NOT NULL,
    image       VARCHAR(500)  NULL,
    views       INT UNSIGNED  NOT NULL DEFAULT 0,
    created_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
