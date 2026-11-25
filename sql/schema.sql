-- create data base box
CREATE DATABASE IF NOT EXISTS box CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE box;

CREATE TABLE IF NOT EXISTS info (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  pseudo VARCHAR(50) NOT NULL,
  createDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

UNIQUE KEY unique_vote (info_id, pseudo),

    CONSTRAINT fk_votes_info
        FOREIGN KEY (info_id)
        REFERENCES info(id)
        ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
