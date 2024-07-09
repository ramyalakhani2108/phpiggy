
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

CREATE TABLE IF NOT EXISTS transactions(
    tran_id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    tran_description VARCHAR(255) NOT NULL,
    tran_amount DECIMAL(10,2) NOT NULL,
    tran_date DATETIME NOT NULL,
    tran_created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    tran_updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    user_id BIGINT(20) unsigned NOT NULL,
    PRIMARY KEY(tran_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS receipts(
  receipt_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  original_filename varchar(255) NOT NULL,
  storage_filename varchar(255) NOT NULL,
  media_type varchar(255) NOT NULL,
  tran_id bigint(20) unsigned NOT NULL,
  PRIMARY KEY (receipt_id),
  FOREIGN KEY(tran_id) REFERENCES transactions (tran_id) ON DELETE CASCADE
);