DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` int(10) unsigned NOT NULL auto_increment,
  `slug` varchar(255) NOT NULL,
  `display` varchar(255) NOT NULL,
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`category_id`, `slug`, `display`) VALUES
(1, 'uncategorized', 'Uncategorized');


DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `contents` text NOT NULL,
  `posted_date` date NOT NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `posts` (`post_id`, `title`, `slug`, `contents`, `posted_date`) VALUES
(1, 'Hello World', 'hello-world', '<p>Here is a sample post that you should delete or edit to your liking!</p>', '2011-04-21');


DROP TABLE IF EXISTS `post_categories`;
CREATE TABLE `post_categories` (
  `post_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  KEY `post_id` (`post_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `post_categories` (`post_id`, `category_id`) VALUES
(1, 1);