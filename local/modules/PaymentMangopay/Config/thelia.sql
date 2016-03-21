
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- mangopay_configuration
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mangopay_configuration`;

CREATE TABLE `mangopay_configuration`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fees` FLOAT NOT NULL,
    `clientid` VARCHAR(255) NOT NULL,
    `clientpassword` VARCHAR(255) NOT NULL,
    `temporaryfolder` VARCHAR(255) NOT NULL,
    `deferred_payment` TINYINT DEFAULT 0 NOT NULL,
    `days` INTEGER DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- order_preauthorisation
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `order_preauthorisation`;

CREATE TABLE `order_preauthorisation`
(
    `order_id` INTEGER NOT NULL,
    `preauthorization` INTEGER NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`order_id`,`preauthorization`),
    INDEX `idx_order_preauth` (`order_id`, `preauthorization`),
    CONSTRAINT `order_preauthorisation_order_id`
        FOREIGN KEY (`order_id`)
        REFERENCES `order` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mangopay_wallet
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mangopay_wallet`;

CREATE TABLE `mangopay_wallet`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user` INTEGER NOT NULL,
    `wallet` INTEGER NOT NULL,
    `thelia_seller` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
