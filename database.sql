CREATE TABLE IF NOT EXISTS users  (
    user_id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    user_email VARCHAR(255) NOT NULL,
    user_pass VARCHAR(255) NOT NULL,
    user_age TINYINT(3) unsigned NOT NULL,
    user_country VARCHAR(255) NOT NULL,
    user_social_media_url VARCHAR(255) NOT NULL,
    user_created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    user_updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (user_id),
    UNIQUE KEY (user_email)
);