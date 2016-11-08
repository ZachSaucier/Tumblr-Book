CREATE DATABASE IF NOT EXISTS TumblrBook;
USE TumblrBook;

DROP TABLE IF EXISTS users;
CREATE TABLE users(
	username VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL,
	PRIMARY KEY(username)
);

DROP TABLE IF EXISTS blogs;
CREATE TABLE blogs(
	blogname VARCHAR(255) UNIQUE NOT NULL,
	content MEDIUMTEXT NOT NULL,
	PRIMARY KEY(blogname)
);

DROP TABLE IF EXISTS userblogs;
CREATE TABLE userblogs(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL,
	blogname VARCHAR(255) NOT NULL
);

/* some test entries */
INSERT INTO users VALUES ('mattling', 'password');
INSERT INTO blogs VALUES ('solacingsavant', 'some content'), ('gocookyourself', 'recipes'), ('thirdblog', 'more content');
INSERT INTO userblogs (username, blogname) VALUES ('mattling', 'solacingsavant'), ('mattling', 'gocookyourself');