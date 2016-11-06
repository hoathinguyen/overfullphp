-- Create database and use
CREATE DATABASE overfull;
USE overfull;

CREATE TABLE IF NOT EXISTS users
(
	id 				INT PRIMARY KEY AUTO_INCREMENT,
	username		VARCHAR(30),
	password		VARCHAR(255)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO users(username, password) VALUES ('overfull', '202cb962ac59075b964b07152d234b70');

CREATE TABLE IF NOT EXISTS locales
(
	id 		INT PRIMARY KEY AUTO_INCREMENT,
	name 	VARCHAR(50),
	sign 	VARCHAR(10)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS versions
(
	id 				INT PRIMARY KEY AUTO_INCREMENT,
	name			VARCHAR(10),
	description		VARCHAR(255)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO versions(name,description) VALUES ('1.x', '');

CREATE TABLE IF NOT EXISTS categories
(
	id 			INT PRIMARY KEY AUTO_INCREMENT,
	name		VARCHAR(50)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO categories(name) VALUES ('framework'),('package'),('weight');

-- Create docs table
CREATE TABLE IF NOT EXISTS docs
(
	id 				INT PRIMARY KEY AUTO_INCREMENT,
	title 			VARCHAR(50),
	category_id 	INT,
	token			VARCHAR(255),
	version_id		INT,
	content			TEXT,
	icon			VARCHAR(255),
	FOREIGN KEY (version_id) REFERENCES versions(id),
	FOREIGN KEY (category_id) REFERENCES categories(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS files
(
	id 				INT PRIMARY KEY AUTO_INCREMENT,
	title			VARCHAR(50),
	category_id 	INT,
	version_id		INT,
	content			TEXT,
	url 			VARCHAR(255),
	FOREIGN KEY (version_id) REFERENCES versions(id),
	FOREIGN KEY (category_id) REFERENCES categories(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO files(title, category_id, version_id, content, url) VALUES ('Release 1.0.0', 1, 1, '', 'https://github.com/overfull/php-framework/archive/master.zip');

CREATE TABLE IF NOT EXISTS services
(
	id 				INT PRIMARY KEY AUTO_INCREMENT,
	title			VARCHAR(50),
	url				VARCHAR(255),
	description		VARCHAR(100),
	image			VARCHAR(255)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;