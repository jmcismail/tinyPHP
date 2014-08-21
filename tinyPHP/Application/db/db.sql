DROP TABLE IF EXISTS `option`;
CREATE TABLE `option` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(60) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `option` VALUES(1, 'site_title', 'tinyPHP MVC Framework');
INSERT INTO `option` VALUES(2, 'cookieexpire', '604800');
INSERT INTO `option` VALUES(3, 'cookiepath', '/');
INSERT INTO `option` VALUES(4, 'core_locale', 'en_US');

DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `ID` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `permKey` varchar(30) NOT NULL,
  `permName` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `permKey` (`permKey`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `permission` VALUES(00000000000000000001, 'create_user', 'Create User');
INSERT INTO `permission` VALUES(00000000000000000002, 'edit_user', 'Edit User');
INSERT INTO `permission` VALUES(00000000000000000003, 'delete_user', 'Delete User');
INSERT INTO `permission` VALUES(00000000000000000004, 'manage_permissions', 'Manage Permissions');
INSERT INTO `permission` VALUES(00000000000000000005, 'manage_roles', 'Manage Roles');
INSERT INTO `permission` VALUES(00000000000000000006, 'manage_user_permissions', 'Manage User Permissions');
INSERT INTO `permission` VALUES(00000000000000000007, 'manage_user_roles', 'Manage User Roles');
INSERT INTO `permission` VALUES(00000000000000000008, 'access_dashboard', 'Access Dashboard');
INSERT INTO `permission` VALUES(00000000000000000009, 'access_help_page', 'Access Help Page');
INSERT INTO `permission` VALUES(00000000000000000010, 'manage_users', 'Manage Users');

DROP TABLE IF EXISTS `plugin`;
CREATE TABLE `plugin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `ID` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `roleName` varchar(20) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `roleName` (`roleName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `role` VALUES(00000000000000000001, 'Administrator', 'a:10:{i:0;s:11:"create_user";i:1;s:9:"edit_user";i:2;s:11:"delete_user";i:3;s:18:"manage_permissions";i:4;s:12:"manage_roles";i:5;s:23:"manage_user_permissions";i:6;s:17:"manage_user_roles";i:7;s:16:"access_dashboard";i:8;s:16:"access_help_page";i:9;s:12:"manage_users";}');
INSERT INTO `role` VALUES(00000000000000000002, 'User', 'a:2:{i:0;s:16:"access_dashboard";i:1;s:16:"access_help_page";}');

DROP TABLE IF EXISTS `role_perms`;
CREATE TABLE `role_perms` (
  `ID` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `roleID` bigint(20) NOT NULL,
  `permID` bigint(20) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `addDate` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `roleID_2` (`roleID`,`permID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(80) NOT NULL,
  `fname` varchar(180) NOT NULL,
  `lname` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `user` VALUES(1, 'stewartm', 'Martha', 'Stewart', '$2a$08$fIh85MQhUz19WnN9PbfcKe56di6PS3NQwTGf.sdO5vzxMFzqt/Ov2', 'NULL', '2014-08-21 04:41:00');
INSERT INTO `user` VALUES(2, 'tinyphp', 'tiny', 'PHP', '$2a$08$EDyYNRbOqNzNqm.H1c5aCOIt1gWpYJ4IIn163wMSOCbPlZGMgUIPe', 'NULL', '2014-08-21 00:40:15');
INSERT INTO `user` VALUES(3, 'jordanm', 'Michael', 'Jordan', '$2a$08$ZjrUxM7kbRc4Q1vgsj6Qb.P3eM1uh5cMjR5fHoOsiRlvXb5ND4vmC', 'NULL', '2014-08-21 05:12:02');

DROP TABLE IF EXISTS `user_perms`;
CREATE TABLE `user_perms` (
  `ID` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `permission` text NOT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `rID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `roleID` bigint(20) NOT NULL,
  `addDate` datetime NOT NULL,
  PRIMARY KEY (`rID`),
  UNIQUE KEY `userID` (`userID`,`roleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `user_roles` VALUES(5, 1, 2, '2014-08-21 02:27:42');
INSERT INTO `user_roles` VALUES(8, 2, 1, '2014-08-21 04:46:16');
INSERT INTO `user_roles` VALUES(9, 3, 2, '2014-08-21 04:49:07');


ALTER TABLE `user_perms`
  ADD CONSTRAINT `user_perms_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON UPDATE CASCADE;

ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON UPDATE CASCADE;