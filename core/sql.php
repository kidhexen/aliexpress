<?php
	
/*
*	SQL DataBase
*/

// Custom fields
$sql = array(

	"CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}ae_products` (
		`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
		`productId` BIGINT(20) NOT NULL,
		`post_id` BIGINT(20) NOT NULL,
		`categoryAE` VARCHAR(255) NOT NULL,
		`categoryId` TEXT NOT NULL,
		`categoryName` VARCHAR(40) NOT NULL,
		`subject` TEXT NOT NULL,
		`summary` LONGTEXT NOT NULL,
		`description` LONGTEXT NOT NULL,
		`keywords` TEXT NOT NULL,
		`detailUrl` TEXT NOT NULL,
		`imageUrl` TEXT NOT NULL,
		`subImageUrl` TEXT NOT NULL,
		`attribute` TEXT NOT NULL,
		`freeShippingCountry` TEXT NOT NULL,
		`availability` INT(1) NOT NULL,
		`lotNum` INT(11) NOT NULL,
		`commission` VARCHAR(255) NOT NULL,
		`commissionRate` VARCHAR(255) NOT NULL,
		`promotionVolume` VARCHAR(255) NOT NULL,
		`packageType` VARCHAR(10) NOT NULL,
		`price` VARCHAR(40) NOT NULL,
		`salePrice` VARCHAR(40) NOT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB {$charset_collate};",
	
	"CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}product_review` (
      `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
      `post_id` BIGINT(20) unsigned NOT NULL,
      `name` VARCHAR(40) NOT NULL,
      `feedback` TEXT NOT NULL,
      `date` DATETIME DEFAULT '0000-00-00 00:00:00',
      `flag` CHAR(2) NOT NULL,
      `star` DECIMAL(2,1) NOT NULL,
        PRIMARY KEY (`id`),
        KEY (`post_id`)
    ) ENGINE=InnoDB {$charset_collate};",
);