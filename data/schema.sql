CREATE TABLE `category` (
  `category_id` int(10) unsigned NOT NULL auto_increment,
  `slug` varchar(255) NOT NULL,
  `display` varchar(255) NOT NULL,
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `category` (`category_id`, `slug`, `display`) VALUES
(1, 'uncategorized', 'Uncategorized');

CREATE TABLE `post` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `post` (`post_id`, `title`, `slug`, `contents`, `posted_date`) VALUES
(1, 'Hello World', 'hello-world', '<p>Here is a sample post that you should delete or edit to your liking!</p>', '2011-04-21');

CREATE TABLE `post_category` (
  `post_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  KEY `post_id` (`post_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `post_category` (`post_id`, `category_id`) VALUES
(1, 1);