CREATE TABLE IF NOT EXISTS `blog_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(32) DEFAULT NULL,
  `log_date` datetime DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `blog_log` CHANGE `slug` `blog_no` INT NULL DEFAULT '0';

ALTER TABLE `blog` ADD `ranking_flg` VARCHAR( 5 ) NULL DEFAULT 'open' COMMENT 'ランキング表示フラグ' AFTER `cta_flg` ;
