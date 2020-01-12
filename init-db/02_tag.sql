
CREATE TABLE IF NOT EXISTS `elements`.`general_tag` (
    `generalId` INT(11) NOT NULL,
    `tagId`     INT(11) NOT NULL,
    `createdAt` DATETIME NOT NULL,
    `updatedAt` DATETIME NOT NULL,

    PRIMARY KEY (`generalId`, `tagId`),

    CONSTRAINT `fk_general_tag_general_id`
    FOREIGN KEY (`generalId`) REFERENCES `elements`.`general`(`id`),

    CONSTRAINT `fk_general_tag_id`
    FOREIGN KEY (`tagId`) REFERENCES `elements`.`tag`(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;