CREATE TABLE `urls` (
    `url` TEXT NOT NULL,
    `hash` VARCHAR(10) NOT NULL
) ENGINE = InnoDB;

ALTER TABLE `urls` ADD UNIQUE(`hash`);