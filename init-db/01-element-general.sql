CREATE DATABASE `elements`;

CREATE TABLE IF NOT EXISTS `elements`.`general`(
    `id`                    INT (11) NOT NULL,
    `link`                  VARCHAR(255) NOT NULL,
    `slug`                  VARCHAR(255) NOT NULL,
    `name`                  VARCHAR(255) NOT NULL,
    `publishedDate`         DATETIME DEFAULT NULL,
    `genre`                 VARCHAR(255) DEFAULT NULL,
    `format`                VARCHAR(255) DEFAULT NULL,
    `description`           TEXT DEFAULT NULL,
    `coverImg`              VARCHAR(255) DEFAULT NULL,
    `coverImgName`          VARCHAR(255) DEFAULT NULL,
    `downloadLink`          VARCHAR(255) DEFAULT NULL,
    `dir`                   VARCHAR(255) DEFAULT NULL,
    `yearDir`               VARCHAR(255) DEFAULT NULL,
    `monthDir`              VARCHAR(255) DEFAULT NULL,
    `downloadUrl`           VARCHAR(255) DEFAULT NULL,
    `downloadTorrentUrl`    VARCHAR(255) DEFAULT NULL,
    `downloadName`          VARCHAR(255) DEFAULT NULL,
    `createdAt`             DATETIME NOT NULL,
    `updatedAt`             DATETIME NOT NULL,

    PRIMARY KEY (`id`)
)Engine=InnoDB DEFAULT CHARSET=utf8;