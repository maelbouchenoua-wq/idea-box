-- create data base box
CREATE DATABASE IF NOT EXISTS box CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE box;

CREATE table info
(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title varchar(100) not null,
    description varchar not null,
    pseudo varchar(50) not null,
    createDate NOT NULL DEFAULT CURRENT_TIMESTAMP,
    nbVote int default 0
) ENGINE = InnoDB;
