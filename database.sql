
-- This is the database used for the project
CREATE DATABASE IF NOT EXISTS `user-login`;

use `user-login`;

CREATE TABLE IF NOT EXISTS `users`(
    username VARCHAR(50) NOT NULL PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phoneNumber VARCHAR(20) NOT NULL UNIQUE


);