-- Create database and use
CREATE DATABASE overfull;
USE overfull;

-- Create users table
CREATE TABLE users
(
	id 			INT PRIMARY KEY AUTO_INCREMENT,
	username 	VARCHAR(50),
	password 	VARCHAR(255),
	email		VARCHAR(255),
	token		VARCHAR(255)
);

CREATE TABLE socials
(
	id 			INT PRIMARY KEY AUTO_INCREMENT,
	name		VARCHAR(50),
	token		VARCHAR(255),
	user_id		INT,
	FOREIGN KEY user_id REFERENCES users(id)
);