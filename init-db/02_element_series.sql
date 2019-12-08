
CREATE TABLE IF NOT EXISTS `elements`.`series` (
    `id`                INT(11) NOT NULL,
    `firstEpisodeId`    INT(11) DEFAULT NULL,
    `name`              VARCHAR(255) NOT NULL,
    `slug`              VARCHAR(255) NOT NULL,
    `link`              VARCHAR(255) NOT NULL,
    `imageUrl`          VARCHAR(255) NOT NULL,
    `imageName`         VARCHAR(255) NOT NULL,
    `description`       TEXT NOT NULL,
    `createdAt`         DATETIME NOT NULL,
    `updatedAt`         DATETIME NOT NULL,

    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `elements`.`series_episodes`(
    `id`            INT(11) NOT NULL,
    `seriesId`      INT(11) NOT NULL,
    `name`          VARCHAR(255) NOT NULL,
    `link`          VARCHAR(255) NOT NULL,
    `downloadName`  VARCHAR(255) NOT NULL,
    `downloadLink`  VARCHAR(255) NOT NULL,
    `createdAt`     DATETIME NOT NULL,
    `updatedAt`     DATETIME NOT NULL,

    PRIMARY KEY (`id`),

    CONSTRAINT `fk_series_episodes_series_id` FOREIGN KEY (`seriesId`) REFERENCES `elements`.`series`(`id`)
);