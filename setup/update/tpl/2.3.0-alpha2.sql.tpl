SET FOREIGN_KEY_CHECKS = 0;

UPDATE `config` SET `value`='2.3.0-alpha2' WHERE `name`='thelia_version';
UPDATE `config` SET `value`='2' WHERE `name`='thelia_major_version';
UPDATE `config` SET `value`='3' WHERE `name`='thelia_minus_version';
UPDATE `config` SET `value`='0' WHERE `name`='thelia_release_version';
UPDATE `config` SET `value`='alpha2' WHERE `name`='thelia_extra_version';

-- Add column unsubscribed in newsletter table
ALTER TABLE `newsletter` ADD `unsubscribed` TINYINT(1) NOT NULL DEFAULT '0' AFTER `locale`;

-- add admin email
ALTER TABLE  `admin` ADD  `email` VARCHAR(255) NOT NULL AFTER `remember_me_serial` ;
ALTER TABLE  `admin` ADD  `password_renew_token` VARCHAR(255) NOT NULL AFTER `email` ;

-- add admin password renew message

SELECT @max := MAX(`id`) FROM `message`;
SET @max := @max+1;

INSERT INTO `message` (`id`, `name`, `secured`, `text_layout_file_name`, `text_template_file_name`, `html_layout_file_name`, `html_template_file_name`, `created_at`, `updated_at`) VALUES
(@max, 'new_admin_password', NULL, NULL, 'admin_password.txt', NULL, 'admin_password.html', NOW(), NOW());

INSERT INTO `message_i18n` (`id`, `locale`, `title`, `subject`, `text_message`, `html_message`) VALUES
{foreach $locales as $locale}
    (@max, '{$locale}', {intl l='Mail sent to an administrator who requested a new password' locale=$locale}, {intl l='New password request on {config key="store_name"}' locale=$locale}, NULL, NULL){if ! $locale@last},{/if}
{/foreach}
;

-- Insert a fake email address for administrators, to trigger the admin update dialog
-- at next admin login.

UPDATE `admin` set email = CONCAT('CHANGE_ME_', ID);

ALTER TABLE `admin` ADD UNIQUE `email_UNIQUE` (`email`);

-- additional config variables

SELECT @max_id := IFNULL(MAX(`id`),0) FROM `config`;

INSERT INTO `config` (`id`, `name`, `value`, `secured`, `hidden`, `created_at`, `updated_at`) VALUES
(@max_id + 1, 'minimum_admin_password_length', '4', 0, 0, NOW(), NOW()),
(@max_id + 2, 'enable_lost_admin_password_recovery', '1', 0, 0, NOW(), NOW())
;

INSERT INTO `config_i18n` (`id`, `locale`, `title`, `description`, `chapo`, `postscriptum`) VALUES
{foreach $locales as $locale}
    (@max_id + 1, '{$locale}', {intl l='The minimum length required for an administrator password' locale=$locale}, NULL, NULL, NULL),
    (@max_id + 2, '{$locale}', {intl l='Allow an administrator to recreate a lost password' locale=$locale}, NULL, NULL, NULL){if ! $locale@last},{/if}
{/foreach}
;

-- Additional hooks

SELECT @max_id := IFNULL(MAX(`id`),0) FROM `hook`;

INSERT INTO `hook` (`id`, `code`, `type`, `by_module`, `block`, `native`, `activate`, `position`, `created_at`, `updated_at`) VALUES
    (@max_id+1, 'sale.top', 1, 0, 0, 1, 1, 1, NOW(), NOW()),
    (@max_id+2, 'sale.bottom', 1, 0, 0, 1, 1, 1, NOW(), NOW()),
    (@max_id+3, 'sale.main-top', 1, 0, 0, 1, 1, 1, NOW(), NOW()),
    (@max_id+4, 'sale.main-bottom', 1, 0, 0, 1, 1, 1, NOW(), NOW()),
    (@max_id+5, 'sale.content-top', 1, 0, 0, 1, 1, 1, NOW(), NOW()),
    (@max_id+6, 'sale.content-bottom', 1, 0, 0, 1, 1, 1, NOW(), NOW()),
    (@max_id+7, 'sale.stylesheet', 1, 0, 0, 1, 1, 1, NOW(), NOW()),
    (@max_id+8, 'sale.after-javascript-include', 1, 0, 0, 1, 1, 1, NOW(), NOW()),
    (@max_id+9, 'sale.javascript-initialization', 1, 0, 0, 1, 1, 1, NOW(), NOW()),
    (@max_id+10, 'account-order.invoice-address-bottom', 1, 1, 0, 1, 1, 1, NOW(), NOW()),
    (@max_id+11, 'account-order.delivery-address-bottom', 1, 1, 0, 1, 1, 1, NOW(), NOW())
;

INSERT INTO  `hook_i18n` (`id`, `locale`, `title`, `description`, `chapo`) VALUES
{foreach $locales as $locale}
    (@max_id+1, '{$locale}', {intl l='Sale - at the top' locale=$locale}, NULL, NULL),
    (@max_id+2, '{$locale}', {intl l='Sale - at the bottom' locale=$locale}, NULL, NULL),
    (@max_id+3, '{$locale}', {intl l='Sale - at the top of the main area' locale=$locale}, NULL, NULL),
    (@max_id+4, '{$locale}', {intl l='Sale - at the bottom of the main area' locale=$locale}, NULL, NULL),
    (@max_id+5, '{$locale}', {intl l='Sale - before the main content area' locale=$locale}, NULL, NULL),
    (@max_id+6, '{$locale}', {intl l='Sale - after the main content area' locale=$locale}, NULL, NULL),
    (@max_id+7, '{$locale}', {intl l='Sale - CSS stylesheet' locale=$locale}, NULL, NULL),
    (@max_id+8, '{$locale}', {intl l='Sale - after javascript include' locale=$locale}, NULL, NULL),
    (@max_id+9, '{$locale}', {intl l='Sale - javascript initialization' locale=$locale}, NULL, NULL),
    (@max_id+10, '{$locale}', {intl l='Order details - after invoice address' locale=$locale}, NULL, NULL),
    (@max_id+11, '{$locale}', {intl l='Order details - after delivery address' locale=$locale}, NULL, NULL){if ! $locale@last},{/if}

{/foreach}
;





-- Update module version column

ALTER TABLE `module` MODIFY `version` varchar(25) NOT NULL DEFAULT '';

-- Add new column in coupon table
ALTER TABLE `coupon` ADD `start_date` DATETIME AFTER`is_enabled`;
ALTER TABLE `coupon` ADD INDEX `idx_start_date` (`start_date`);

-- Add new column in coupon version table
ALTER TABLE `coupon_version` ADD `start_date` DATETIME AFTER`is_enabled`;

-- Add new column in order coupon table
ALTER TABLE `order_coupon` ADD `start_date` DATETIME AFTER`description`;

-- Update product's position
ALTER TABLE  `product_category` ADD  `position` INT NOT NULL DEFAULT  '0' AFTER  `default_category` ;
UPDATE product_category AS t1 SET position = (SELECT position FROM product AS t2 WHERE t2.id=t1.product_id) WHERE default_category = 1;
DROP PROCEDURE IF EXISTS update_position;
DELIMITER //
CREATE PROCEDURE update_position()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE mproduct, mcategory,maxposition INT;
    DECLARE cur1 CURSOR FOR SELECT product_id, category_id FROM product_category WHERE default_category = NULL OR default_category = 0;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    OPEN cur1;
        read_loop: LOOP
            FETCH cur1 INTO mproduct,mcategory;
            IF done THEN
                LEAVE read_loop;
            END IF;
            SELECT MAX(position)+1 into maxposition FROM product_category WHERE category_id = mcategory;
            UPDATE product_category SET position = maxposition WHERE category_id = mcategory AND product_id = mproduct;
        END LOOP;
    CLOSE cur1;
END//
DELIMITER ;
CALL update_position();
DROP PROCEDURE IF EXISTS update_position;

SET FOREIGN_KEY_CHECKS = 1;
