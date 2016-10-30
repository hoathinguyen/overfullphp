-- Create database and use
CREATE DATABASE overfull;
USE overfull;

CREATE TABLE IF NOT EXISTS locales
(
	id 		INT PRIMARY KEY AUTO_INCREMENT,
	name 	VARCHAR(50),
	sign 	VARCHAR(10)
);

CREATE TABLE IF NOT EXISTS versions
(
	id 				INT PRIMARY KEY AUTO_INCREMENT,
	name			VARCHAR(10),
	description		VARCHAR(255)
);

-- Create users table
CREATE TABLE IF NOT EXISTS docs
(
	id 				INT PRIMARY KEY AUTO_INCREMENT,
	name 			VARCHAR(50),
	category_id 	VARCHAR(255),
	token			VARCHAR(255),
	version_id		INT,
	FOREIGN KEY (version_id) REFERENCES versions(id)
);

CREATE TABLE IF NOT EXISTS doc_contents
(
	id 			INT PRIMARY KEY AUTO_INCREMENT,
	title		VARCHAR(50),
	content		TEXT,
	locale_id	INT,
	doc_id		INT,
	FOREIGN KEY (locale_id) REFERENCES locales(id),
	FOREIGN KEY (doc_id) REFERENCES docs(id)
);