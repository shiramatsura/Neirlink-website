CREATE DATABASE IF NOT EXISTS `website`;
USE `website`;

CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(320) NOT NULL,
    `account_name` varchar(64) NOT NULL,
    `username` varchar(64) NOT NULL,
    `password` varchar(64) NOT NULL,
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

delete from `users`;
insert into `users` (`email`, `account_name`, `username`, `password`, `user_id`) values ('lobelios@outlook.com', 'lobelios389', 'RulerOfInferneus', SHA2('RouxdeuxRatgris', 256), 2);
