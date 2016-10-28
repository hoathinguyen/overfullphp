-- Create database and use
CREATE DATABASE overfull;
USE overfull;

CREATE TABLE locales
(
	id 		INT PRIMARY KEY AUTO_INCREMENT,
	name 	VARCHAR(50),
	sign 	VARCHAR(10)
);
-- Create users table
CREATE TABLE docs
(
	id 			INT PRIMARY KEY AUTO_INCREMENT,
	title 	VARCHAR(50),
	category_id 	VARCHAR(255),
	token		VARCHAR(255)
);

CREATE TABLE doc_contents
(
	id 			INT PRIMARY KEY AUTO_INCREMENT,
	title		VARCHAR(50),
	content		TEXT,
	locale_id	INT,
	doc_id		INT,
	FOREIGN KEY locale_id REFERENCES locales(id),
	FOREIGN KEY doc_id REFERENCES docs(id)
);