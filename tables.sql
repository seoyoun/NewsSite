| Table | Create Table                                                                                                                                                 |
+-------+-----------------------+
| users | CREATE TABLE `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 |
+-------+--------------+
| Table   | Create Table                                                                                                                                                                                                                                                                                                                                                                                            |
+---------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| stories | CREATE TABLE `stories` (
  `story_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `body` longtext NOT NULL,
  `link` text DEFAULT NULL,
  PRIMARY KEY (`story_id`),
  KEY `username` (`username`),
  CONSTRAINT `stories_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 |
+---------+--------------------------------------
| Table | Create Table
+----------+------------+
| comments | CREATE TABLE `comments` (
  `comment_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `story_id` mediumint(8) unsigned NOT NULL,
  `username` varchar(30) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `story_id` (`story_id`),
  KEY `username` (`username`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`story_id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 |
+----------+------------+