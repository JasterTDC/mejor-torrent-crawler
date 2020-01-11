
CREATE TABLE IF NOT EXISTS `elements`.`tag` (
    `id`    INT(11) AUTO_INCREMENT NOT NULL,
    `name`  VARCHAR(255) NOT NULL,
    `createdAt` DATETIME NOT NULL,
    `updatedAt` DATETIME NOT NULL,

    PRIMARY KEY (`id`),
    KEY `name`
)ENGINE=InnoDB DEFAULT CHARSET=utf8;