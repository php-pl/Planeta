
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- post
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `post`;


CREATE TABLE `post`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`blog_id` INTEGER,
	`created_at` DATETIME,
	`year` INTEGER,
	`month` INTEGER,
	`title` VARCHAR(255),
	`link` VARCHAR(255),
	`content` TEXT,
	`content_more` TEXT,
	`shortened` INTEGER,
	`deleted` INTEGER default 0,
	PRIMARY KEY (`id`),
	KEY `post_year_index`(`year`),
	KEY `post_month_index`(`month`),
	KEY `post_link_index`(`link`),
	INDEX `post_FI_1` (`blog_id`),
	CONSTRAINT `post_FK_1`
		FOREIGN KEY (`blog_id`)
		REFERENCES `blog` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- blog
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `blog`;


CREATE TABLE `blog`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`mid` INTEGER,
	`name` VARCHAR(64),
	`url` VARCHAR(128),
	`feed` VARCHAR(128),
	`author` VARCHAR(64),
	`email` VARCHAR(128),
	`file` VARCHAR(16),
	`verified` INTEGER default 0,
	`approved` INTEGER default 0,
	PRIMARY KEY (`id`),
	UNIQUE KEY `blog_name_unique` (`name`),
	UNIQUE KEY `blog_url_unique` (`url`),
	UNIQUE KEY `blog_feed_unique` (`feed`),
	KEY `blog_mid_index`(`mid`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- tag
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tag`;


CREATE TABLE `tag`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(16),
	`approved` INTEGER default 0,
	PRIMARY KEY (`id`),
	KEY `tag_name_index`(`name`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- post_tag
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `post_tag`;


CREATE TABLE `post_tag`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`post_id` INTEGER,
	`tag_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `post_tag_FI_1` (`post_id`),
	CONSTRAINT `post_tag_FK_1`
		FOREIGN KEY (`post_id`)
		REFERENCES `post` (`id`)
		ON DELETE CASCADE,
	INDEX `post_tag_FI_2` (`tag_id`),
	CONSTRAINT `post_tag_FK_2`
		FOREIGN KEY (`tag_id`)
		REFERENCES `tag` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- reader
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `reader`;


CREATE TABLE `reader`
(
	`date` DATE  NOT NULL,
	`cnt` INTEGER default 0,
	PRIMARY KEY (`date`)
)Type=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
