CREATE TABLE `websim`.`hotlines` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `phone` VARCHAR(255) NULL,
  `created` INT NULL,
  `updated` INT NULL,
  `order` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));
DROP TRIGGER IF EXISTS `websim`.`hotlines_BEFORE_INSERT`;

DELIMITER $$
USE `websim`$$
CREATE DEFINER = CURRENT_USER TRIGGER `websim`.`hotlines_BEFORE_INSERT` BEFORE INSERT ON `hotlines` FOR EACH ROW
BEGIN
SET
  new.created = UNIX_TIMESTAMP(),
  new.updated = UNIX_TIMESTAMP()
;
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS `websim`.`hotlines_BEFORE_UPDATE`;

DELIMITER $$
USE `websim`$$
CREATE DEFINER = CURRENT_USER TRIGGER `websim`.`hotlines_BEFORE_UPDATE` BEFORE UPDATE ON `hotlines` FOR EACH ROW
BEGIN
SET
  new.updated = UNIX_TIMESTAMP()
;
END$$
DELIMITER ;
