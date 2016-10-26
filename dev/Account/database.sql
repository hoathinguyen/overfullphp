-- Create users table
CREATE TABLE users
(
	id 			INT PRIMARY KEY AUTO_INCREMENT,
	name 		VARCHAR(50),
	password 	VARCHAR(255),
	email		VARCHAR(255)
)