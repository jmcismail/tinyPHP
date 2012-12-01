DROP TABLE IF EXISTS `tp_users`;
CREATE TABLE `tp_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('default','admin','owner') NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `tp_users` (`id`, `login`, `password`, `role`) VALUES(1, 'daniel', '$2a$08$fIh85MQhUz19WnN9PbfcKe56di6PS3NQwTGf.sdO5vzxMFzqt/Ov2', 'owner');
INSERT INTO `tp_users` (`id`, `login`, `password`, `role`) VALUES(2, 'tinyphp', '$2a$08$EDyYNRbOqNzNqm.H1c5aCOIt1gWpYJ4IIn163wMSOCbPlZGMgUIPe', 'owner');
INSERT INTO `tp_users` (`id`, `login`, `password`, `role`) VALUES(3, 'jeshua', '$2a$08$flVNLMDH6BNcnXBix1Gce.D/YQCtGP3AVZ3SxDar4NfWpjUEkEnvy', 'default');